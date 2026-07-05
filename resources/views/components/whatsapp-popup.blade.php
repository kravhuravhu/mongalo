<div id="whatsappPopup" class="whatsapp-popup">
    <div class="whatsapp-popup-content">
        <div class="popup-icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <h3>Join The Collective Community</h3>
        <p>Connect with hundreds of believers on WhatsApp. Get daily encouragement, book updates, and be part of the journey.</p>
        <div class="popup-stats">
            <span><i class="fas fa-users"></i> 247+ members</span>
            <span><i class="fas fa-check-circle"></i> Free to join</span>
        </div>
        <div class="popup-buttons">
            <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn-primary" onclick="joinCommunity()">
                <i class="fab fa-whatsapp"></i> Join Community
            </a>
            <button class="btn btn-outline" onclick="remindLater()">Remind Me Later</button>
            <button class="btn btn-text" onclick="dismissPopup()">Nope, Not Now</button>
        </div>
    </div>
</div>