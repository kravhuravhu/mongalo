@extends('emails.layouts.email')

@section('title', 'Reset Your Admin Password')

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #0A1F33; padding: 32px 36px 28px; border-bottom: 4px solid #B8926A;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #B8926A;">· Password Reset</span>
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
                <h2 style="font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 22px; color: #0A1F33; margin: 0 0 6px 0;">Password Reset Request</h2>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 18px 0; line-height: 1.7;">
                    Hello <strong style="color: #0A1F33;">{{ $adminName }}</strong>,
                </p>
                <p style="color: #6A6A7A; font-size: 15px; margin: 0 0 24px 0; line-height: 1.7;">
                    You requested to reset your admin password. Click the button below to set a new password.
                </p>

                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 8px 0;">
                            <a href="{{ route('admin.reset-password', $token) }}?email={{ urlencode($email) }}" style="display: inline-block; padding: 14px 42px; border-radius: 50px; background: #B8926A; color: #ffffff; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; letter-spacing: 0.05em; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #6A6A7A; margin: 18px 0 0 0; text-align: center;">
                    This link will expire in 60 minutes. If you didn't request this, you can safely ignore this email.
                </p>
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
                    <a href="mailto:{{ config('app.admin_email') }}" style="color: #B8926A; text-decoration: none;">{{ config('app.admin_email') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endsection