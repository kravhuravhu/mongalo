<footer class="page__footer">
    <div class="page__footer-inner">
        <div class="page__footer-brand">
            <span class="page__footer-mark">AM</span>
            <span>Arthur Mongalo Ministry</span>
        </div>
        <p>&copy; {{ date('Y') }} Arthur Mongalo. All rights reserved.</p>
        <div class="page__footer-links">
            <a href="{{ route('privacy') }}">Privacy</a>
            <a href="{{ route('terms') }}">Terms</a>
            <a href="{{ route('contact') }}">Contact</a>
            <x-v160.cta-link channel="whatsapp" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></x-v160.cta-link>
            <x-v160.cta-link channel="instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></x-v160.cta-link>
            <x-v160.cta-link channel="facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></x-v160.cta-link>
            <x-v160.cta-link channel="youtube" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></x-v160.cta-link>
        </div>
    </div>
</footer>