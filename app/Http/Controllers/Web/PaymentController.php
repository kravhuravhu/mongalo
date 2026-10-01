<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Book;
use App\Models\Order;
use App\Services\PaymentService;
use App\Services\PhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    protected PhoneService $phoneService;

    public function __construct(PaymentService $paymentService, PhoneService $phoneService)
    {
        $this->paymentService = $paymentService;
        $this->phoneService = $phoneService;
    }

    /* ─── INITIATE PAYMENT ─── */
    public function initiate(Request $request)
    {
        // ─── BASE VALIDATION ───
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'gateway' => 'nullable|string|in:payfast,yoco',
            'delivery_type' => 'nullable|in:digital,hardcopy',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $book = Book::findOrFail($request->book_id);
        $deliveryType = $request->input('delivery_type', 'digital');

        // ─── VALIDATE BOOK IS PURCHASABLE ───
        if ($book->is_free) {
            return response()->json(['success' => false, 'message' => 'This book is free. Please download directly.'], 400);
        }

        if ($book->is_free && $deliveryType !== 'hardcopy') {
            return response()->json(['success' => false, 'message' => 'This resource is free. Please download directly.'], 400);
        }

        // Free resources with hardcopy skip the digital download requirement
        if (!$book->is_free && !$book->book_file) {
            return response()->json(['success' => false, 'message' => 'This book is not available for purchase yet.'], 400);
        }

        if (!$book->book_file) {
            return response()->json(['success' => false, 'message' => 'This book is not available for purchase yet.'], 400);
        }

        if ($book->price <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid book price.'], 400);
        }

        // ─── HARDCOPY VALIDATION ───
        $shippingFee = 0.00;
        $hardcopyPrice = null;
        $addressData = [];

        if ($deliveryType === 'hardcopy') {
            if (!$book->has_hardcopy_option) {
                return response()->json(['success' => false, 'message' => 'Hard copy is not available for this book.'], 400);
            }

            $region = $request->input('delivery_region');
            $regions = config('shop.shipping', []);

            if (!$region || !isset($regions[$region])) {
                return response()->json(['success' => false, 'message' => 'Please select a valid delivery region.', 'field' => 'delivery_region'], 422);
            }

            // ─── REQUIRED ADDRESS FIELDS ───
            $hardcopyValidator = Validator::make($request->all(), [
                'delivery_address_1' => 'required|string|max:255',
                'delivery_city' => 'required|string|max:120',
                'delivery_province' => 'required|string|max:120',
                'delivery_postal_code' => 'required|string|max:20',
                'delivery_country' => 'required|string|max:80',
                'delivery_name' => 'nullable|string|max:255',
                'delivery_phone' => 'nullable|string|max:50',
            ]);

            if ($hardcopyValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please complete the delivery address.',
                    'errors'  => $hardcopyValidator->errors(),
                    'field'   => 'delivery',
                ], 422);
            }

            $shippingFee   = (float) $regions[$region]['fee'];
            $hardcopyPrice = (float) $book->hardcopy_price_raw;

            $addressData = [
                'delivery_region' => $region,
                'delivery_name' => $request->input('delivery_name', $request->name),
                'delivery_phone' => $request->input('delivery_phone', $request->phone),
                'delivery_email' => $request->email,
                'delivery_address_1' => $request->delivery_address_1,
                'delivery_address_2' => $request->delivery_address_2,
                'delivery_suburb' => $request->delivery_suburb,
                'delivery_city' => $request->delivery_city,
                'delivery_province' => $request->delivery_province,
                'delivery_postal_code' => $request->delivery_postal_code,
                'delivery_country' => $request->delivery_country,
                'delivery_notes' => $request->delivery_notes,
            ];
        }

        // ─── PHONE / EMAIL VALIDATION (as before) ───
        $validatedPhone = $this->phoneService->validatePhone($request->phone);
        if (!$validatedPhone['valid']) {
            return response()->json(['success' => false, 'message' => $validatedPhone['message'], 'field' => 'phone'], 422);
        }

        $validatedEmail = $this->validateEmail($request->email);
        if (!$validatedEmail['valid']) {
            return response()->json(['success' => false, 'message' => $validatedEmail['message'], 'field' => 'email'], 422);
        }

        // ─── CALCULATE TOTAL ───
        $basePrice = $deliveryType === 'hardcopy' ? $hardcopyPrice : (float) $book->price;
        $totalAmount = $basePrice + $shippingFee;

        $result = $this->paymentService->initiatePayment($book, [
            'name' => $request->name,
            'email' => $validatedEmail['email'],
            'phone' => $validatedPhone['formatted'],
            'amount' => $totalAmount,
            'delivery_type' => $deliveryType,
            'shipping_fee' => $shippingFee,
            'hardcopy_price' => $hardcopyPrice,
            'address' => $addressData,
        ], $request->gateway);

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message'] ?? 'Payment initiation failed.'], 400);
        }

        // ─── STORE ORDER NUMBER IN SESSION (FALLBACK) ───
        session()->put('payment_order_number', $result['order_number']);
        session()->put('payment_status', 'pending');

        Log::info('Payment initiated', [
            'order_number' => $result['order_number'],
            'delivery_type' => $deliveryType,
            'amount' => $totalAmount,
            'shipping_fee' => $shippingFee,
        ]);

        return response()->json($result);
    }

    /* ─── CHECKOUT PAGE ─── */
    public function checkout(Request $request, string $gateway, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('payment.success', ['order' => $orderNumber]);
        }

        $gatewayInstance = $this->paymentService->getGateway($gateway);

        if (!$gatewayInstance) {
            abort(404, 'Payment gateway not found.');
        }

        $paymentData = $gatewayInstance->initiate($order, [
            'name' => $order->buyer_name,
            'email' => $order->buyer_email,
            'phone' => $order->buyer_phone,
        ]);

        return view('public.payment.checkout', [
            'order' => $order,
            'gateway' => $gateway,
            'paymentData' => $paymentData,
        ]);
    }

    /* ─── PAYMENT RETURN (SUCCESS) ─── */
    public function return(Request $request, string $gateway)
    {
        // ─── GET DATA FROM REQUEST ───
        $data = $request->all();
        
        // ─── IF GET HAS NO DATA, CHECK POST BODY ───
        if (empty($data)) {
            $rawInput = file_get_contents('php://input');
            if ($rawInput) {
                parse_str($rawInput, $parsedData);
                if (!empty($parsedData)) {
                    $data = $parsedData;
                }
            }
        }
        
        Log::info('Payment return - redirect from gateway', [
            'gateway' => $gateway,
            'data' => $data,
            'method' => $request->method(),
            'query_string' => $request->getQueryString(),
            'session' => session()->all(),
        ]);

        // ─── PRIORITIZE REQUEST DATA OVER SESSION ───
        $orderNumber = $data['m_payment_id'] 
            ?? $data['order_number'] 
            ?? session('payment_order_number');
        
        if (!$orderNumber) {
            Log::warning('No order number found in return', ['data' => $data]);
            return redirect()->route('payment.failure')
                ->with('error', 'Payment information not found.');
        }

        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            Log::warning('Order not found', ['order_number' => $orderNumber]);
            return redirect()->route('payment.failure')
                ->with('error', 'Order not found.');
        }

        // ─── FIRST CHECK DATABASE - WEBHOOK MAY HAVE ALREADY UPDATED IT ───
        if ($order->payment_status === 'paid') {
            session()->forget(['payment_order_number', 'payment_status']);
            return redirect()->route('payment.success', ['order' => $orderNumber])
                ->with('success', 'Payment successful! Your book is now available for download.');
        }

        // ─── IF STILL PENDING, TRY TO VERIFY ───
        if ($order->payment_status === 'pending') {
            // ─── CHECK TRANSACTION ID ───
            $transactionId = $request->get('pf_payment_id') ?? $order->transaction_id;
            
            if ($transactionId) {
                $result = $this->paymentService->verifyPayment($transactionId, $gateway);
                if ($result['success']) {
                    $order->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $transactionId,
                    ]);
                    
                    // ─── SEND CONFIRMATION EMAIL ───
                    try {
                        Mail::to($order->buyer_email)->send(new OrderConfirmation($order));
                        Log::info('Order confirmation email sent from return', [
                            'order_number' => $order->order_number,
                        ]);
                    } catch (Throwable $e) {
                        Log::error('Failed to send order confirmation email from return', [
                            'order_number' => $order->order_number,
                            'error' => $e->getMessage(),
                        ]);
                    }
                    
                    session()->forget(['payment_order_number', 'payment_status']);
                    return redirect()->route('payment.success', ['order' => $orderNumber])
                        ->with('success', 'Payment successful! Your book is now available for download.');
                }
            }
            
            // ─── STILL PENDING - SHOW SUCCESS WITH PENDING MESSAGE ───
            return redirect()->route('payment.success', ['order' => $orderNumber])
                ->with('info', 'Your payment is being processed. You will receive an email confirmation shortly.');
        }

        // ─── IF NO DATA, REDIRECT TO FAILURE ───
        return redirect()->route('payment.failure')
            ->with('error', 'We could not confirm your payment. Please check your email for confirmation.');
    }

    /* ─── PAYMENT CANCEL ─── */
    public function cancel(Request $request, string $gateway)
    {
        Log::info('Payment cancelled', [
            'gateway' => $gateway,
            'data' => $request->all(),
        ]);

        $orderNumber = $request->get('m_payment_id') 
            ?? $request->get('order_number') 
            ?? session('payment_order_number');

        // ─── CLEAR SESSION ───
        session()->forget(['payment_order_number', 'payment_status']);

        if ($orderNumber) {
            return redirect()->route('payment.failure', ['order' => $orderNumber])
                ->with('warning', 'Payment was cancelled. You can try again when ready.');
        }

        return redirect()->route('payment.failure')
            ->with('warning', 'Payment was cancelled. You can try again when ready.');
    }

    /* ─── WEBHOOK (ITN) ─── */
    public function webhook(Request $request, string $gateway)
    {
        // ─── GET DATA FROM REQUEST ───
        $data = $request->all();
        
        // ─── IF NO DATA, CHECK POST BODY ───
        if (empty($data)) {
            $rawInput = file_get_contents('php://input');
            parse_str($rawInput, $parsedData);
            if (!empty($parsedData)) {
                $data = $parsedData;
            }
        }
        
        Log::info('Payment webhook (ITN) received', [
            'gateway' => $gateway,
            'data' => $data,
            'ip' => $request->ip(),
        ]);

        // ─── IF STILL NO DATA, RETURN ERROR ───
        if (empty($data)) {
            Log::error('Empty webhook data received');
            return response('ERROR: No data received', 400);
        }

        // ─── PROCESS THE PAYMENT ───
        $result = $this->paymentService->processPaymentResponse($data, $gateway);

        // ─── IF PAYMENT SUCCESSFUL ───
        if ($result['success']) {
            $orderNumber = $result['order_number'] ?? null;
            
            if ($orderNumber) {
                // ─── STORE IN SESSION FOR RETURN URL ───
                session()->put('payment_order_number', $orderNumber);
                session()->put('payment_status', 'paid');
                
                Log::info('Payment successful - session stored', [
                    'order_number' => $orderNumber,
                ]);
            }
            
            // ─── RESPOND TO PAYFAST ───
            return response('OK', 200);
        }

        Log::error('Webhook processing failed', [
            'result' => $result,
            'data' => $data,
        ]);
        
        return response('ERROR', 400);
    }

    /* ─── PAYMENT SUCCESS ─── */
    public function success(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $book = $order->book;

        // ─── IF STILL PENDING, TRY TO VERIFY ───
        if ($order->payment_status === 'pending' && $order->transaction_id) {
            $result = $this->paymentService->verifyPayment($order->transaction_id, $order->payment_method);
            if ($result['success']) {
                $order->update(['payment_status' => 'paid']);
                session()->forget(['payment_order_number', 'payment_status']);
            }
        }

        return view('public.payment.success', [
            'order' => $order,
            'book' => $book,
        ]);
    }

    /* ─── PAYMENT FAILURE ─── */
    public function failure(Request $request, ?string $orderNumber = null)
    {
        $order = null;
        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
        }

        // ─── CLEAR SESSION ───
        session()->forget(['payment_order_number', 'payment_status']);

        return view('public.payment.failure', [
            'order' => $order,
            'message' => session('error') ?? session('warning') ?? 'Payment was not completed.',
        ]);
    }

    /* ─── DOWNLOAD BOOK ─── */
    public function download(Request $request, string $token)
    {
        $order = Order::where('download_token', $token)
            ->where('payment_status', 'paid')
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        $book = $order->book;

        if (!$book->book_file) {
            abort(404, 'Book file not found.');
        }

        $filePath = storage_path('app/public/books/files/' . $book->book_file);

        if (!file_exists($filePath)) {
            Log::error('Book file not found', [
                'book_id' => $book->id,
                'file' => $book->book_file,
            ]);
            abort(404, 'Book file not found.');
        }

        // ─── INCREMENT DOWNLOADS ───
        $order->increment('download_count');
        $book->increment('download_count');

        Log::info('Book downloaded', [
            'order_number' => $order->order_number,
            'book_title' => $book->title,
            'user_email' => $order->buyer_email,
        ]);

        $fileName = $book->slug . '.' . $book->file_type;

        return response()->download($filePath, $fileName, [
            'Content-Type' => $this->getMimeType($book->file_type),
        ]);
    }

    /* ─── GET MIME TYPE ─── */
    protected function getMimeType(string $fileType): string
    {
        return match ($fileType) {
            'pdf' => 'application/pdf',
            'epub' => 'application/epub+zip',
            'mobi' => 'application/x-mobipocket-ebook',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
    }

    /* ─── VALIDATE EMAIL ─── */
    protected function validateEmail(string $email): array
    {
        // ─── CHECK IF EMAIL IS EMPTY ───
        if (empty($email)) {
            return [
                'valid' => false,
                'message' => 'Email address is required for payment.',
                'email' => null,
            ];
        }

        // ─── BASIC EMAIL VALIDATION ───
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'valid' => false,
                'message' => 'Please enter a valid email address (e.g., name@example.com).',
                'email' => null,
            ];
        }

        // ─── CHECK FOR COMMON TYPOS ───
        $domain = substr(strrchr($email, "@"), 1);
        $commonDomains = [
            'gmail.com' => 'gmail.com',
            'yahoo.com' => 'yahoo.com',
            'outlook.com' => 'outlook.com',
            'hotmail.com' => 'hotmail.com',
            'icloud.com' => 'icloud.com',
            'protonmail.com' => 'protonmail.com',
            'co.za' => 'co.za',
            // Common typos
            'za' => 'co.za',
            'gmail.co' => 'gmail.com',
            'gmai.com' => 'gmail.com',
            'gmal.com' => 'gmail.com',
            'yaho.com' => 'yahoo.com',
            'hotmail.co' => 'hotmail.com',
        ];

        // ─── CHECK FOR TYPOS IN COMMON DOMAINS ───
        foreach ($commonDomains as $typo => $correct) {
            if ($domain === $typo) {
                $correctedEmail = str_replace($typo, $correct, $email);
                return [
                    'valid' => true,
                    'message' => 'Did you mean ' . $correctedEmail . '?',
                    'email' => $correctedEmail,
                    'warning' => true,
                ];
            }
        }

        return [
            'valid' => true,
            'message' => 'Email is valid.',
            'email' => $email,
            'warning' => false,
        ];
    }
}