@extends('emails.layouts.email')

@section('title', 'Registration Confirmation: ' . $event->title)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #0A1F33; padding: 32px 36px 28px; border-bottom: 4px solid #B8926A;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #B8926A;">· Registration</span>
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
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 22px; color: #0A1F33; margin: 0 0 6px 0;">Registration Confirmed</h2>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 18px 0; line-height: 1.7;">
                    Hello <strong style="color: #0A1F33;">{{ $registration->name }}</strong>,
                </p>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 22px 0; line-height: 1.7;">
                    You have successfully registered for <strong style="color: #0A1F33;">{{ $event->title }}</strong>. Please find the event details below.
                </p>

                {{-- ─── EVENT DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #F7F4EE; border-radius: 10px; padding: 18px 20px; border: 1px solid rgba(184, 146, 106, 0.08); margin-bottom: 22px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 15px; color: #B8926A; margin: 0 0 12px 0;">Event Details</h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Event</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #0A1F33;">{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Date</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #0A1F33;">{{ $event->date->format('l, F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Time</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #0A1F33;">{{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Location</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #0A1F33;">{{ $event->location }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Registration ID</td>
                                    <td style="font-weight: 700; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; font-family: monospace; color: #B8926A;">{{ $registration->registration_id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 13px; padding: 6px 0;">Status</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; text-align: right;">
                                        @if($isFree)
                                            <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; background: #D4EDDA; color: #155724;">Free</span>
                                        @else
                                            <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; background: #FFF3CD; color: #856404;">Pending Payment</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── BANKING DETAILS ─── --}}
                @if(!$isFree && $bankingDetails)
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 10px; padding: 22px; margin: 22px 0; border: 2px solid #B8926A;">
                        <tr>
                            <td>
                                <h4 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; color: #B8926A; margin: 0 0 14px 0; font-size: 16px;">Complete Your Payment</h4>
                                <p style="font-size: 14px; color: #6A6A7A; margin-bottom: 18px; line-height: 1.6;">
                                    Your spot is reserved for <strong>48 hours</strong>. Use the banking details below to complete your registration.
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 6px 0; width: 50%; vertical-align: top;">
                                            <div style="font-family: 'Montserrat', sans-serif; font-size: 0.65rem; text-transform: uppercase; color: #6A6A7A; font-weight: 600; letter-spacing: 0.06em;">Bank</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #0A1F33;">{{ $bankingDetails['bank'] }}</div>
                                        </td>
                                        <td style="padding: 6px 0; width: 50%; vertical-align: top;">
                                            <div style="font-family: 'Montserrat', sans-serif; font-size: 0.65rem; text-transform: uppercase; color: #6A6A7A; font-weight: 600; letter-spacing: 0.06em;">Account Name</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #0A1F33;">{{ $bankingDetails['account_name'] }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; width: 50%; vertical-align: top; border-top: 1px solid rgba(184, 146, 106, 0.08);">
                                            <div style="font-family: 'Montserrat', sans-serif; font-size: 0.65rem; text-transform: uppercase; color: #6A6A7A; font-weight: 600; letter-spacing: 0.06em;">Account Number</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #0A1F33;">{{ $bankingDetails['account_number'] }}</div>
                                        </td>
                                        <td style="padding: 6px 0; width: 50%; vertical-align: top; border-top: 1px solid rgba(184, 146, 106, 0.08);">
                                            <div style="font-family: 'Montserrat', sans-serif; font-size: 0.65rem; text-transform: uppercase; color: #6A6A7A; font-weight: 600; letter-spacing: 0.06em;">Branch Code</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #0A1F33;">{{ $bankingDetails['branch_code'] }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 18px 0 0 0; text-align: center; border-top: 1px solid rgba(184, 146, 106, 0.1);">
                                            <div style="font-family: 'Montserrat', sans-serif; font-size: 0.65rem; text-transform: uppercase; color: #6A6A7A; font-weight: 600; letter-spacing: 0.06em; margin-bottom: 6px;">Reference</div>
                                            <div style="background: #B8926A; color: #ffffff; padding: 6px 18px; border-radius: 6px; font-weight: 700; font-size: 1.1rem; display: inline-block; font-family: monospace; letter-spacing: 1px;">{{ $bankingDetails['reference'] }}</div>
                                            <p style="font-size: 0.75rem; color: #6A6A7A; margin-top: 10px;">
                                                Use this exact reference when making payment.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                @endif

                {{-- ─── VIEW EVENT BUTTON ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 8px 0;">
                            <a href="{{ route('events.show', $event->slug) }}" style="display: inline-block; padding: 12px 38px; border-radius: 50px; background: #B8926A; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; letter-spacing: 0.05em; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                View Event Details
                            </a>
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