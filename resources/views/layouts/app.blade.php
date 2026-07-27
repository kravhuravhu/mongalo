<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('PROJECT_NAME', 'The Collective') . ' · Faith · Salvation · Baptism · Growth')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&family=EB+Garamond:ital@0;1&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/books.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/invite.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/baptism.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/community.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/contact.css') }}">
    @stack('styles')
</head>
<body class="@yield('page-class', 'page-default')">

    {{-- ─── LOADING SPINNER ─── --}}
    <div class="app-loader" id="appLoader">
        <div class="app-loader__spinner">
            <div class="app-loader__ring app-loader__ring--1"></div>
            <div class="app-loader__ring app-loader__ring--2"></div>
            <div class="app-loader__ring app-loader__ring--3"></div>
            <span class="app-loader__text">Loading...</span>
        </div>
    </div>

    {{-- ─── FLASH MESSAGES ─── --}}
    @if(session('success'))
        <div class="flash-message-app flash-message-app--success" id="flashMessageApp">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-message-app flash-message-app--error" id="flashMessageApp">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('warning'))
        <div class="flash-message-app flash-message-app--warning" id="flashMessageApp">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('warning') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    {{-- Floating Orbs --}}
    <div class="floating-orbs">
        <div class="orb orb--1"></div>
        <div class="orb orb--2"></div>
        <div class="orb orb--3"></div>
        <div class="orb orb--4"></div>
        <div class="orb orb--5"></div>
    </div>

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Popup -->
    @include('components.whatsapp-popup')

    <!-- Scroll to Top -->
    @include('components.scroll-top')

    <!-- Main JS -->
    <script src="{{ secure_asset('js/app.js') }}"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── HIDE LOADER ───
            const loader = document.getElementById('appLoader');
            if (loader) {
                // Wait for all resources to load
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        loader.classList.add('app-loader--hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                        }, 500);
                    }, 400);
                });

                // Fallback: hide loader
                setTimeout(function() {
                    if (!loader.classList.contains('app-loader--hidden')) {
                        loader.classList.add('app-loader--hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                        }, 500);
                    }
                }, 4500);
            }

            // ─── FLASH MESSAGES AUTO-DISMISS ───
            const flash = document.getElementById('flashMessageApp');
            if (flash) {
                setTimeout(function() {
                    flash.classList.add('flash-message-app--fade-out');
                    setTimeout(function() {
                        flash.remove();
                    }, 400);
                }, 5000);
            }

            // ─── FORM SUBMIT WITH LOADING ───
            document.querySelectorAll('.form-loading').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                        // Re-enable after 30 seconds
                        setTimeout(function() {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        }, 30000);
                    }
                });
            });
        });
    </script>

</body>
</html>