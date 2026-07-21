// ─── NAVBAR SCROLL ───
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const body = document.body;
    
    if (navbar) {
        // Initial check
        if (window.scrollY > 30) {
            navbar.classList.add('navbar--scrolled');
        }

        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    if (window.scrollY > 30) {
                        navbar.classList.add('navbar--scrolled');
                    } else {
                        navbar.classList.remove('navbar--scrolled');
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }
});

// ─── NAV TOGGLE ───
function toggleNav() {
    const burger = document.querySelector('.navbar__burger');
    const navLinks = document.querySelector('.navbar__links');
    const navbar = document.querySelector('.navbar');
    const body = document.body;
    const overlay = document.querySelector('.navbar__overlay');

    if (burger && navLinks) {
        const isOpen = navLinks.classList.contains('navbar__links--open');
        
        if (isOpen) {
            closeNav();
        } else {
            burger.classList.add('navbar__burger--open');
            navLinks.classList.add('navbar__links--open');
            if (navbar) navbar.classList.add('navbar--overlay-open');
            body.style.overflow = 'hidden';
            body.style.position = 'fixed';
            body.style.width = '100%';
            body.style.top = `-${window.scrollY}px`;
        }
    }
}

// ─── CLOSE NAV FUNCTION ───
function closeNav() {
    const burger = document.querySelector('.navbar__burger');
    const navLinks = document.querySelector('.navbar__links');
    const navbar = document.querySelector('.navbar');
    const body = document.body;

    if (burger) {
        burger.classList.remove('navbar__burger--open');
    }
    if (navLinks) {
        navLinks.classList.remove('navbar__links--open');
    }
    if (navbar) {
        navbar.classList.remove('navbar--overlay-open');
    }
    
    const scrollY = parseInt(body.style.top || '0') * -1;
    body.style.overflow = '';
    body.style.position = '';
    body.style.width = '';
    body.style.top = '';
    window.scrollTo(0, scrollY);
}

// ─── CLOSE NAV ON OVERLAY CLICK ───
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('.navbar__overlay');
    if (overlay) {
        overlay.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeNav();
        });
    }
});

// ─── CLOSE NAV ON LINK CLICK (Mobile) ───
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelector('.navbar__links');
    if (navLinks) {
        navLinks.querySelectorAll('.navbar__link, .navbar__cta').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 1024) {
                    setTimeout(closeNav, 100);
                }
            });
        });
    }

    // ─── CLOSE NAV ON CLOSE BUTTON ───
    const closeBtn = document.querySelector('.navbar__close');
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            closeNav();
        });
    }

    // ─── CLOSE NAV ON ESC KEY ───
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const navLinks = document.querySelector('.navbar__links');
            if (navLinks && navLinks.classList.contains('navbar__links--open')) {
                closeNav();
            }
        }
    });

    // ─── CLOSE NAV ON RESIZE TO DESKTOP ───
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 1024) {
                const navLinks = document.querySelector('.navbar__links');
                if (navLinks && navLinks.classList.contains('navbar__links--open')) {
                    closeNav();
                }
            }
        }, 200);
    });
});

// ─── WHATSAPP POPUP ───
const COOKIE_NAME = 'whatsapp_popup';
let isPopupMinimized = false;
let autoMinimizeTimer = null;

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
    const minimized = document.getElementById('whatsappPopupMinimized');
    if (popup) {
        popup.classList.add('show');
        popup.classList.remove('whatsapp-popup--minimized');
        isPopupMinimized = false;

        if (autoMinimizeTimer) {
            clearTimeout(autoMinimizeTimer);
        }
        
        autoMinimizeTimer = setTimeout(function() {
            minimizeWhatsAppPopup();
        }, 30000);
    }
    if (minimized) {
        minimized.style.display = 'none';
    }
}

function hideWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    if (popup) {
        popup.classList.remove('show');
        popup.classList.remove('whatsapp-popup--minimized');
    }
    if (autoMinimizeTimer) {
        clearTimeout(autoMinimizeTimer);
    }
}

function minimizeWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    const minimized = document.getElementById('whatsappPopupMinimized');
    if (popup) {
        popup.classList.add('whatsapp-popup--minimized');
        popup.classList.remove('show');
        isPopupMinimized = true;
    }
    if (minimized) {
        minimized.style.display = 'flex';
    }
    if (autoMinimizeTimer) {
        clearTimeout(autoMinimizeTimer);
    }
}

function restoreWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    const minimized = document.getElementById('whatsappPopupMinimized');
    if (popup) {
        popup.classList.remove('whatsapp-popup--minimized');
        popup.classList.add('show');
        isPopupMinimized = false;
        
        // Reset auto-minimize timer
        if (autoMinimizeTimer) {
            clearTimeout(autoMinimizeTimer);
        }
        autoMinimizeTimer = setTimeout(function() {
            minimizeWhatsAppPopup();
        }, 30000);
    }
    if (minimized) {
        minimized.style.display = 'none';
    }
}

function dismissPopup() {
    setCookie(COOKIE_NAME, 'dismissed', 999999);
    hideWhatsAppPopup();
    const minimized = document.getElementById('whatsappPopupMinimized');
    if (minimized) {
        minimized.style.display = 'none';
    }
    if (autoMinimizeTimer) {
        clearTimeout(autoMinimizeTimer);
    }
}

function remindLater() {
    setCookie(COOKIE_NAME, 'remind', 15);
    minimizeWhatsAppPopup();
}

function joinCommunity() {
    setCookie(COOKIE_NAME, 'dismissed', 999999);
    hideWhatsAppPopup();
    const minimized = document.getElementById('whatsappPopupMinimized');
    if (minimized) {
        minimized.style.display = 'none';
    }
    if (autoMinimizeTimer) {
        clearTimeout(autoMinimizeTimer);
    }
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

// ─── BUTTON RIPPLE EFFECT ───
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            const ripple = document.createElement('span');
            ripple.className = 'btn__ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// ─── SCROLL REVEAL OBSERVER ───
document.addEventListener('DOMContentLoaded', function() {
    const revealElements = document.querySelectorAll('.reveal');
    
    if (revealElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = parseInt(entry.target.dataset.delay) || 0;
                    setTimeout(() => {
                        entry.target.classList.add('reveal--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        
        revealElements.forEach(el => observer.observe(el));
    }
});

// ─── PARALLAX ORBS ───
document.addEventListener('DOMContentLoaded', function() {
    const orbs = document.querySelectorAll('.floating-orbs .orb');
    
    if (orbs.length > 0 && window.innerWidth > 768) {
        document.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth - 0.5) * 2;
            const y = (e.clientY / window.innerHeight - 0.5) * 2;
            
            orbs.forEach((orb, index) => {
                const speed = 10 + index * 5;
                const moveX = x * speed;
                const moveY = y * speed;
                orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    }
});