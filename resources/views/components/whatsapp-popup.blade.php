@php
    $showPopup = true;
    $cookieName = 'whatsapp_popup_dismissed';
    $sessionKey = 'whatsapp_popup_shown';
    $isMobile = false;
    
    // ─── CHECK COOKIE ───
    if (isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] === 'dismissed') {
        $showPopup = false;
    }
    
    // ─── CHECK SESSION ───
    if (session()->has($sessionKey) && session($sessionKey) === 'shown') {
        $showPopup = false;
    }
    
    // ─── DETECT MOBILE ───
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
    <span class="whatsapp-popup-minimized__badge" id="whatsappMinimizedBadge"></span>
</div>

@if($showPopup && !$isMobile)
<div id="whatsappPopup" class="whatsapp-popup">
    <div class="whatsapp-popup__content">
        <button class="whatsapp-popup__minimize" onclick="minimizeWhatsAppPopup()" aria-label="Minimize popup">
            <span class="whatsapp-popup__minimize-icon">—</span>
        </button>

        <div class="whatsapp-popup__icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <h3 class="whatsapp-popup__title">Join {{ env('PROJECT_NAME', 'The Collective') }}</h3>
        <p class="whatsapp-popup__desc">Connect with hundreds of believers on WhatsApp. Get daily encouragement, book updates, and be part of the journey.</p>
        
        <div class="whatsapp-popup__stats">
            <span><i class="fas fa-users"></i> 247+ members</span>
            <span><i class="fas fa-check-circle"></i> Free to join</span>
        </div>

        {{-- ─── COUNTDOWN TIMER ─── --}}
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
            <button class="btn btn--text" onclick="dismissPopup()">Nope, Not Now</button>
        </div>
    </div>
</div>
@endif