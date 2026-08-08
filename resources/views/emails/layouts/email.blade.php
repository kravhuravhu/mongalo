<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', env('PROJECT_NAME', 'The Collective'))</title>
</head>
<body style="margin:0; padding:0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f7f5f2; color: #1a1a2e; line-height: 1.6; -webkit-font-smoothing: antialiased;">

{{-- ─── OUTER TABLE ─── --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f7f5f2; padding: 40px 20px;">
    <tr>
        <td align="center">
            {{-- ─── MAIN CONTAINER ─── --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid rgba(166, 124, 78, 0.08); box-shadow: 0 8px 40px rgba(0, 0, 0, 0.04);">
                <tr>
                    <td style="padding: 0;">

                        {{-- ─── HEADER ─── --}}
                        @yield('header')

                        {{-- ─── BODY ─── --}}
                        @yield('body')

                        {{-- ─── FOOTER ─── --}}
                        @yield('footer')

                    </td>
                </tr>
            </table>

            {{-- ─── POSTSCRIPT ─── --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; margin-top: 16px;">
                <tr>
                    <td align="center" style="font-size: 11px; color: #9a9aae; padding: 8px 16px; text-align: center;">
                        <p style="margin: 0 0 4px 0; color: #9a9aae; font-size: 11px;">
                            <span style="display: inline-block; margin: 0 8px;">&bull;</span>
                            This is a system-generated email from {{ env('PROJECT_NAME', 'The Collective') }}
                            <span style="display: inline-block; margin: 0 8px;">&bull;</span>
                        </p>
                        <p style="margin: 0; color: #9a9aae; font-size: 10px;">
                            If you no longer wish to receive these emails, please <a href="{{ route('contact') }}" style="color: #a67c4e; text-decoration: underline;">contact us</a>.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>