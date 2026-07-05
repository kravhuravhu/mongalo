<nav class="navbar">
    <div class="wrap">
        <div class="nav-row">
            <a href="{{ route('home') }}" class="logo">The <span>Collective</span></a>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('books.index') }}">Books</a></li>
                <li><a href="{{ route('events.index') }}">Events</a></li>
                <li><a href="{{ route('baptism') }}">Baptism</a></li>
                <li><a href="{{ route('community') }}">Community</a></li>
                <li><a href="{{ route('resources') }}">Resources</a></li>
                <li><a href="{{ route('contact') }}" class="nav-cta">Get in Touch</a></li>
            </ul>
            <button class="burger" id="burger" onclick="toggleNav()">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>