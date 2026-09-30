@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Privacy Policy')

@section('content')

@php
    $lastUpdated = date('F Y');

    $sections = [
        [
            'number' => '01',
            'title'  => 'Overview',
            'body'   => [
                'This Privacy Policy explains how we collect, use, and protect your personal information when you use ' . env('PROJECT_NAME', 'IN.iN') . ' (the "Site").',
                'We are committed to handling your information responsibly and only using it for the purposes described here.'
            ]
        ],
        [
            'number' => '02',
            'title'  => 'Information We Collect',
            'body'   => [
                'We only collect information that you provide directly to us, through:',
                [
                    'Contact forms: your name, email address, and message',
                    'Event registration: your name, email address, phone number, and event selection',
                    'Book purchases: your name, email address, and phone number, plus basic transaction metadata from our payment provider',
                    'Resource downloads: an anonymous count of how many times a file has been downloaded',
                ],
                'We do not use tracking cookies, advertising pixels, or third-party analytics that build a profile of you across the web.'
            ]
        ],
        [
            'number' => '03',
            'title'  => 'How We Use Your Information',
            'body'   => [
                'The information you provide is used only to:',
                [
                    'Respond to contact enquiries',
                    'Administer event registrations and communicate event updates',
                    'Deliver purchased books and free resources',
                    'Verify payments where required',
                    'Maintain basic records of who has registered or purchased'
                ],
                'We do not sell, rent, or trade your personal information to anyone.'
            ]
        ],
        [
            'number' => '04',
            'title'  => 'Payment Information',
            'body'   => [
                'Card payments are processed by third-party payment providers. We do not see or store your full card details at any point.',
                'Our payment providers handle your card information in accordance with their own privacy policies and applicable payment-industry standards.',
                'For manual bank transfers, we keep only the reference number and confirmation of payment not the bank details of the sender.'
            ]
        ],
        [
            'number' => '05',
            'title'  => 'Storage & Security',
            'body'   => [
                'Your information is stored on secure servers. Access is limited to the individuals who need it to carry out the purposes described above.',
                'While we take reasonable measures to protect your information, no method of transmission over the internet is completely secure. We cannot guarantee absolute security.'
            ]
        ],
        [
            'number' => '06',
            'title'  => 'Data Retention',
            'body'   => [
                'Contact enquiries are kept for as long as needed to respond and for a reasonable period afterwards for record-keeping.',
                'Event registrations are kept until the event has taken place and any follow-up has been completed.',
                'Book purchase records are kept in accordance with financial record-keeping obligations.'
            ]
        ],
        [
            'number' => '07',
            'title'  => 'Your Rights',
            'body'   => [
                'You have the right to:',
                [
                    'Request a copy of the personal information we hold about you',
                    'Ask us to correct any information that is inaccurate',
                    'Ask us to delete your information, where we are not required to keep it',
                    'Withdraw consent for future communications at any time'
                ],
                'To exercise any of these rights, please contact us through the contact page.'
            ]
        ],
        [
            'number' => '08',
            'title'  => 'Third-Party Services',
            'body'   => [
                'We use a small number of trusted third-party services such as payment providers and WhatsApp (for community communications), and PayFAST for the books purchases, which have their own privacy policies.',
                'When you interact with those services, their terms apply in addition to this policy.'
            ]
        ],
        [
            'number' => '09',
            'title'  => 'Children\'s Privacy',
            'body'   => [
                'The Site is not directed at children under the age of 13. We do not knowingly collect personal information from children.',
                'If you believe a child has submitted personal information to us, please contact us so we can remove it.'
            ]
        ],
        [
            'number' => '10',
            'title'  => 'Changes to This Policy',
            'body'   => [
                'We may update this Privacy Policy from time to time. When we do, the "Last updated" date at the top of this page will change.',
                'Continued use of the Site after any changes constitutes acceptance of the updated policy.'
            ]
        ],
        [
            'number' => '11',
            'title'  => 'Contact',
            'body'   => [
                'If you have any questions about this Privacy Policy or how your information is handled, please reach out through the contact page.'
            ]
        ],
    ];
@endphp

<div class="legal">

    {{-- ─── HERO ─── --}}
    <section class="legal__hero">
        <div class="legal__hero-bg">
            <div class="legal__hero-shape legal__hero-shape--1"></div>
            <div class="legal__hero-shape legal__hero-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="legal__hero-content">
                <span class="legal__hero-eyebrow">
                    <span class="legal__hero-eyebrow-line"></span>
                    Legal
                </span>

                <h1 class="legal__hero-title">
                    Privacy <span>Policy</span>
                </h1>

                <p class="legal__hero-subtitle">
                    How we collect, use, and protect your information.
                </p>

                <span class="legal__hero-meta">
                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                    Last updated: {{ $lastUpdated }}
                </span>
            </div>
        </div>
    </section>

    {{-- ─── BODY ─── --}}
    <section class="legal__body">
        <div class="legal__body-bg">
            <div class="legal__body-shape legal__body-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="legal__content">
                <p class="legal__intro">
                    Your privacy matters. This page explains in plain language what information we collect,
                    why we collect it, and how you can reach out if you have questions or want something changed.
                </p>

                <div class="legal__sections">
                    @foreach($sections as $section)
                        <article class="legal__section">
                            <header class="legal__section-header">
                                <span class="legal__section-number">{{ $section['number'] }}</span>
                                <h2 class="legal__section-title">{{ $section['title'] }}</h2>
                            </header>

                            <div class="legal__section-body">
                                @foreach($section['body'] as $block)
                                    @if(is_array($block))
                                        <ul class="legal__list">
                                            @foreach($block as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>{{ $block }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="legal__footnote">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    <p>
                        This policy is provided as a general framework and does not constitute legal advice.
                        For anything material, please consult a qualified attorney.
                    </p>
                </div>

                <div class="legal__actions">
                    <a href="{{ route('contact') }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <span>Contact Us</span>
                    </a>

                    <a href="{{ url('/') }}" class="btn btn--outline btn--lg">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        <span>Back Home</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/legal.css') }}">
@endpush