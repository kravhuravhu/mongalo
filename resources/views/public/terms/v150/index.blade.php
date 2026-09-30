@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Terms of Service')

@section('content')

@php
    $lastUpdated = date('F Y');

    $sections = [
        [
            'number' => '01',
            'title'  => 'Acceptance of Terms',
            'body'   => [
                'By accessing or using ' . env('PROJECT_NAME', 'IN.iN') . ' (the "Site"), you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, please do not use the Site.',
                'These terms apply to all visitors, users, and anyone who accesses or uses the Site, including any content, functionality, and services offered through it.'
            ]
        ],
        [
            'number' => '02',
            'title'  => 'Use of the Site',
            'body'   => [
                'The Site is provided for personal, non-commercial use in connection with the ministry\'s teaching, events, and resources.',
                'You agree not to:',
                [
                    'Use the Site in any way that violates applicable local, national, or international law',
                    'Attempt to gain unauthorised access to any part of the Site or its systems',
                    'Interfere with the proper working of the Site or any activity conducted on it',
                    'Copy, reproduce, or redistribute content without written permission',
                ]
            ]
        ],
        [
            'number' => '03',
            'title'  => 'Books, Resources & Payments',
            'body'   => [
                'Paid books and free resources are made available through the Site. Prices are shown in South African Rand (ZAR) unless otherwise stated.',
                'Payments are processed via third-party payment providers. By making a purchase, you agree to their terms and conditions in addition to these Terms.',
                'Digital purchases are delivered as downloadable files. Because of the nature of digital goods, refunds are offered at our discretion and only where the file is faulty or the download is unusable.'
            ]
        ],
        [
            'number' => '04',
            'title'  => 'Event Registrations',
            'body'   => [
                'Event registration is confirmed once payment is received (for paid events) or once the form has been submitted (for free events).',
                'Registration details are kept on file and used only to administer the event, communicate updates, and where applicable verify payment.',
                'If an event is cancelled or rescheduled, registered attendees will be contacted via the details provided at registration.'
            ]
        ],
        [
            'number' => '05',
            'title'  => 'Intellectual Property',
            'body'   => [
                'All content on the Site including text, teaching material, book excerpts, images, logos, and design is the property of the ministry or its content suppliers and is protected by copyright.',
                'You may not reproduce, distribute, modify, or create derivative works from any part of the Site without prior written consent.'
            ]
        ],
        [
            'number' => '06',
            'title'  => 'User Submissions',
            'body'   => [
                'Where the Site allows you to submit information (such as contact forms, event registrations, or prayer requests), you confirm that the information you provide is accurate and that you have the right to share it.',
                'You agree not to submit anything unlawful, defamatory, or that infringes the rights of any third party.'
            ]
        ],
        [
            'number' => '07',
            'title'  => 'Third-Party Links',
            'body'   => [
                'The Site may contain links to third-party websites or services that are not owned or controlled by us. We have no control over, and assume no responsibility for, the content or practices of any third-party site.',
                'You access any linked third-party site at your own risk.'
            ]
        ],
        [
            'number' => '08',
            'title'  => 'Disclaimer',
            'body'   => [
                'The Site and its content are provided on an "as is" and "as available" basis. While we aim to keep everything accurate and up to date, we make no guarantees about completeness, reliability, or suitability for any particular purpose.',
                'Teaching content shared on the Site is provided for spiritual encouragement. It is not a substitute for pastoral counsel, professional advice, or the guidance of your local church.'
            ]
        ],
        [
            'number' => '09',
            'title'  => 'Limitation of Liability',
            'body'   => [
                'To the fullest extent permitted by law, we shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Site or its content.',
                'This includes but is not limited to loss of data, loss of profit, or interruption of service, whether or not we were advised of the possibility of such damage.'
            ]
        ],
        [
            'number' => '10',
            'title'  => 'Changes to These Terms',
            'body'   => [
                'We may update these Terms of Service from time to time. When we do, the "Last updated" date at the top of this page will change.',
                'Continued use of the Site after any changes constitutes your acceptance of the new terms.'
            ]
        ],
        [
            'number' => '11',
            'title'  => 'Contact',
            'body'   => [
                'If you have any questions about these Terms of Service, please reach out through the contact page.'
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
                    Terms of <span>Service</span>
                </h1>

                <p class="legal__hero-subtitle">
                    Please read these terms carefully before using the Site.
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
                    These Terms of Service govern your use of {{ env('PROJECT_NAME', 'IN.iN') }}.
                    By continuing to browse, register for events, or purchase books and resources,
                    you confirm that you accept the terms set out below.
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
                        These terms are provided as a general framework and do not constitute legal advice.
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