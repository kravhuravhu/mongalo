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
let countdownTimer = null;
let countdownSeconds = 30;

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
        
        // ─── START COUNTDOWN ───
        startCountdown();
        
        // ─── AUTO-MINIMIZE AFTER COUNTDOWN ───
        if (autoMinimizeTimer) {
            clearTimeout(autoMinimizeTimer);
        }
        autoMinimizeTimer = setTimeout(function() {
            minimizeWhatsAppPopup();
        }, countdownSeconds * 1000);
    }
    if (minimized) {
        minimized.style.display = 'none';
    }
}

function startCountdown() {
    const countdownEl = document.getElementById('whatsappCountdown');
    const badgeEl = document.getElementById('whatsappMinimizedBadge');
    
    if (!countdownEl) return;
    
    // ─── RESET COUNTDOWN ───
    countdownSeconds = 30;
    countdownEl.textContent = countdownSeconds;
    countdownEl.classList.remove('whatsapp-popup__timer-countdown--warning');
    
    if (badgeEl) {
        badgeEl.textContent = countdownSeconds + 's';
    }
    
    // ─── CLEAR EXISTING TIMER ───
    if (countdownTimer) {
        clearInterval(countdownTimer);
    }
    
    // ─── START COUNTDOWN ───
    countdownTimer = setInterval(function() {
        countdownSeconds--;
        
        if (countdownEl) {
            countdownEl.textContent = countdownSeconds;
            
            // ─── WARNING STATE (last 5 seconds) ───
            if (countdownSeconds <= 5) {
                countdownEl.classList.add('whatsapp-popup__timer-countdown--warning');
            } else {
                countdownEl.classList.remove('whatsapp-popup__timer-countdown--warning');
            }
        }
        
        if (badgeEl) {
            badgeEl.textContent = countdownSeconds + 's';
        }
        
        // ─── WHEN COUNTDOWN REACHES 0 ───
        if (countdownSeconds <= 0) {
            clearInterval(countdownTimer);
            countdownTimer = null;
            
            if (countdownEl) {
                countdownEl.textContent = '0';
            }
            if (badgeEl) {
                badgeEl.textContent = '0s';
            }
            
            // ─── AUTO-MINIMIZE ───
            minimizeWhatsAppPopup();
        }
    }, 1000);
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
    if (countdownTimer) {
        clearInterval(countdownTimer);
        countdownTimer = null;
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
        
        // ─── UPDATE BADGE WITH REMAINING TIME ───
        const badge = document.getElementById('whatsappMinimizedBadge');
        if (badge && countdownSeconds > 0) {
            badge.textContent = countdownSeconds + 's';
        } else if (badge) {
            badge.textContent = '0s';
        }
    }
    if (autoMinimizeTimer) {
        clearTimeout(autoMinimizeTimer);
    }
    if (countdownTimer) {
        clearInterval(countdownTimer);
        countdownTimer = null;
    }
}

function restoreWhatsAppPopup() {
    const popup = document.getElementById('whatsappPopup');
    const minimized = document.getElementById('whatsappPopupMinimized');
    
    if (popup) {
        popup.classList.remove('whatsapp-popup--minimized');
        popup.classList.add('show');
        isPopupMinimized = false;
        
        // ─── RESTART COUNTDOWN ───
        if (!countdownTimer && countdownSeconds > 0) {
            startCountdown();
        }
        
        // ─── RESET AUTO-MINIMIZE TIMER ───
        if (autoMinimizeTimer) {
            clearTimeout(autoMinimizeTimer);
        }
        autoMinimizeTimer = setTimeout(function() {
            minimizeWhatsAppPopup();
        }, countdownSeconds * 1000);
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
    if (countdownTimer) {
        clearInterval(countdownTimer);
        countdownTimer = null;
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
    if (countdownTimer) {
        clearInterval(countdownTimer);
        countdownTimer = null;
    }
}

// ─── SHOW WHATSAPP POPUP ON PAGE LOAD ───
document.addEventListener('DOMContentLoaded', function() {
    const cookie = getCookie(COOKIE_NAME);
    if (!cookie) {
        setTimeout(showWhatsAppPopup, 3000);
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