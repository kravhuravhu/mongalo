@extends('layouts.v160.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Terms of Service')

@section('page-class', 'page-legal')

@push('styles')
    @include('components.v160.page-assets')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/legal.css') }}">
@endpush

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
    
    @include('public.legal.v160.page', [
        'titleLead' => 'Terms of',
        'titleAccent' => 'Service',
        'subtitle' => 'Please read these terms carefully before using the Site.',
        'intro' => 'These Terms of Service govern your use of ' . env('PROJECT_NAME', 'IN.iN') . '. By continuing to browse, register for events, or purchase books and resources, you confirm that you accept the terms set out below.',
        'footnote' => 'These terms are provided as a general framework and do not constitute legal advice. For anything material, please consult a qualified attorney.',
    ])
@endsection