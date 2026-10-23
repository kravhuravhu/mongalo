document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO PARTICLES ───
    const particlesContainer = document.getElementById('heroParticles');

    if (particlesContainer) {
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 3 + 1.5;

            particle.style.position = 'absolute';
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.background = 'rgba(184, 146, 106, 0.5)';
            particle.style.borderRadius = '50%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animation = 'particleFloat ' + (Math.random() * 20 + 15) + 's ease-in-out infinite';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particle.style.pointerEvents = 'none';

            particlesContainer.appendChild(particle);
        }
    }

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.home__vision-content, .home__pillars-grid, .home__pillars-strip, .home__arthur-content'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.9s cubic-bezier(0.34, 1.56, 0.64, 1)';
            observer.observe(el);
        });
    }

    // ─── MOBILE PILLARS ACCORDION ───
    // Vertical accordion, active only on mobile (≤ 564px).
    // On desktop, the accordion is hidden via CSS and the strip + grid show instead.
    const MOBILE_BREAKPOINT = 564;

    const accordionItems = document.querySelectorAll('.home__pillars-accordion-item');

    let activeIndex = null;

    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    function setPanelHeight(item, open) {
        const panel = item.querySelector('.home__pillars-accordion-panel');
        if (!panel) return;

        if (open) {
            panel.style.maxHeight = panel.scrollHeight + 'px';
        } else {
            panel.style.maxHeight = '0px';
        }
    }

    function openItem(index) {
        accordionItems.forEach(function(item, i) {
            const trigger = item.querySelector('.home__pillars-accordion-trigger');
            if (i === index) {
                item.classList.add('is-open');
                if (trigger) trigger.setAttribute('aria-expanded', 'true');
                setPanelHeight(item, true);
            } else {
                item.classList.remove('is-open');
                if (trigger) trigger.setAttribute('aria-expanded', 'false');
                setPanelHeight(item, false);
            }
        });
        activeIndex = index;
    }

    function closeAll() {
        accordionItems.forEach(function(item) {
            const trigger = item.querySelector('.home__pillars-accordion-trigger');
            item.classList.remove('is-open');
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
            setPanelHeight(item, false);
        });
        activeIndex = null;
    }

    function toggleItem(index) {
        if (activeIndex === index) {
            // Tapping the open item closes it
            closeAll();
        } else {
            openItem(index);
        }
    }

    // Wire up triggers
    accordionItems.forEach(function(item, i) {
        const trigger = item.querySelector('.home__pillars-accordion-trigger');
        if (!trigger) return;

        trigger.addEventListener('click', function() {
            if (!isMobile()) return;
            toggleItem(i);
        });
    });

    // Set initial state: open the first one on mobile, closed otherwise
    function syncInitialState() {
        if (isMobile()) {
            openItem(0);
        } else {
            closeAll();
        }
    }

    syncInitialState();

    // Recalculate heights on resize + reset on breakpoint cross
    window.addEventListener('resize', function() {
        if (isMobile()) {
            if (activeIndex !== null) {
                const active = accordionItems[activeIndex];
                if (active && active.classList.contains('is-open')) {
                    setPanelHeight(active, true);
                }
            }
        } else {
            // Leaving mobile — reset everything so desktop is clean
            closeAll();
        }
    });

    // Keyboard navigation between triggers
    const triggers = Array.from(document.querySelectorAll('.home__pillars-accordion-trigger'));
    triggers.forEach(function(trigger, i) {
        trigger.addEventListener('keydown', function(e) {
            if (!isMobile()) return;

            let targetIndex = null;
            if (e.key === 'ArrowDown') {
                targetIndex = (i + 1) % triggers.length;
            } else if (e.key === 'ArrowUp') {
                targetIndex = (i - 1 + triggers.length) % triggers.length;
            } else if (e.key === 'Home') {
                targetIndex = 0;
            } else if (e.key === 'End') {
                targetIndex = triggers.length - 1;
            }

            if (targetIndex !== null) {
                e.preventDefault();
                triggers[targetIndex].focus();
            }
        });
    });
});