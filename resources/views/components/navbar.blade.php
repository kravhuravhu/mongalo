<nav class="navbar">
    <div class="wrap">
        <div class="navbar__inner">
            <a href="{{ route('home') }}" class="navbar__logo">The <span>Collective</span></a>
            <ul class="navbar__links" id="navLinks">
                <li class="navbar__item">
                    <a href="{{ route('home') }}" class="navbar__link {{ request()->routeIs('home') ? 'navbar__link--active' : '' }}">
                        Home
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('about') }}" class="navbar__link {{ request()->routeIs('about') ? 'navbar__link--active' : '' }}">
                        About
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('books.index') }}" class="navbar__link {{ request()->routeIs('books.*') ? 'navbar__link--active' : '' }}">
                        Books
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('events.index') }}" class="navbar__link {{ request()->routeIs('events.*') ? 'navbar__link--active' : '' }}">
                        Events
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('baptism') }}" class="navbar__link {{ request()->routeIs('baptism') ? 'navbar__link--active' : '' }}">
                        Baptism
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('community') }}" class="navbar__link {{ request()->routeIs('community') ? 'navbar__link--active' : '' }}">
                        Community
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('resources') }}" class="navbar__link {{ request()->routeIs('resources') ? 'navbar__link--active' : '' }}">
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
    </div>
</nav>