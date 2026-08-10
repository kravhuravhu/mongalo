@extends('emails.layouts.email')

@section('title', 'Registration Confirmation: ' . $event->title)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #1a1a2e; padding: 32px 36px 28px; border-bottom: 4px solid #a67c4e;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Georgia', serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #a67c4e;">· Registration</span>
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
                <h2 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 22px; color: #1a1a2e; margin: 0 0 4px 0;">Registration Confirmed</h2>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 16px 0; line-height: 1.7;">
                    Hello <strong style="color: #1a1a2e;">{{ $registration->name }}</strong>,
                </p>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 20px 0; line-height: 1.7;">
                    You have successfully registered for <strong style="color: #1a1a2e;">{{ $event->title }}</strong>. Please find the event details below.
                </p>

                {{-- ─── EVENT DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f7f5f2; border-radius: 10px; padding: 16px 20px; border: 1px solid rgba(166, 124, 78, 0.06); margin-bottom: 20px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 15px; color: #a67c4e; margin: 0 0 10px 0;">&#128197; Event Details</h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Event</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #1a1a2e;">{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Date</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #1a1a2e;">{{ $event->date->format('l, F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Time</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #1a1a2e;">{{ Carbon\Carbon::parse($event->time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Location</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; color: #1a1a2e;">{{ $event->location }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06);">Registration ID</td>
                                    <td style="font-weight: 700; font-size: 13px; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); text-align: right; font-family: monospace; color: #a67c4e;">{{ $registration->registration_id }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6a6a7a; font-weight: 500; font-size: 13px; padding: 6px 0;">Status</td>
                                    <td style="font-weight: 600; font-size: 13px; padding: 6px 0; text-align: right;">
                                        @if($isFree)
                                            <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #d4edda; color: #155724;">Free</span>
                                        @else
                                            <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fff3cd; color: #856404;">Pending Payment</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── BANKING DETAILS (Paid Events Only) ─── --}}
                @if(!$isFree && $bankingDetails)
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 10px; padding: 20px; margin: 20px 0; border: 2px solid #a67c4e;">
                        <tr>
                            <td>
                                <h4 style="font-family: 'Georgia', serif; font-weight: 700; color: #a67c4e; margin: 0 0 12px 0; font-size: 16px;">💳 Complete Your Payment</h4>
                                <p style="font-size: 14px; color: #6a6a7a; margin-bottom: 16px; line-height: 1.6;">
                                    Your spot is reserved for <strong>48 hours</strong>. Use the banking details below to complete your registration.
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 4px 0; width: 50%; vertical-align: top;">
                                            <div style="font-size: 0.65rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em;">Bank</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #1a1a2e;">{{ $bankingDetails['bank'] }}</div>
                                        </td>
                                        <td style="padding: 4px 0; width: 50%; vertical-align: top;">
                                            <div style="font-size: 0.65rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em;">Account Name</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #1a1a2e;">{{ $bankingDetails['account_name'] }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 4px 0; width: 50%; vertical-align: top; border-top: 1px solid rgba(166, 124, 78, 0.06);">
                                            <div style="font-size: 0.65rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em;">Account Number</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #1a1a2e;">{{ $bankingDetails['account_number'] }}</div>
                                        </td>
                                        <td style="padding: 4px 0; width: 50%; vertical-align: top; border-top: 1px solid rgba(166, 124, 78, 0.06);">
                                            <div style="font-size: 0.65rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em;">Branch Code</div>
                                            <div style="font-weight: 500; font-size: 14px; color: #1a1a2e;">{{ $bankingDetails['branch_code'] }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 16px 0 0 0; text-align: center; border-top: 1px solid rgba(166, 124, 78, 0.1);">
                                            <div style="font-size: 0.65rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em; margin-bottom: 4px;">Reference</div>
                                            <div style="background: #a67c4e; color: #ffffff; padding: 4px 16px; border-radius: 4px; font-weight: 700; font-size: 1.1rem; display: inline-block; font-family: monospace; letter-spacing: 1px;">{{ $bankingDetails['reference'] }}</div>
                                            <p style="font-size: 0.75rem; color: #6a6a7a; margin-top: 8px;">
                                                <i class="fas fa-info-circle"></i> Use this exact reference when making payment.
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
                            <a href="{{ route('events.show', $event->slug) }}" style="display: inline-block; padding: 12px 36px; border-radius: 50px; background: #a67c4e; color: #ffffff; font-weight: 600; font-size: 15px; text-decoration: none; border: none; cursor: pointer; text-align: center;">
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