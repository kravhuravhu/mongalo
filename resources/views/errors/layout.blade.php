<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Error · ' . env('PROJECT_NAME', 'The Collective'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&family=EB+Garamond:ital@0;1&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">

    <style>
        .error-page {

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: var(--bg);
        }

        .error-page__card {
            background: #fff;
            border-radius: 20px;
            padding: 60px 48px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            max-width: 560px;
            width: 100%;
            text-align: center;
            transition: all 0.3s ease;
        }

        .error-page__card:hover {
            border-color: var(--gold);
            box-shadow: var(--shadow-lg);
        }

        .error-page__icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .error-page__icon--danger {
            background: #f8d7da;
            color: #dc3545;
        }

        .error-page__icon--warning {
            background: #fff3cd;
            color: #e8a838;
        }

        .error-page__icon--info {
            background: #cce5ff;
            color: #004085;
        }

        .error-page__icon--success {
            background: #d4edda;
            color: #28a745;
        }

        .error-page__icon i {
            font-size: 2.8rem;
        }

        .error-page__code {
            font-family: var(--font-serif);
            font-weight: 900;
            font-size: 4rem;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 4px;
        }

        .error-page__title {
            font-family: var(--font-serif);
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--text);
            margin-bottom: 8px;
        }

        .error-page__text {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .error-page__actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .error-page__actions .btn {
            min-width: 140px;
            justify-content: center;
        }

        .error-page__help {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 20px;
        }

        .error-page__help i {
            color: var(--gold);
            margin-right: 4px;
        }

        @media (max-width: 540px) {
            .error-page__card {
                padding: 40px 24px;
            }

            .error-page__code {
                font-size: 3rem;
            }

            .error-page__title {
                font-size: 1.4rem;
            }

            .error-page__text {
                font-size: 0.95rem;
            }

            .error-page__actions {
                flex-direction: column;
                align-items: stretch;
            }

            .error-page__actions .btn {
                width: 100%;
                min-width: unset;
            }
        }

        @media (max-width: 400px) {
            .error-page__card {
                padding: 32px 16px;
            }

            .error-page__code {
                font-size: 2.4rem;
            }

            .error-page__title {
                font-size: 1.2rem;
            }

            .error-page__icon {
                width: 60px;
                height: 60px;
            }

            .error-page__icon i {
                font-size: 2rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ─── FLOATING ORBS ─── --}}
    <div class="floating-orbs">
        <div class="orb orb--1"></div>
        <div class="orb orb--2"></div>
        <div class="orb orb--3"></div>
        <div class="orb orb--4"></div>
        <div class="orb orb--5"></div>
    </div>

    {{-- ─── MAIN CONTENT ─── --}}
    <div class="error-page">
        <div class="error-page__card">
            @yield('content')
        </div>
    </div>

</body>
</html>