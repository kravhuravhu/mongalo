@php
    $showPopup = true;
    $cookieName = 'whatsapp_popup_dismissed';
    $sessionKey = 'whatsapp_popup_shown';
    $isMobile = false;
    
    if (isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] === 'dismissed') {
        $showPopup = false;
    }
    
    if (session()->has($sessionKey) && session($sessionKey) === 'shown') {
        $showPopup = false;
    }
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $mobileAgents = ['Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 'Windows Phone'];
    foreach ($mobileAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            $isMobile = true;
            break;
        }
    }
@endphp

{{-- ─── MINIMIZED BADGE ─── --}}
<div id="whatsappPopupMinimized" class="whatsapp-popup-minimized" onclick="restoreWhatsAppPopup()" style="display: {{ (session()->has($sessionKey) || $isMobile) ? 'flex' : 'none' }};">
    <i class="fab fa-whatsapp"></i>
    <span>Join Community</span>
</div>

@if($showPopup && !$isMobile)
<div id="whatsappPopup" class="whatsapp-popup">
    <div class="whatsapp-popup__content">
        <button class="whatsapp-popup__minimize" onclick="minimizeWhatsAppPopup()" aria-label="Minimize popup">
            <span>—</span>
        </button>

        <div class="whatsapp-popup__icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <h3 class="whatsapp-popup__title">Join IN.iN Community</h3>
        <p class="whatsapp-popup__desc">Connect with believers on WhatsApp. Daily encouragement, book updates, and be part of the journey.</p>
        
        <div class="whatsapp-popup__stats">
            <span><i class="fas fa-users"></i> Growing community</span>
            <span><i class="fas fa-check-circle"></i> Free to join</span>
        </div>

        <div class="whatsapp-popup__timer">
            <span class="whatsapp-popup__timer-label">Closes in</span>
            <span class="whatsapp-popup__timer-countdown" id="whatsappCountdown">15</span>
            <span class="whatsapp-popup__timer-label">s</span>
        </div>

        <div class="whatsapp-popup__actions">
            <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary" onclick="joinCommunity()">
                <i class="fab fa-whatsapp"></i> Join Community
            </a>
            <button class="btn btn--outline" onclick="remindLater()">Remind Me Later</button>
            <button class="btn btn--text" onclick="dismissPopup()">Not Now</button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    const COOKIE_NAME = 'whatsapp_popup_dismissed';
    const SESSION_KEY = 'whatsapp_popup_shown';
    let countdownTimer = null;
    let countdownSeconds = 15;

    function getCookie(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    function setCookie(name, value, minutes) {
        const date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        document.cookie = name + '=' + value + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax';
    }

    function initWhatsAppPopup() {
        const isDismissed = getCookie(COOKIE_NAME) === 'dismissed';
        const isShown = sessionStorage.getItem(SESSION_KEY) === 'true';
        const popup = document.getElementById('whatsappPopup');
        const minimized = document.getElementById('whatsappPopupMinimized');
        const isMobile = window.innerWidth <= 520;

        if (isDismissed) {
            if (popup) popup.style.display = 'none';
            if (minimized) minimized.style.display = 'none';
            return;
        }

        if (isShown) {
            if (popup) popup.style.display = 'none';
            if (minimized) minimized.style.display = 'flex';
            return;
        }

        if (isMobile) {
            if (minimized) minimized.style.display = 'flex';
            sessionStorage.setItem(SESSION_KEY, 'true');
            return;
        }

        if (!isDismissed && !isShown) {
            setTimeout(function() {
                if (popup) {
                    popup.classList.add('show');
                    startCountdown();
                    sessionStorage.setItem(SESSION_KEY, 'true');
                }
            }, 3000);
        }
    }

    function startCountdown() {
        const countdownEl = document.getElementById('whatsappCountdown');
        if (!countdownEl) return;

        countdownSeconds = 15;
        countdownEl.textContent = countdownSeconds;
        countdownEl.classList.remove('whatsapp-popup__timer-countdown--warning');

        if (countdownTimer) clearInterval(countdownTimer);

        countdownTimer = setInterval(function() {
            countdownSeconds--;

            if (countdownEl) {
                countdownEl.textContent = countdownSeconds;

                if (countdownSeconds <= 5) {
                    countdownEl.classList.add('whatsapp-popup__timer-countdown--warning');
                } else {
                    countdownEl.classList.remove('whatsapp-popup__timer-countdown--warning');
                }
            }

            if (countdownSeconds <= 0) {
                clearInterval(countdownTimer);
                countdownTimer = null;
                minimizeWhatsAppPopup();
            }
        }, 1000);
    }

    function minimizeWhatsAppPopup() {
        const popup = document.getElementById('whatsappPopup');
        const minimized = document.getElementById('whatsappPopupMinimized');

        if (popup) {
            popup.classList.remove('show');
            popup.style.display = 'none';
        }
        if (minimized) {
            minimized.style.display = 'flex';
        }

        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }
    }

    function restoreWhatsAppPopup() {
        const popup = document.getElementById('whatsappPopup');
        const minimized = document.getElementById('whatsappPopupMinimized');

        if (getCookie(COOKIE_NAME) === 'dismissed') {
            if (minimized) minimized.style.display = 'none';
            return;
        }

        if (popup) {
            popup.style.display = 'block';
            popup.classList.add('show');
            startCountdown();
        }
        if (minimized) {
            minimized.style.display = 'none';
        }
    }

    function dismissPopup() {
        setCookie(COOKIE_NAME, 'dismissed', 999999);
        const popup = document.getElementById('whatsappPopup');
        const minimized = document.getElementById('whatsappPopupMinimized');
        if (popup) {
            popup.classList.remove('show');
            popup.style.display = 'none';
        }
        if (minimized) minimized.style.display = 'none';
        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }
        sessionStorage.removeItem(SESSION_KEY);
    }

    function remindLater() {
        minimizeWhatsAppPopup();
    }

    function joinCommunity() {
        setCookie(COOKIE_NAME, 'dismissed', 999999);
        const popup = document.getElementById('whatsappPopup');
        const minimized = document.getElementById('whatsappPopupMinimized');
        if (popup) {
            popup.classList.remove('show');
            popup.style.display = 'none';
        }
        if (minimized) minimized.style.display = 'none';
        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }
        sessionStorage.removeItem(SESSION_KEY);
        const whatsappUrl = document.querySelector('.whatsapp-popup__actions .btn--primary')?.href;
        if (whatsappUrl && whatsappUrl !== '#') {
            window.open(whatsappUrl, '_blank');
        }
    }

    document.addEventListener('DOMContentLoaded', initWhatsAppPopup);
</script>
@endpush