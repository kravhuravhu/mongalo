<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin · ' . env('PROJECT_NAME', 'The Collective'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/admin/admin.css') }}">
    @stack('styles')
</head>
<body>

<div class="admin-wrapper">
    {{-- Sidebar --}}
    @include('admin.components.sidebar')

    {{-- Main Content --}}
    <div class="admin-content">
        {{-- Top Bar --}}
        @include('admin.components.topbar')

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>
    </div>
</div>

<!-- Admin JS -->
<script src="{{ secure_asset('js/admin.js') }}"></script>
@stack('scripts')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-message flash-message--success" id="flashMessage">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="flash-message flash-message--error" id="flashMessage">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flash = document.getElementById('flashMessage');
        if (flash) {
            setTimeout(function() {
                flash.style.opacity = '0';
                flash.style.transform = 'translateX(40px)';
                flash.style.transition = 'all 0.4s ease';
                setTimeout(function() { flash.remove(); }, 500);
            }, 5000);
        }
    });
</script>

</body>
</html>