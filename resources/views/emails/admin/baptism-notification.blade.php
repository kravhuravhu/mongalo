@extends('emails.layouts.email')

@section('title', 'Baptism Request from ' . $baptism->name)

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #0A1F33; padding: 28px 36px 24px; border-bottom: 4px solid #B8926A;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 18px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #B8926A;">· Admin</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 8px;">
                            <span style="display: inline-block; padding: 3px 14px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; background: #B8926A; color: #ffffff;">
                                Baptism Request — {{ $baptism->name }}
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
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 20px; color: #0A1F33; margin: 0 0 6px 0;">New Baptism Request</h2>
                <p style="color: #6A6A7A; font-size: 14px; margin: 0 0 14px 0;">
                    Hello <strong style="color: #0A1F33;">{{ $adminName }}</strong>,
                </p>
                <p style="color: #6A6A7A; font-size: 14px; margin: 0 0 18px 0; line-height: 1.7;">
                    A new baptism request has been submitted. Please review and contact the person.
                </p>

                {{-- ─── REQUESTER DETAILS ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #F7F4EE; border-radius: 10px; padding: 18px 20px; border: 1px solid rgba(184, 146, 106, 0.08); margin-bottom: 18px;">
                    <tr>
                        <td>
                            <h4 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 14px; color: #B8926A; margin: 0 0 12px 0;">
                                Requester Details
                            </h4>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Name</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right;">{{ $baptism->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Email</td>
                                    <td style="font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A;">{{ $baptism->email }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Phone</td>
                                    <td style="font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A;">{{ $baptism->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Location</td>
                                    <td style="font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A;">{{ $baptism->location }}</td>
                                </tr>
                                @if($baptism->preferred_date)
                                    <tr>
                                        <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Preferred Date</td>
                                        <td style="font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A;">{{ $baptism->preferred_date->format('M d, Y') }}</td>
                                    </tr>
                                @endif
                                @if($baptism->message)
                                    <tr>
                                        <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); vertical-align: top;">Message</td>
                                        <td style="font-weight: 400; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right; color: #6A6A7A; line-height: 1.5;">{{ $baptism->message }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08);">Status</td>
                                    <td style="font-weight: 600; font-size: 12px; padding: 4px 0; border-bottom: 1px solid rgba(184, 146, 106, 0.08); text-align: right;">
                                        <span style="display: inline-block; padding: 2px 12px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; background: #FFF3CD; color: #856404;">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #6A6A7A; font-weight: 500; font-size: 12px; padding-top: 4px;">Submitted</td>
                                    <td style="font-weight: 500; font-size: 12px; padding-top: 4px; text-align: right; color: #6A6A7A;">{{ $baptism->created_at->format('F d, Y g:i A') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- ─── VIEW BUTTON ─── --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 6px 0;">
                            <a href="{{ route('admin.baptisms') }}" style="display: inline-block; padding: 12px 34px; border-radius: 50px; background: #B8926A; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 13px; letter-spacing: 0.05em; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                View in Admin
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #6A6A7A; margin: 14px 0 0 0;">
                    You are receiving this email because you are the admin of {{ env('PROJECT_NAME', 'The Collective') }}.
                </p>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 16px 36px; border-top: 1px solid rgba(184, 146, 106, 0.08); text-align: center; background: #FBFAF7;">
        <tr>
            <td>
                <p style="font-size: 10px; color: #6A6A7A; margin: 0 0 4px 0;">
                    &copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} &middot; Gauteng, South Africa
                </p>
                <p style="font-size: 10px; color: #6A6A7A; margin: 0;">
                    <a href="mailto:{{ config('app.admin_email', 'admin@example.com') }}" style="color: #B8926A; text-decoration: none;">{{ config('app.admin_email', 'admin@example.com') }}</a>
                    <span style="color: rgba(184, 146, 106, 0.2); margin: 0 6px;">&middot;</span>
                    <a href="tel:{{ config('app.app_contact_phone', '+27 71 461 1401') }}" style="color: #B8926A; text-decoration: none;">{{ config('app.app_contact_phone', '+27 71 461 1401') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endsection