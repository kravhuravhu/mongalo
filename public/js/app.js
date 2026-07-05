function toggleNav() {
    const burger = document.getElementById('burger');
    const navLinks = document.getElementById('navLinks');
    burger.classList.toggle('open');
    navLinks.classList.toggle('open');
    document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
}

document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.getElementById('navLinks');
    if (navLinks) {
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 820) {
                    document.getElementById('burger').classList.remove('open');
                    navLinks.classList.remove('open');
                    document.body.style.overflow = '';
                }
            });
        });
    }
});

const COOKIE_NAME = 'whatsapp_popup';

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}

function setCookie(name, value, minutes) {
    const date = new Date();
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    document.cookie = name + '=' + value + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax';
}

function showWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    if (popup) {
        popup.classList.add('show');
    }
}

function hideWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    if (popup) {
        popup.classList.remove('show');
    }
}

function dismissPopup() {
    setCookie(COOKIE_NAME, 'dismissed', 999999);
    hideWhatsAppPopup();
}

function remindLater() {
    setCookie(COOKIE_NAME, 'remind', 30);
    hideWhatsAppPopup();
}

function joinCommunity() {
    setCookie(COOKIE_NAME, 'dismissed', 999999);
    hideWhatsAppPopup();
}

document.addEventListener('DOMContentLoaded', function() {
    const cookie = getCookie(COOKIE_NAME);
    if (!cookie) {
        setTimeout(showWhatsAppPopup, 3000);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const registrationForm = document.getElementById('eventRegistrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.textContent = 'Registering...';
            submitBtn.disabled = true;

            fetch('{{ route("events.register") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const msg = document.getElementById('registrationMessage');
                    if (msg) {
                        msg.innerHTML = `
                            <div style="background:#d4edda;color:#155724;padding:16px 20px;border-radius:10px;margin-bottom:20px;">
                                <i class="fas fa-check-circle"></i> ${data.message}
                                <br><small>Registration ID: ${data.registration_id}</small>
                            </div>
                        `;
                    }

                    // Show WhatsApp popup
                    if (data.show_whatsapp) {
                        setTimeout(showWhatsAppPopup, 1000);
                    }

                    // Reset form
                    registrationForm.reset();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

function addToCalendar(eventId) {
    alert('A calendar invite will be sent to your email after registration.');
}