@php
    $activeTheme = 'gold';
    if (request()->routeIs('baptism*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('books*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('events*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('community*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('contact*') || request()->routeIs('invite*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('home*')) {
        $activeTheme = 'gold';
    } elseif (request()->routeIs('about*')) {
        $activeTheme = 'gold';
    }
@endphp

<nav class="navbar navbar--theme-{{ $activeTheme }}" id="navbar" role="navigation" aria-label="Main Navigation">
    <div class="navbar__inner">
        {{-- LEFT: Logo --}}
        <a href="{{ route('home') }}" class="navbar__brand" aria-label="Home">
            <span class="navbar__brand-text">{{ env('PROJECT_NAME', 'The Collective') }}</span>
            <span class="navbar__brand-dot"></span>
        </a>

        {{-- CENTER: Nav Items --}}
        <ul class="navbar__links" role="menubar">
            <li class="navbar__item" role="none">
                <a href="{{ route('home') }}" class="navbar__link {{ request()->routeIs('home') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-home" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Home</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('about') }}" class="navbar__link {{ request()->routeIs('about') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Our Story</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('books.index') }}" class="navbar__link {{ request()->routeIs('books.*') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-book" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Books &amp; Resources</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('events.index') }}" class="navbar__link {{ request()->routeIs('events.*') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Events</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('baptism') }}" class="navbar__link {{ request()->routeIs('baptism') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-water" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Baptism</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('community') }}" class="navbar__link {{ request()->routeIs('community') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Community</span>
                </a>
            </li>
            <li class="navbar__item" role="none">
                <a href="{{ route('contact') }}" class="navbar__link {{ request()->routeIs('contact') ? 'navbar__link--active' : '' }}" role="menuitem">
                    <span class="navbar__link-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                    <span class="navbar__link-label">Contact</span>
                </a>
            </li>
        </ul>

        {{-- RIGHT: Invite Arthur CTA --}}
        <a href="{{ route('invite') }}" class="navbar__cta {{ request()->routeIs('invite') ? 'navbar__cta--active' : '' }}">
            <i class="fas fa-handshake" aria-hidden="true"></i>
            <span>Invite Arthur</span>
        </a>

        <button class="navbar__toggle" id="navbarToggle" aria-label="Toggle navigation menu" aria-expanded="false">
            <span class="navbar__toggle-bar"></span>
            <span class="navbar__toggle-bar"></span>
            <span class="navbar__toggle-bar"></span>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div class="navbar__mobile" id="navbarMobile" role="dialog" aria-modal="true" aria-label="Mobile navigation">
        <div class="navbar__mobile-header">
            <span class="navbar__mobile-brand">{{ env('PROJECT_NAME', 'The Collective') }}</span>
            <button class="navbar__mobile-close" id="navbarMobileClose" aria-label="Close navigation menu">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <ul class="navbar__mobile-links" role="menubar">
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('home') }}" class="navbar__mobile-link {{ request()->routeIs('home') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-home" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Home</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('about') }}" class="navbar__mobile-link {{ request()->routeIs('about') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Our Story</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('books.index') }}" class="navbar__mobile-link {{ request()->routeIs('books.*') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-book" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Books &amp; Resources</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('events.index') }}" class="navbar__mobile-link {{ request()->routeIs('events.*') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Events</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('baptism') }}" class="navbar__mobile-link {{ request()->routeIs('baptism') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-water" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Baptism</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('community') }}" class="navbar__mobile-link {{ request()->routeIs('community') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Community</span>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('contact') }}" class="navbar__mobile-link {{ request()->routeIs('contact') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Get in Touch</span>
                </a>
            </li>
            <li class="navbar__mobile-item navbar__mobile-item--cta" role="none">
                <a href="{{ route('invite') }}" class="navbar__mobile-cta">
                    <i class="fas fa-handshake" aria-hidden="true"></i>
                    <span>Invite Arthur</span>
                </a>
            </li>
        </ul>
        <div class="navbar__mobile-footer">
            <span class="navbar__mobile-copy">&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }}</span>
        </div>
    </div>

    <div class="navbar__overlay" id="navbarOverlay"></div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── NAVBAR TOGGLE ───
    const toggle = document.getElementById('navbarToggle');
    const mobile = document.getElementById('navbarMobile');
    const overlay = document.getElementById('navbarOverlay');
    const closeBtn = document.getElementById('navbarMobileClose');
    const body = document.body;

    function openNav() {
        mobile.classList.add('navbar__mobile--open');
        overlay.classList.add('navbar__overlay--open');
        toggle.setAttribute('aria-expanded', 'true');
        body.style.overflow = 'hidden';
        body.style.position = 'fixed';
        body.style.width = '100%';
        body.style.top = '-' + window.scrollY + 'px';
    }

    function closeNav() {
        const scrollY = parseInt(body.style.top || '0') * -1;
        mobile.classList.remove('navbar__mobile--open');
        overlay.classList.remove('navbar__overlay--open');
        toggle.setAttribute('aria-expanded', 'false');
        body.style.overflow = '';
        body.style.position = '';
        body.style.width = '';
        body.style.top = '';
        window.scrollTo(0, scrollY);
    }

    toggle.addEventListener('click', function() {
        if (mobile.classList.contains('navbar__mobile--open')) {
            closeNav();
        } else {
            openNav();
        }
    });

    closeBtn.addEventListener('click', closeNav);
    overlay.addEventListener('click', closeNav);

    // ─── CLOSE NAV ON LINK CLICK ───
    document.querySelectorAll('.navbar__mobile-link, .navbar__mobile-cta').forEach(function(link) {
        link.addEventListener('click', function() {
            setTimeout(closeNav, 300);
        });
    });

    // ─── CLOSE NAV ON ESC ───
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNav();
        }
    });

    // ─── CLOSE NAV ON RESIZE ───
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 1024) {
                closeNav();
            }
        }, 200);
    });

    // ─── NAVBAR SCROLL ───
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 80) {
            navbar.classList.add('navbar--scrolled');
        } else {
            navbar.classList.remove('navbar--scrolled');
        }

        if (currentScroll > lastScroll && currentScroll > 200) {
            navbar.classList.add('navbar--hidden');
        } else {
            navbar.classList.remove('navbar--hidden');
        }
        
        lastScroll = currentScroll;
    }, { passive: true });
});
</script>
@endpush