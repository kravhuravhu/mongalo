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

    {{-- ─── FLASH MESSAGES (PHP VERSION - ONLY USED WHEN CACHE IS ENABLED) ─── --}}
    @if(session('success') && env('PAGE_CACHE_ENABLED', true))
        <div class="flash-message-app flash-message-app--success" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error') && env('PAGE_CACHE_ENABLED', true))
        <div class="flash-message-app flash-message-app--error" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('warning') && env('PAGE_CACHE_ENABLED', true))
        <div class="flash-message-app flash-message-app--warning" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('warning') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('info') && env('PAGE_CACHE_ENABLED', true))
        <div class="flash-message-app flash-message-app--info" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    {{-- ─── FLASH MESSAGES (JAVASCRIPT VERSION - FALLBACK FOR CACHED PAGES) ─── --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
        <script>
            // ─── DEFINE FUNCTION IN GLOBAL SCOPE ───
            function showFlashMessage(message, type) {
                // ─── REMOVE EXISTING FLASH MESSAGES ───
                const existing = document.querySelectorAll('.flash-message-app');
                existing.forEach(function(el) {
                    el.remove();
                });

                const flash = document.createElement('div');
                flash.className = 'flash-message-app flash-message-app--' + type;
                
                let icon = 'fa-info-circle';
                if (type === 'success') icon = 'fa-check-circle';
                else if (type === 'error') icon = 'fa-exclamation-circle';
                else if (type === 'warning') icon = 'fa-exclamation-triangle';
                
                flash.innerHTML = `
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                    <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
                `;
                document.body.appendChild(flash);
                
                // ─── AUTO-DISMISS AFTER 10 SECONDS ───
                setTimeout(function() {
                    if (flash.parentNode) {
                        flash.classList.add('flash-message-app--fade-out');
                        setTimeout(function() {
                            if (flash.parentNode) {
                                flash.remove();
                            }
                        }, 400);
                    }
                }, 10000);
            }

            // ─── SHOW FLASH MESSAGES ON PAGE LOAD ───
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    showFlashMessage('{{ addslashes(session('success')) }}', 'success');
                @endif
                @if(session('error'))
                    showFlashMessage('{{ addslashes(session('error')) }}', 'error');
                @endif
                @if(session('warning'))
                    showFlashMessage('{{ addslashes(session('warning')) }}', 'warning');
                @endif
                @if(session('info'))
                    showFlashMessage('{{ addslashes(session('info')) }}', 'info');
                @endif
            });
        </script>
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

            // ─── PHP FLASH MESSAGES AUTO-DISMISS ───
            const flash = document.getElementById('flashMessageApp');
            if (flash) {
                const dismissTimeout = parseInt(flash.dataset.autoDismiss) || 10000;
                
                setTimeout(function() {
                    flash.classList.add('flash-message-app--fade-out');
                    setTimeout(function() {
                        if (flash.parentNode) {
                            flash.remove();
                        }
                    }, 400);
                }, dismissTimeout);
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