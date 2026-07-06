<nav class="navbar" id="navbar">
    <div class="navbar__inner">
        <a href="{{ route('home') }}" class="navbar__logo">
            {{ env('PROJECT_NAME', 'The Collective') }}
        </a>

        <ul class="navbar__links" id="navLinks">
            <!-- Mobile close button -->
            <button class="navbar__close" id="navClose" onclick="toggleNav()">

            </button>

            <li class="navbar__item">
                <a href="{{ route('home') }}" class="navbar__link {{ request()->routeIs('home') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-home"></i></span>
                    Home
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('about') }}" class="navbar__link {{ request()->routeIs('about') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-users"></i></span>
                    About
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('books.index') }}" class="navbar__link {{ request()->routeIs('books.*') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-book"></i></span>
                    Books
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('events.index') }}" class="navbar__link {{ request()->routeIs('events.*') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-calendar"></i></span>
                    Events
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('baptism') }}" class="navbar__link {{ request()->routeIs('baptism') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-water"></i></span>
                    Baptism
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('community') }}" class="navbar__link {{ request()->routeIs('community') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fab fa-whatsapp"></i></span>
                    Community
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('resources') }}" class="navbar__link {{ request()->routeIs('resources') ? 'navbar__link--active' : '' }}">
                    <span class="navbar__link-icon"><i class="fas fa-download"></i></span>
                    Resources
                </a>
            </li>
            <li class="navbar__item">
                <a href="{{ route('contact') }}" class="navbar__cta {{ request()->routeIs('contact') ? 'navbar__cta--active' : '' }}">
                    Get in Touch
                </a>
            </li>
        </ul>

        <button class="navbar__burger" id="burger" onclick="toggleNav()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>