<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('PROJECT_NAME', 'IN.iN') . ' · I am IN Him // He is IN me')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&family=EB+Garamond:ital@0;1&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/v150/app.css') }}">

    <!-- Page Specific CSS -->
    @stack('styles')
</head>
<body class="@yield('page-class', 'page-default')">

    {{-- ─── LOADING SPINNER ─── --}}
    <div class="app-loader" id="appLoader">
        <div class="app-loader__spinner">
            <div class="app-loader__ring app-loader__ring--1"></div>
            <div class="app-loader__ring app-loader__ring--2"></div>
            <div class="app-loader__ring app-loader__ring--3"></div>
            <span class="app-loader__text">IN.iN</span>
        </div>
    </div>

    {{-- ─── FLASH MESSAGES ─── --}}
    @if(session('success'))
        <div class="flash-message-app flash-message-app--success" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-message-app flash-message-app--error" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('warning'))
        <div class="flash-message-app flash-message-app--warning" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('warning') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="flash-message-app flash-message-app--info" id="flashMessageApp" data-auto-dismiss="10000">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('info') }}</span>
            <button class="flash-message-app__close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    {{-- ─── GLOBAL STICKY NAVBAR ─── --}}
    @include('components.v150.navbar')

    <!-- ─── MAIN CONTENT ─── -->
    <main>
        @yield('content')
    </main>

    <!-- ─── FOOTER ─── -->
    @include('components.v150.footer')

    <!-- ─── WHATSAPP POPUP ─── -->
    @include('components.v150.whatsapp-popup')

    <!-- ─── SCROLL TO TOP ─── -->
    @include('components.v150.scroll-top')

    <!-- ─── MAIN JS ─── -->
    <script src="{{ secure_asset('js/v150/app.js') }}"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ─── HIDE LOADER ───
            const loader = document.getElementById('appLoader');
            if (loader) {
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        loader.classList.add('app-loader--hidden');
                        setTimeout(function() {
                            loader.style.display = 'none';
                        }, 500);
                    }, 400);
                });

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
                const dismissTimeout = parseInt(flash.dataset.autoDismiss) || 10000;
                setTimeout(function() {
                    flash.classList.add('flash-message-app--fade-out');
                    setTimeout(function() {
                        if (flash.parentNode) flash.remove();
                    }, 400);
                }, dismissTimeout);
            }
        });
    </script>

</body>
</html>