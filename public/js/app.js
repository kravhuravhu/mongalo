// ─── NAVBAR SCROLL ───
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('navbar--scrolled');
        }
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar--scrolled');
            } else {
                navbar.classList.remove('navbar--scrolled');
            }
        }, { passive: true });
    }
});

// ─── NAV TOGGLE ───
function toggleNav() {
    const burger = document.querySelector('.navbar__burger');
    const navLinks = document.querySelector('.navbar__links');
    const body = document.body;

    if (burger && navLinks) {
        burger.classList.toggle('navbar__burger--open');
        navLinks.classList.toggle('navbar__links--open');

        if (navLinks.classList.contains('navbar__links--open')) {
            body.style.overflow = 'hidden';
            body.style.position = 'fixed';
            body.style.width = '100%';
        } else {
            body.style.overflow = '';
            body.style.position = '';
            body.style.width = '';
        }
    }
}

// Close nav on link click (mobile)
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelector('.navbar__links');
    if (navLinks) {
        navLinks.querySelectorAll('.navbar__link, .navbar__cta').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 820) {
                    const burger = document.querySelector('.navbar__burger');
                    const body = document.body;
                    if (burger) {
                        burger.classList.remove('navbar__burger--open');
                    }
                    navLinks.classList.remove('navbar__links--open');
                    body.style.overflow = '';
                    body.style.position = '';
                    body.style.width = '';
                }
            });
        });
    }

    // Close nav on close button
    const closeBtn = document.querySelector('.navbar__close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            const burger = document.querySelector('.navbar__burger');
            const navLinks = document.querySelector('.navbar__links');
            const body = document.body;
            if (burger) {
                burger.classList.remove('navbar__burger--open');
            }
            if (navLinks) {
                navLinks.classList.remove('navbar__links--open');
            }
            body.style.overflow = '';
            body.style.position = '';
            body.style.width = '';
        });
    }
});

// ─── WHATSAPP POPUP ───
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

// Show WhatsApp popup on page load if no cookie
document.addEventListener('DOMContentLoaded', function() {
    const cookie = getCookie(COOKIE_NAME);
    if (!cookie) {
        setTimeout(showWhatsAppPopup, 3000);
    }
});

// ─── EVENT REGISTRATION ───
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
                    const msg = document.getElementById('registrationMessage');
                    if (msg) {
                        msg.innerHTML = `
                            <div style="background:#d4edda;color:#155724;padding:16px 20px;border-radius:10px;margin-bottom:20px;">
                                <i class="fas fa-check-circle"></i> ${data.message}
                                <br><small>Registration ID: ${data.registration_id}</small>
                                <br><a href="${data.calendar_link}" target="_blank" style="color:#155724;font-weight:600;text-decoration:underline;">
                                    <i class="fas fa-calendar-plus"></i> Add to Google Calendar
                                </a>
                            </div>
                        `;
                    }
                    if (data.show_whatsapp) {
                        setTimeout(showWhatsAppPopup, 1000);
                    }
                    registrationForm.reset();
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

// ─── ADD TO CALENDAR ───
function addToCalendar(eventId) {
    alert('A calendar invite will be sent to your email after registration.');
}