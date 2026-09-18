<footer class="footer">
    <div class="wrap">
        <div class="footer__inner">
            {{-- ─── BRAND ─── --}}
            <div class="footer__brand-section">
                <span class="footer__brand">
                    <span class="brand-gold">I</span>N<span class="brand-dot">.</span><span class="brand-gold">i</span>N
                </span>
                <span class="footer__brand-tagline">I am IN Him // He is IN me</span>
                <p class="footer__brand-desc">
                    A movement of faith built on immersion and indwelling. 
                    Baptising, praying and equipping believers for a deeper walk 
                    and a greater impact.
                </p>
            </div>

            {{-- ─── EXPLORE ─── --}}
            <div class="footer__nav">
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">My Story</a></li>
                    <li><a href="{{ route('books.index') }}">Books</a></li>
                    <li><a href="{{ route('resources') }}">Free Resources</a></li>
                </ul>
            </div>

            {{-- ─── CONNECT ─── --}}
            <div class="footer__nav">
                <h4>Connect</h4>
                <ul>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('baptism') }}">Baptism</a></li>
                    <li><a href="{{ route('community') }}">Community</a></li>
                    <li><a href="{{ route('invite') }}">Invite Arthur</a></li>
                </ul>
            </div>

            {{-- ─── CONTACT ─── --}}
            <div class="footer__contact-section">
                <h4>Get in Touch</h4>

                <div class="footer__contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:hello@in-in.co.za">hello@in-in.co.za</a>
                </div>

                <div class="footer__contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+27714611401">+27 71 461 1401</a>
                </div>

                <div class="footer__contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Gauteng, South Africa</span>
                </div>

                <div class="footer__social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        {{-- ─── BOTTOM BAR ─── --}}
        <div class="footer__bottom">
            <span>&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'IN.iN') }}. All rights reserved.</span>
            <span>
                <a href="#">Privacy Policy</a>
                <span class="footer__bottom-divider">·</span>
                <a href="#">Terms of Service</a>
            </span>
        </div>
    </div>
</footer>