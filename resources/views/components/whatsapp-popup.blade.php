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
        <div class="whatsapp-popup__actions">
            <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary" onclick="joinCommunity()">
                <i class="fab fa-whatsapp"></i> Join Community
            </a>
            <button class="btn btn--outline" onclick="remindLater()">Remind Me Later</button>
            <button class="btn btn--text" onclick="dismissPopup()">Nope, Not Now</button>
        </div>
    </div>
</div>

<div id="whatsappPopupMinimized" class="whatsapp-popup-minimized" onclick="restoreWhatsAppPopup()" style="display:none;">
    <i class="fab fa-whatsapp"></i>
    <span>Join Community</span>
</div>