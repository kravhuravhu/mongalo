<footer class="footer">
    <div class="wrap">
        <div class="footer__inner">
            {{-- ─── BRAND ─── --}}
            <div class="footer__brand-section">
                <img src="{{ secure_asset('images/blood_water_spirit_Logo-Photoroom.png') }}" alt="Blood Water Spirit Logo" class="footer__brand-img">
                <span class="footer__brand-tagline">{{ env('PROJECT_NAME') }}</span>
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
                    <li><a href="{{ route('invite') }}">Invite a Speaker</a></li>
                </ul>
            </div>

            {{-- ─── CONTACT ─── --}}
            <div class="footer__contact-section">
                <h4>Get in Touch</h4>

                <div class="footer__contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:{{ env('ADMIN_EMAIL') }}">{{ env('ADMIN_EMAIL') }}</a>
                </div>

                <div class="footer__contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:{{ env('CONTACT_PHONE') }}">{{ env('CONTACT_PHONE') }}</a>
                </div>

                <div class="footer__contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Gauteng, South Africa</span>
                </div>

                <div class="footer__social-links">
                    <a href=" {{ env('FACEBOOK_INVITE_URL') }}" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ env('INSTAGRAM_INVITE_URL') }}" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href=" {{ env('YOUTUBE_INVITE_URL') }} " aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="{{ env('WHATSAPP_INVITE_URL') }}" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        {{-- ─── BOTTOM BAR ─── --}}
        <div class="footer__bottom">
            <span>&copy; {{ date('Y') }} {{ env('PROJECT_NAME', 'Blood Water Spirit') }}. All rights reserved.</span>
            <span>
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <span class="footer__bottom-divider">·</span>
                <a href="{{ route('terms') }}">Terms of Service</a>
            </span>
        </div>
    </div>
</footer>