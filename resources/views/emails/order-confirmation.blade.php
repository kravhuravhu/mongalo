@extends('emails.layouts.email')

@section('title', 'Order Confirmation: ' . $book->title)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #1a1a2e; padding: 32px 36px 28px; border-bottom: 4px solid #a67c4e;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Georgia', serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #a67c4e;">· Order</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 6px;">
                            <span style="display: inline-block; padding: 2px 14px; border-radius: 50px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #28a745; color: #ffffff;">
                                &#10003; Confirmed
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
                <h2 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 22px; color: #1a1a2e; margin: 0 0 4px 0;">Order Confirmation</h2>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 16px 0; line-height: 1.7;">
                    Hello <strong style="color: #1a1a2e;">{{ $buyerName }}</strong>,
                </p>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 20px 0; line-height: 1.7;">
                    Thank you for your purchase. Your order has been confirmed and your book is ready for download.
                </p>

                {{-- ─── ORDER DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f7f5f2; border-radius: 10px; padding: 16px 20px; border: 1px solid rgba(166, 124, 78, 0.06); margin-bottom: 20px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 15px; color: #a67c4e; margin: 0 0 10px 0;">&#128196; Order Details</h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Order Number</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; font-family: monospace; color: #a67c4e;">{{ $orderNumber }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Book</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #1a1a2e;">{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Amount Paid</td>
                                    <td style="font-weight: 700; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #a67c4e;">R{{ number_format($order->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Status</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right;">
                                        <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #d4edda; color: #155724;">Paid</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Purchase Date</td>
                                    <td style="font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #6a6a7a;">{{ $order->created_at->format('F d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0;">Email</td>
                                    <td style="font-weight: 500; font-size: 13px; padding: 6px 0; text-align: right; color: #6a6a7a;">{{ $buyerEmail }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── DOWNLOAD SECTION ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: rgba(166, 124, 78, 0.04); border-radius: 12px; padding: 24px; border: 2px solid rgba(166, 124, 78, 0.08); text-align: center; margin-bottom: 16px;">
                    <tr>
                        <td align="center">
                            <div style="font-size: 38px; color: #a67c4e; opacity: 0.3; margin-bottom: 8px;">&#128196;</div>
                            <h4 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 18px; color: #1a1a2e; margin: 0 0 4px 0;">Download Your Book</h4>
                            <p style="color: #6a6a7a; font-size: 14px; margin: 0 0 16px 0; line-height: 1.6;">
                                Click the button below to download <strong style="color: #1a1a2e;">{{ $book->title }}</strong> instantly.
                            </p>
                            <a href="{{ $downloadUrl }}" style="display: inline-block; padding: 12px 36px; border-radius: 50px; background: #a67c4e; color: #ffffff; font-weight: 600; font-size: 15px; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                &#11015; Download Book
                            </a>
                            <p style="font-size: 12px; color: #6a6a7a; margin: 12px 0 0 0;">
                                &#128274; This link is unique to you. Do not share it.
                            </p>
                        </td>
                    </tr>
                </table>

                {{-- ─── SUPPORT ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f7f5f2; border-radius: 10px; padding: 16px 20px; border: 1px solid rgba(166, 124, 78, 0.06);">
                    <tr>
                        <td>
                            <p style="font-size: 13px; color: #6a6a7a; margin: 0;">
                                <span style="display: inline-block; margin-right: 6px;">&#127758;</span>
                                Need help? <a href="{{ route('contact') }}" style="color: #a67c4e; font-weight: 600; text-decoration: underline;">Contact Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 20px 36px; border-top: 1px solid rgba(166, 124, 78, 0.06); text-align: center; background: #faf9f7;">
        <tr>
            <td>
                <p style="font-size: 11px; color: #6a6a7a; margin: 0 0 4px 0;">
                    &copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} &middot; Gauteng, South Africa
                </p>
                <p style="font-size: 11px; color: #6a6a7a; margin: 0;">
                    <a href="mailto:hello@thecollective.co.za" style="color: #a67c4e; text-decoration: none;">hello@thecollective.co.za</a>
                    <span style="color: rgba(166, 124, 78, 0.12); margin: 0 6px;">&middot;</span>
                    <a href="tel:+27714611401" style="color: #a67c4e; text-decoration: none;">+27 71 461 1401</a>
                </p>
            </td>
        </tr>
    </table>
@endsection