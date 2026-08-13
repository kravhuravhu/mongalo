@extends('emails.layouts.email')

@section('title', 'Reset Your Admin Password')

@section('header')
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #1a1a2e; padding: 32px 36px 28px; border-bottom: 4px solid #a67c4e;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-family: 'Georgia', serif; font-weight: 700; font-size: 20px; color: #ffffff; margin: 0;">
                            {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="color: #a67c4e;">· Password Reset</span>
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
                <h2 style="font-family: 'Georgia', serif; font-weight: 700; font-size: 22px; color: #1a1a2e; margin: 0 0 4px 0;">Password Reset Request</h2>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 16px 0; line-height: 1.7;">
                    Hello <strong style="color: #1a1a2e;">{{ $adminName }}</strong>,
                </p>
                <p style="color: #6a6a7a; font-size: 15px; margin: 0 0 20px 0; line-height: 1.7;">
                    You requested to reset your admin password. Click the button below to set a new password.
                </p>

                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="padding: 8px 0;">
                            <a href="{{ route('admin.reset-password', $token) }}?email={{ urlencode($email) }}" style="display: inline-block; padding: 14px 40px; border-radius: 50px; background: #a67c4e; color: #ffffff; font-weight: 600; font-size: 15px; text-decoration: none; border: none; cursor: pointer; text-align: center;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #6a6a7a; margin: 16px 0 0 0;">
                    This link will expire in 60 minutes. If you didn't request this, you can safely ignore this email.
                </p>
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
                    <a href="mailto:{{ config('app.admin_email') }}" style="color: #a67c4e; text-decoration: none;">{{ config('app.admin_email') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endsection