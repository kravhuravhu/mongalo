@php
    // ─── DETERMINE IF HERO PAGE OR SOLID PAGE ───
    $isHeroPage = request()->routeIs('home') || request()->routeIs('book.*') || request()->routeIs('resources') || request()->routeIs('events.*') || request()->routeIs('baptism');
    $navbarClass = $isHeroPage ? 'global-navbar' : 'global-navbar global-navbar--solid';
@endphp

<nav class="{{ $navbarClass }}" id="globalNavbar" role="navigation" aria-label="Main Navigation">
    <div class="wrap">
        <div class="global-navbar__inner">

            {{-- ─── LEFT NAV LINKS ─── --}}
            <ul class="global-navbar__links global-navbar__links--left" role="menubar">
                <li role="none">
                    <a href="{{ route('home') }}" class="global-navbar__link {{ request()->routeIs('home') ? 'global-navbar__link--active' : '' }}" role="menuitem">Home</a>
                </li>
                <li role="none">
                    <a href="{{ route('about') }}" class="global-navbar__link {{ request()->routeIs('about') ? 'global-navbar__link--active' : '' }}" role="menuitem">My Story</a>
                </li>
                <li role="none">
                    <a href="{{ route('books.index') }}" class="global-navbar__link {{ request()->routeIs('books') || request()->routeIs('books.*')  ? 'global-navbar__link--active' : '' }}" role="menuitem">Books</a>
                </li>
                <li role="none">
                    <a href="{{ route('resources') }}" class="global-navbar__link {{ request()->routeIs('resources') || request()->routeIs('resources.*') ? 'global-navbar__link--active' : '' }}" role="menuitem">Free Resources</a>
                </li>
            </ul>

            {{-- ─── CENTER BRAND ─── --}}
            <a href="{{ route('home') }}" class="global-navbar__brand" aria-label="Home">
                <span class="global-navbar__brand-text">
                    <span class="brand-gold">I</span>N<span class="brand-dot">.</span><span class="brand-gold">i</span>N
                </span>
                <span class="global-navbar__brand-slogan">In Him · In You · In Us</span>
            </a>

            {{-- ─── RIGHT NAV LINKS ─── --}}
            <ul class="global-navbar__links global-navbar__links--right" role="menubar">
                <li role="none">
                    <a href="{{ route('events.index') }}" class="global-navbar__link {{ request()->routeIs('events.*') ? 'global-navbar__link--active' : '' }}" role="menuitem">Events</a>
                </li>
                <li role="none">
                    <a href="{{ route('baptism') }}" class="global-navbar__link {{ request()->routeIs('baptism') ? 'global-navbar__link--active' : '' }}" role="menuitem">Baptism</a>
                </li>
                <li role="none">
                    <a href="{{ route('community') }}" class="global-navbar__link {{ request()->routeIs('community') ? 'global-navbar__link--active' : '' }}" role="menuitem">Community</a>
                </li>
                <li role="none">
                    <a href="{{ route('contact') }}" class="global-navbar__link {{ request()->routeIs('contact') ? 'global-navbar__link--active' : '' }}" role="menuitem">Contact</a>
                </li>
                <li role="none">
                    <a href="{{ route('invite') }}" class="global-navbar__link global-navbar__link--cta {{ request()->routeIs('invite') ? 'global-navbar__link--cta-active' : '' }}" role="menuitem">
                        <i class="fas fa-handshake" aria-hidden="true"></i>
                        <span>Invite Arthur</span>
                    </a>
                </li>
            </ul>

            {{-- ─── HAMBURGER TOGGLE ─── --}}
            <button class="global-navbar__toggle" id="globalNavToggle" aria-label="Toggle navigation menu" aria-expanded="false">
                <span class="global-navbar__toggle-bar"></span>
                <span class="global-navbar__toggle-bar"></span>
                <span class="global-navbar__toggle-bar"></span>
            </button>

        </div>
    </div>
</nav>