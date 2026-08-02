<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Confirmation</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; color: #1a1a2e; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { border-bottom: 2px solid #a67c4e; padding-bottom: 12px; margin-bottom: 24px; }
        .header h1 { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.6rem; color: #a67c4e; margin: 0; }
        .header p { color: #6a6a7a; margin: 4px 0 0; }
        .details { background: #f7f5f2; border-radius: 10px; padding: 20px; margin: 20px 0; border: 1px solid rgba(166, 124, 78, 0.12); }
        .details h3 { font-family: 'Playfair Display', serif; font-weight: 700; margin: 0 0 12px; }
        .details .row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid rgba(166, 124, 78, 0.06); }
        .details .row:last-child { border-bottom: none; }
        .details .label { color: #6a6a7a; font-weight: 500; }
        .details .value { font-weight: 600; }
        .banking { background: #fff; border-radius: 10px; padding: 20px; margin: 20px 0; border: 2px solid #a67c4e; }
        .banking h4 { font-family: 'Playfair Display', serif; font-weight: 700; color: #a67c4e; margin: 0 0 12px; }
        .banking-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px 16px; }
        .banking-grid .label { font-size: 0.7rem; text-transform: uppercase; color: #6a6a7a; font-weight: 600; letter-spacing: 0.06em; }
        .banking-grid .value { font-weight: 500; }
        .reference { background: #a67c4e; color: #fff; padding: 4px 12px; border-radius: 4px; font-weight: 700; font-size: 1.1rem; display: inline-block; }
        .footer { margin-top: 30px; padding-top: 16px; border-top: 1px solid rgba(166, 124, 78, 0.12); font-size: 0.8rem; color: #6a6a7a; text-align: center; }
        .footer a { color: #a67c4e; text-decoration: none; }
        .btn { display: inline-block; padding: 10px 24px; background: #a67c4e; color: #fff; border-radius: 50px; text-decoration: none; font-weight: 600; }
        .badge { display: inline-block; padding: 3px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 600; }
        .badge-free { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
        @media (max-width: 540px) {
            .banking-grid { grid-template-columns: 1fr; }
            .details .row { flex-direction: column; padding: 4px 0; }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>{{ env('PROJECT_NAME') }}</h1>
    <p>Event Registration Confirmation</p>
</div>

<h2>Hello {{ $registration->name }},</h2>
<p>You have successfully registered for:</p>

<div class="details">
    <h3>{{ $event->title }}</h3>
    <div class="row">
        <span class="label">Date</span>
        <span class="value">{{ $event->date->format('l, F d, Y') }}</span>
    </div>
    <div class="row">
        <span class="label">Time</span>
        <span class="value">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
    </div>
    <div class="row">
        <span class="label">Location</span>
        <span class="value">{{ $event->location }}</span>
    </div>
    <div class="row">
        <span class="label">Registration ID</span>
        <span class="value" style="font-family: monospace; font-weight: 700; color: #a67c4e;">{{ $registration->registration_id }}</span>
    </div>
    <div class="row">
        <span class="label">Status</span>
        <span>
            @if($isFree)
                <span class="badge badge-free">FREE</span>
            @else
                <span class="badge badge-pending">PENDING PAYMENT</span>
            @endif
        </span>
    </div>
</div>

@if(!$isFree && $bankingDetails)
    <div class="banking">
        <h4>💳 Complete Your Payment</h4>
        <p style="margin-bottom: 16px;">Use the banking details below to complete your registration. Your spot is reserved for <strong>48 hours</strong>.</p>

        <div class="banking-grid">
            <div>
                <div class="label">Bank</div>
                <div class="value">{{ $bankingDetails['bank'] }}</div>
            </div>
            <div>
                <div class="label">Account Name</div>
                <div class="value">{{ $bankingDetails['account_name'] }}</div>
            </div>
            <div>
                <div class="label">Account Number</div>
                <div class="value">{{ $bankingDetails['account_number'] }}</div>
            </div>
            <div>
                <div class="label">Branch Code</div>
                <div class="value">{{ $bankingDetails['branch_code'] }}</div>
            </div>
            <div style="grid-column: 1 / -1; text-align: center; padding-top: 12px; border-top: 1px solid rgba(166, 124, 78, 0.1);">
                <div class="label">Reference</div>
                <div class="reference">{{ $bankingDetails['reference'] }}</div>
                <p style="font-size: 0.8rem; color: #6a6a7a; margin-top: 8px;">
                    <i class="fas fa-info-circle"></i> 
                    Use this exact reference when making payment.
                </p>
            </div>
        </div>
    </div>
@endif

<p style="margin: 20px 0;">
    <a href="{{ route('events.show', $event->slug) }}" class="btn">
        View Event Details
    </a>
</p>

<div class="footer">
    <p>&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }} · Gauteng, South Africa</p>
    <p>
        <a href="mailto:hello@thecollective.co.za">hello@thecollective.co.za</a> · 
        <a href="tel:+27714611401">+27 71 461 1401</a>
    </p>
    <p style="font-size: 0.7rem; margin-top: 8px;">
        If you have any questions, feel free to reply to this email or contact us on WhatsApp.
    </p>
</div>

</body>
</html>