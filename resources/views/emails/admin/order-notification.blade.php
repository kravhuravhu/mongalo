@extends('emails.layouts.email')

@section('title', 'New Order: ' . $orderNumber)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #1a1a2e; padding: 28px 36px 24px; border-bottom: 4px solid #a67c4e;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Georgia', serif; font-weight: 700; font-size: 18px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #a67c4e;">· Admin</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 6px;">
                            <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #e8a838; color: #ffffff;">
                                &#128722; New Order — {{ $orderNumber }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

@section('body')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 28px 36px 24px;">
        <tr>
            <td>
                <h2 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 20px; color: #1a1a2e; margin: 0 0 4px 0;">New Order Received</h2>
                <p style="color: #6a6a7a; font-size: 14px; margin: 0 0 12px 0;">
                    Hello <strong style="color: #1a1a2e;">{{ $adminName }}</strong>,
                </p>
                <p style="color: #6a6a7a; font-size: 14px; margin: 0 0 16px 0; line-height: 1.7;">
                    A new order has been placed on your website. Please review the details below.
                </p>

                {{-- ─── ORDER DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f7f5f2; border-radius: 10px; padding: 16px 20px; border: 1px solid rgba(166, 124, 78, 0.06); margin-bottom: 16px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 14px; color: #a67c4e; margin: 0 0 10px 0;">&#128196; Order Details</h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Order Number</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #a67c4e; font-family: monospace;">{{ $orderNumber }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Book</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right;">{{ $book->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Amount</td>
                                    <td style="font-weight: 700; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #a67c4e;">R{{ number_format($order->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Status</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right;">
                                        <span style="display: inline-block; padding: 2px 10px; border-radius: 50px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #d4edda; color: #155724;">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Buyer</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right;">{{ $order->buyer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Email</td>
                                    <td style="font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #6a6a7a;">{{ $order->buyer_email }}</td>
                                </tr>
                                @if($order->buyer_phone)
                                    <tr>
                                        <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Phone</td>
                                        <td style="font-weight: 500; font-size: 12px; padding: 3px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #6a6a7a;">{{ $order->buyer_phone }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 12px; padding-top: 3px;">Date</td>
                                    <td style="font-weight: 500; font-size: 12px; padding-top: 3px; text-align: right; color: #6a6a7a;">{{ $order->created_at->format('F d, Y g:i A') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── VIEW ORDER BUTTON ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 4px 0;">
                            <a href="{{ route('admin.orders.show', $order) }}" style="display: inline-block; padding: 10px 32px; border-radius: 50px; background: #a67c4e; color: #ffffff; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                View in Admin
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #6a6a7a; margin: 12px 0 0 0;">
                    &#128161; You are receiving this email because you are the admin of {{ env('PROJECT_NAME', 'The Collective') }}.
                </p>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 16px 36px; border-top: 1px solid rgba(166, 124, 78, 0.06); text-align: center; background: #faf9f7;">
        <tr>
            <td>
                <p style="font-size: 10px; color: #6a6a7a; margin: 0 0 2px 0;">
                    &copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} &middot; Gauteng, South Africa
                </p>
                <p style="font-size: 10px; color: #6a6a7a; margin: 0;">
                    <a href="mailto:{{ config('app.admin_email') }}" style="color: #a67c4e; text-decoration: none;">{{ config('app.admin_email') }}</a>
                    <span style="color: rgba(166, 124, 78, 0.12); margin: 0 6px;">&middot;</span>
                    <a href="tel:+27714611401" style="color: #a67c4e; text-decoration: none;">+27 71 461 1401</a>
                </p>
            </td>
        </tr>
    </table>
@endsection