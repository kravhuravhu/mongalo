<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            color: #1a1a2e;
            line-height: 1.6;
            background: #f7f5f2;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(166, 124, 78, 0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #2d2d44 100%);
            padding: 32px 40px 28px;
            border-bottom: 4px solid #a67c4e;
        }
        .email-header h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #ffffff;
            margin: 0;
        }
        .email-header h1 span {
            color: #a67c4e;
        }
        .email-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            margin-top: 4px;
        }
        .email-body {
            padding: 40px 40px 32px;
        }
        .email-body h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .email-body .greeting {
            color: #6a6a7a;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .order-details {
            background: #f7f5f2;
            border-radius: 12px;
            padding: 20px 24px;
            margin: 20px 0;
            border: 1px solid rgba(166, 124, 78, 0.06);
        }
        .order-details h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: #a67c4e;
            margin-bottom: 12px;
        }
        .order-details .row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(166, 124, 78, 0.06);
        }
        .order-details .row:last-child {
            border-bottom: none;
        }
        .order-details .label {
            color: #6a6a7a;
            font-weight: 500;
            font-size: 0.85rem;
        }
        .order-details .value {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1a1a2e;
        }
        .order-details .value-highlight {
            color: #a67c4e;
            font-family: monospace;
            font-weight: 700;
        }
        .download-section {
            background: rgba(166, 124, 78, 0.04);
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0 20px;
            text-align: center;
            border: 2px solid rgba(166, 124, 78, 0.08);
        }
        .download-section .icon {
            font-size: 2.4rem;
            color: #a67c4e;
            opacity: 0.3;
            margin-bottom: 8px;
        }
        .download-section h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #1a1a2e;
            margin-bottom: 4px;
        }
        .download-section p {
            color: #6a6a7a;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 32px;
            border-radius: 50px;
            background: #a67c4e;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #c69a6a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(166, 124, 78, 0.2);
        }
        .btn i {
            margin-right: 6px;
        }
        .btn-secondary {
            background: transparent;
            color: #6a6a7a;
            border: 1.5px solid rgba(166, 124, 78, 0.12);
        }
        .btn-secondary:hover {
            background: rgba(166, 124, 78, 0.04);
            border-color: #a67c4e;
            color: #1a1a2e;
            box-shadow: none;
        }
        .email-footer {
            padding: 24px 40px;
            border-top: 1px solid rgba(166, 124, 78, 0.06);
            text-align: center;
            background: #faf9f7;
        }
        .email-footer p {
            font-size: 0.75rem;
            color: #6a6a7a;
            margin: 4px 0;
        }
        .email-footer a {
            color: #a67c4e;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
        .email-footer .divider {
            color: rgba(166, 124, 78, 0.12);
            margin: 0 6px;
        }
        .badge {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .badge-paid {
            background: #d4edda;
            color: #155724;
        }
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        @media (max-width: 540px) {
            .email-body { padding: 24px 20px; }
            .email-header { padding: 24px 20px; }
            .email-footer { padding: 20px; }
            .order-details .row { flex-direction: column; padding: 4px 0; }
            .download-section { padding: 16px; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="email-container">

    {{-- HEADER --}}
    <div class="email-header">
        <h1>{{ env('PROJECT_NAME', 'The Collective') }} <span>· Order</span></h1>
        <p>Thank you for your purchase</p>
    </div>

    {{-- BODY --}}
    <div class="email-body">
        <h2>Order Confirmation</h2>
        <p class="greeting">Hello <strong>{{ $buyerName }}</strong>,</p>
        <p style="color: #6a6a7a; font-size: 0.95rem; margin-bottom: 16px;">
            Thank you for your purchase. Your order has been confirmed and your book is ready for download.
        </p>

        {{-- ORDER DETAILS --}}
        <div class="order-details">
            <h3><i class="fas fa-receipt" style="margin-right: 8px;"></i> Order Details</h3>
            <div class="row">
                <span class="label">Order Number</span>
                <span class="value value-highlight">{{ $orderNumber }}</span>
            </div>
            <div class="row">
                <span class="label">Book</span>
                <span class="value">{{ $book->title }}</span>
            </div>
            <div class="row">
                <span class="label">Amount Paid</span>
                <span class="value" style="color: #a67c4e; font-weight: 700;">R{{ number_format($order->amount, 2) }}</span>
            </div>
            <div class="row">
                <span class="label">Payment Status</span>
                <span><span class="badge badge-paid"><i class="fas fa-check-circle"></i> Paid</span></span>
            </div>
            <div class="row">
                <span class="label">Purchase Date</span>
                <span class="value">{{ $order->created_at->format('F d, Y g:i A') }}</span>
            </div>
            <div class="row">
                <span class="label">Email</span>
                <span class="value">{{ $buyerEmail }}</span>
            </div>
        </div>

        {{-- DOWNLOAD SECTION --}}
        <div class="download-section">
            <div class="icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            <h4>Download Your Book</h4>
            <p>Click the button below to download <strong>{{ $book->title }}</strong> instantly.</p>
            <a href="{{ $downloadUrl }}" class="btn">
                <i class="fas fa-download"></i> Download Book
            </a>
            <p style="font-size: 0.75rem; color: #6a6a7a; margin-top: 12px;">
                <i class="fas fa-lock" style="color: #a67c4e;"></i> 
                This link is unique to you. Do not share it.
            </p>
        </div>

        {{-- SUPPORT --}}
        <div style="background: #f7f5f2; border-radius: 12px; padding: 16px 20px; margin-top: 16px; border: 1px solid rgba(166, 124, 78, 0.06);">
            <p style="font-size: 0.85rem; color: #6a6a7a; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-life-ring" style="color: #a67c4e;"></i>
                <span>Need help? </span>
                <a href="{{ route('contact') }}" style="color: #a67c4e; font-weight: 600; text-decoration: none;">Contact Support</a>
            </p>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} · Gauteng, South Africa</p>
        <p>
            <a href="mailto:hello@thecollective.co.za">hello@thecollective.co.za</a>
            <span class="divider">·</span>
            <a href="tel:+27714611401">+27 71 461 1401</a>
        </p>
        <p style="font-size: 0.65rem; opacity: 0.6; margin-top: 8px;">
            <i class="fas fa-shield-alt" style="color: #a67c4e;"></i> 
            This is a system-generated email. Please do not reply.
        </p>
    </div>

</div>

</body>
</html>