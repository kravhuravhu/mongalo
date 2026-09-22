@extends('emails.layouts.email')

@section('title', 'Order Confirmation: ' . $book->title)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #0A1F33; padding: 32px 36px 28px; border-bottom: 4px solid #B8926A;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #B8926A;">· Order</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 8px;">
                            <span style="display: inline-block; padding: 3px 16px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; background: #28A745; color: #ffffff;">
                                Confirmed
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

@section('body')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 32px 36px 28px;">
        <tr>
            <td>
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 22px; color: #0A1F33; margin: 0 0 6px 0;">Order Confirmation</h2>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 18px 0; line-height: 1.7;">
                    Hello <strong style="color: #0A1F33;">{{ $buyerName }}</strong>,
                </p>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 22px 0; line-height: 1.7;">
                    Thank you for your purchase. Your order has been confirmed and your book is ready for download.
                </p>

                {{-- ─── ORDER DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #F7F4EE; border-radius: 10px; padding: 18px 20px; border: 1px solid rgba(184, 146, 106, 0.08); margin-bottom: 22px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 15px; color: #B8926A; margin: 0 0 12px 0;">Order Details</h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Order Number</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; font-family: monospace; color: #B8926A;">{{ $orderNumber }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Book</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #0A1F33;">{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Amount Paid</td>
                                    <td style="font-weight: 700; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #B8926A;">R{{ number_format($order->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Status</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right;">
                                        <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; background: #D4EDDA; color: #155724;">Paid</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Purchase Date</td>
                                    <td style="font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A;">{{ $order->created_at->format('F d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0;">Email</td>
                                    <td style="font-weight: 500; font-size: 13px; padding: 6px 0; text-align: right; color: #6A6A7A;">{{ $buyerEmail }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── DOWNLOAD SECTION ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: rgba(184, 146, 106, 0.06); border-radius: 12px; padding: 26px; border: 2px solid rgba(184, 146, 106, 0.1); text-align: center; margin-bottom: 18px;">
                    <tr>
                        <td align="center">
                            <div style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 18px; color: #0A1F33; margin: 0 0 6px 0;">Download Your Book</div>
                            <p style="color: #6A6A7A; font-size: 14px; margin: 0 0 18px 0; line-height: 1.6;">
                                Click the button below to download <strong style="color: #0A1F33;">{{ $book->title }}</strong> instantly.
                            </p>
                            <a href="{{ $downloadUrl }}" style="display: inline-block; padding: 13px 40px; border-radius: 50px; background: #B8926A; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; letter-spacing: 0.05em; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                Download Book
                            </a>
                            <p style="font-size: 12px; color: #6A6A7A; margin: 14px 0 0 0;">
                                This link is unique to you. Do not share it.
                            </p>
                        </td>
                    </tr>
                </table>

                {{-- ─── SUPPORT ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #F7F4EE; border-radius: 10px; padding: 16px 20px; border: 1px solid rgba(184, 146, 106, 0.08);">
                    <tr>
                        <td>
                            <p style="font-size: 13px; color: #6A6A7A; margin: 0;">
                                Need help? <a href="{{ route('contact') }}" style="color: #B8926A; font-weight: 600; text-decoration: underline;">Contact Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 20px 36px; border-top: 1px solid rgba(184, 146, 106, 0.08); text-align: center; background: #FBFAF7;">
        <tr>
            <td>
                <p style="font-size: 11px; color: #6A6A7A; margin: 0 0 4px 0;">
                    &copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} &middot; Gauteng, South Africa
                </p>
                <p style="font-size: 11px; color: #6A6A7A; margin: 0;">
                    <a href="mailto:{{ config('app.app_contact_email', 'hello@example.com') }}" style="color: #B8926A; text-decoration: none;">{{ config('app.app_contact_email', 'hello@example.com') }}</a>
                    <span style="color: rgba(184, 146, 106, 0.2); margin: 0 6px;">&middot;</span>
                    <a href="tel:{{ config('app.app_contact_phone', '+27 71 461 1401') }}" style="color: #B8926A; text-decoration: none;">{{ config('app.app_contact_phone', '+27 71 461 1401') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endsection