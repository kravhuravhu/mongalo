<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Shipped</title>
</head>
<body style="margin: 0; padding: 0; background: #F7F4EE; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #1A1A2E; line-height: 1.6;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: #F7F4EE; padding: 40px 20px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background: #FFFFFF; border-radius: 20px; overflow: hidden; box-shadow: 0 12px 40px rgba(10, 31, 51, 0.08);">

                    {{-- ─── HEADER ─── --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0A1F33 0%, #1A3A5C 100%); padding: 40px 32px; text-align: center;">
                            <div style="font-family: 'Playfair Display', serif; font-weight: 800; font-size: 28px; color: #FFFFFF; letter-spacing: -0.03em; line-height: 1;">
                                IN<span style="color: #B8926A;">.</span>iN
                            </div>
                            <div style="font-family: 'Montserrat', sans-serif; font-size: 10px; font-weight: 500; letter-spacing: 0.3em; text-transform: uppercase; color: rgba(255, 255, 255, 0.5); margin-top: 8px;">
                                In Him · In You · In Us
                            </div>
                        </td>
                    </tr>

                    {{-- ─── BODY ─── --}}
                    <tr>
                        <td style="padding: 40px 32px 32px;">

                            <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: rgba(40, 167, 69, 0.1); border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 10px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #28a745; margin-bottom: 20px;">
                                Shipped
                            </div>

                            <h1 style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 24px; line-height: 1.2; color: #0A1F33; margin: 0 0 16px; letter-spacing: -0.02em;">
                                Your book is on its way
                            </h1>

                            <p style="font-size: 15px; line-height: 1.7; color: #6A6A7A; margin: 0 0 16px;">
                                Hi {{ $order->buyer_name }},
                            </p>

                            <p style="font-size: 15px; line-height: 1.7; color: #6A6A7A; margin: 0 0 24px;">
                                Good news — your copy of <strong style="color: #0A1F33;">{{ $order->book->title ?? 'your book' }}</strong> has been shipped and is on its way to you.
                            </p>

                            {{-- ─── ORDER DETAILS ─── --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: #F7F4EE; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 6px 0; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #6A6A7A; width: 130px;">
                                        Order
                                    </td>
                                    <td style="padding: 6px 0; font-size: 14px; color: #0A1F33; font-weight: 500;">
                                        {{ $order->order_number }}
                                    </td>
                                </tr>

                                @if($order->tracking_number)
                                    <tr>
                                        <td style="padding: 6px 0; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #6A6A7A;">
                                            Tracking
                                        </td>
                                        <td style="padding: 6px 0; font-size: 14px; color: #B8926A; font-weight: 600;">
                                            {{ $order->tracking_number }}
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td style="padding: 6px 0; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #6A6A7A;">
                                        Shipped
                                    </td>
                                    <td style="padding: 6px 0; font-size: 14px; color: #0A1F33;">
                                        {{ $order->shipped_at?->format('F j, Y') ?? now()->format('F j, Y') }}
                                    </td>
                                </tr>
                            </table>

                            {{-- ─── DELIVERY ADDRESS ─── --}}
                            <div style="margin-bottom: 24px; padding: 20px; background: #FBF7F0; border-left: 3px solid #B8926A; border-radius: 10px;">
                                <div style="font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #B8926A; margin-bottom: 10px;">
                                    Delivery Address
                                </div>
                                <div style="font-size: 14px; line-height: 1.7; color: #6A6A7A; white-space: pre-line;">{{ $order->formatted_shipping_address }}</div>
                            </div>

                            <p style="font-size: 14px; line-height: 1.7; color: #6A6A7A; margin: 0 0 8px;">
                                <strong style="color: #0A1F33;">Delivery estimate:</strong>
                                {{ config('shop.shipping.' . $order->delivery_region . '.days', 'please allow a few days') }}
                            </p>

                            <p style="font-size: 14px; line-height: 1.7; color: #6A6A7A; margin: 0;">
                                If anything looks off, just reply to this email and we'll sort it out.
                            </p>

                        </td>
                    </tr>

                    {{-- ─── BONUS DIGITAL COPY ─── --}}
                    @if($order->book && $order->book->book_file)
                        <tr>
                            <td style="padding: 0 32px 32px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, rgba(184, 146, 106, 0.08) 0%, rgba(44, 110, 127, 0.06) 100%); border-radius: 14px; padding: 24px; text-align: center;">
                                    <tr>
                                        <td>
                                            <div style="font-family: 'Playfair Display', serif; font-weight: 700; font-size: 18px; color: #0A1F33; margin-bottom: 8px; letter-spacing: -0.01em;">
                                                Your digital copy, free
                                            </div>
                                            <p style="font-size: 13px; line-height: 1.6; color: #6A6A7A; margin: 0 0 16px;">
                                                Because you ordered a hard copy, the digital version is on us — read it while you wait.
                                            </p>
                                            <a href="{{ route('payment.download', $order->download_token) }}" style="display: inline-block; padding: 12px 28px; background: #B8926A; color: #FFFFFF; font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; text-decoration: none; border-radius: 50px;">
                                                Download Digital Copy
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endif

                    {{-- ─── FOOTER ─── --}}
                    <tr>
                        <td style="background: #F7F4EE; padding: 24px 32px; text-align: center; border-top: 1px solid rgba(10, 31, 51, 0.06);">
                            <p style="font-size: 12px; line-height: 1.6; color: #9A9AAE; margin: 0;">
                                Thank you for supporting the ministry.
                                <br>
                                If you have any questions, reply to this email or reach us through the contact page.
                            </p>
                        </td>
                    </tr>

                </table>

                <p style="font-size: 11px; color: #9A9AAE; margin: 20px 0 0;">
                    {{ env('PROJECT_NAME', 'IN.iN') }} · Gauteng, South Africa
                </p>

            </td>
        </tr>
    </table>

</body>
</html>