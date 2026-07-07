<nav class="navbar" id="navbar" role="navigation" aria-label="Main Navigation">
    <div class="navbar__inner">
        <a href="{{ route('home') }}" class="navbar__brand" aria-label="Home">
            <span class="navbar__brand-text">{{ env('PROJECT_NAME', 'The Collective') }}</span>
            <span class="navbar__brand-dot"></span>
        </a>

        <div class="navbar__desktop">
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
                        <span class="navbar__link-label">About</span>
                    </a>
                </li>
                <li class="navbar__item" role="none">
                    <a href="{{ route('books.index') }}" class="navbar__link {{ request()->routeIs('books.*') ? 'navbar__link--active' : '' }}" role="menuitem">
                        <span class="navbar__link-icon"><i class="fas fa-book" aria-hidden="true"></i></span>
                        <span class="navbar__link-label">Books</span>
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
                    <a href="{{ route('resources') }}" class="navbar__link {{ request()->routeIs('resources') ? 'navbar__link--active' : '' }}" role="menuitem">
                        <span class="navbar__link-icon"><i class="fas fa-download" aria-hidden="true"></i></span>
                        <span class="navbar__link-label">Resources</span>
                    </a>
                </li>
            </ul>
            <a href="{{ route('contact') }}" class="navbar__cta {{ request()->routeIs('contact') ? 'navbar__cta--active' : '' }}">
                <span>Get in Touch</span>
                <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <button class="navbar__toggle" id="navbarToggle" aria-label="Toggle navigation menu" aria-expanded="false">
            <span class="navbar__toggle-bar"></span>
            <span class="navbar__toggle-bar"></span>
            <span class="navbar__toggle-bar"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
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
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('about') }}" class="navbar__mobile-link {{ request()->routeIs('about') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">About</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('books.index') }}" class="navbar__mobile-link {{ request()->routeIs('books.*') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-book" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Books</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('events.index') }}" class="navbar__mobile-link {{ request()->routeIs('events.*') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Events</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('baptism') }}" class="navbar__mobile-link {{ request()->routeIs('baptism') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-water" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Baptism</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('community') }}" class="navbar__mobile-link {{ request()->routeIs('community') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fab fa-whatsapp" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Community</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item" role="none">
                <a href="{{ route('resources') }}" class="navbar__mobile-link {{ request()->routeIs('resources') ? 'navbar__mobile-link--active' : '' }}" role="menuitem">
                    <span class="navbar__mobile-icon"><i class="fas fa-download" aria-hidden="true"></i></span>
                    <span class="navbar__mobile-label">Resources</span>
                    <i class="fas fa-chevron-right navbar__mobile-arrow" aria-hidden="true"></i>
                </a>
            </li>
            <li class="navbar__mobile-item navbar__mobile-item--cta" role="none">
                <a href="{{ route('contact') }}" class="navbar__mobile-cta">
                    <span>Get in Touch</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
        <div class="navbar__mobile-footer">
            <span class="navbar__mobile-copy">&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'The Collective') }}</span>
        </div>
    </div>

    <!-- Overlay -->
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