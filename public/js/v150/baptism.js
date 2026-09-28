document.addEventListener('DOMContentLoaded', function() {

    // ─── HERO WATER CANVAS ───
    const canvas = document.getElementById('baptismHeroCanvas');

    if (canvas) {
        const ctx = canvas.getContext('2d');
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;

        // ─── RESIZE ───
        function resizeCanvas() {
            width = canvas.width = canvas.offsetWidth;
            height = canvas.height = canvas.offsetHeight;
        }

        window.addEventListener('resize', resizeCanvas);

        // ─── PARTICLES ───
        const particles = [];
        const particleCount = 60;

        function randomBetween(min, max) {
            return Math.random() * (max - min) + min;
        }

        // ─── CREATE PARTICLES ───
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: randomBetween(0, width),
                y: randomBetween(0, height),
                radius: randomBetween(1, 3.5),
                speed: randomBetween(0.2, 0.8),
                drift: randomBetween(-0.3, 0.3),
                opacity: randomBetween(0.2, 0.6),
                wobble: randomBetween(0, Math.PI * 2),
                wobbleSpeed: randomBetween(0.01, 0.03),
            });
        }

        // ─── ANIMATE ───
        function animate() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(function(p) {
                // ─── UPDATE ───
                p.y -= p.speed;
                p.wobble += p.wobbleSpeed;
                p.x += Math.sin(p.wobble) * 0.3 + p.drift;

                // ─── RESET WHEN OFF TOP ───
                if (p.y < -10) {
                    p.y = height + 10;
                    p.x = randomBetween(0, width);
                }

                // ─── WRAP AROUND SIDES ───
                if (p.x < -10) p.x = width + 10;
                if (p.x > width + 10) p.x = -10;

                // ─── DRAW ───
                const gradient = ctx.createRadialGradient(
                    p.x, p.y, 0,
                    p.x, p.y, p.radius * 2
                );

                gradient.addColorStop(0, 'rgba(200, 235, 245, ' + p.opacity + ')');
                gradient.addColorStop(0.5, 'rgba(124, 197, 217, ' + (p.opacity * 0.5) + ')');
                gradient.addColorStop(1, 'rgba(124, 197, 217, 0)');

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius * 2, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();
            });

            requestAnimationFrame(animate);
        }

        animate();
    }

    // ─── FAQ TOGGLE ───
    window.toggleBaptismFaq = function(button) {
        const item = button.closest('.baptism__faq-item');
        const answer = item.querySelector('.baptism__faq-answer');
        const icon = item.querySelector('.baptism__faq-question-icon i');
        const isOpen = item.classList.contains('baptism__faq-item--open');

        // ─── CLOSE ALL ───
        document.querySelectorAll('.baptism__faq-item').forEach(function(otherItem) {
            otherItem.classList.remove('baptism__faq-item--open');
            const otherAnswer = otherItem.querySelector('.baptism__faq-answer');
            const otherIcon = otherItem.querySelector('.baptism__faq-question-icon i');
            if (otherAnswer) otherAnswer.style.display = 'none';
            if (otherIcon) otherIcon.className = 'fas fa-plus';
        });

        // ─── OPEN CURRENT IF IT WAS CLOSED ───
        if (!isOpen) {
            item.classList.add('baptism__faq-item--open');
            if (answer) answer.style.display = 'block';
            if (icon) icon.className = 'fas fa-minus';
        }
    };

    // ─── SCROLL REVEAL (GENERIC) ───
    const revealElements = document.querySelectorAll(
        '.baptism__two-grid, .baptism__meaning-grid, .baptism__steps-grid, .baptism__contact-grid, .baptism__faq-list, .baptism__community-content'
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
            threshold: 0.05,
            rootMargin: '0px 0px -60px 0px'
        });

        revealElements.forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity 1s cubic-bezier(0.34, 1.56, 0.64, 1), transform 1s cubic-bezier(0.34, 1.56, 0.64, 1)';
            observer.observe(el);
        });
    }

    // ─── SCRIPTURES FLIP CAROUSEL ───
    const scripturesGrid = document.querySelector('.baptism__scriptures-grid');
    const scripturesCards = scripturesGrid ? scripturesGrid.querySelectorAll('.baptism__scriptures-card') : [];

    if (scripturesGrid && scripturesCards.length > 0) {
        let currentIndex = 0;
        let carouselInterval = null;
        let carouselStarted = false;
        let isAnimating = false;
        const CYCLE_TIME = 5500;
        const FLIP_DURATION = 1100;

        // ─── INJECT CONTROLS ───
        const controls = document.createElement('div');
        controls.className = 'baptism__scriptures-controls';

        let controlsHTML = '<button type="button" class="baptism__scriptures-arrow baptism__scriptures-arrow--prev" aria-label="Previous scripture">';
        controlsHTML += '<i class="fas fa-chevron-left"></i>';
        controlsHTML += '</button>';

        controlsHTML += '<div class="baptism__scriptures-dots">';
        scripturesCards.forEach(function(_, i) {
            controlsHTML += '<button type="button" class="baptism__scriptures-dot' + (i === 0 ? ' is-active' : '') + '" data-index="' + i + '" aria-label="Go to scripture ' + (i + 1) + '"></button>';
        });
        controlsHTML += '</div>';

        controlsHTML += '<button type="button" class="baptism__scriptures-arrow baptism__scriptures-arrow--next" aria-label="Next scripture">';
        controlsHTML += '<i class="fas fa-chevron-right"></i>';
        controlsHTML += '</button>';

        controls.innerHTML = controlsHTML;

        // ─── INSERT CONTROLS AFTER GRID ───
        scripturesGrid.parentNode.insertBefore(controls, scripturesGrid.nextSibling);

        const dots = controls.querySelectorAll('.baptism__scriptures-dot');
        const prevBtn = controls.querySelector('.baptism__scriptures-arrow--prev');
        const nextBtn = controls.querySelector('.baptism__scriptures-arrow--next');

        // ─── UPDATE DOTS ───
        function updateDots() {
            dots.forEach(function(dot, i) {
                dot.classList.toggle('is-active', i === currentIndex);
            });
        }

        // ─── SHOW CARD BY INDEX ───
        function showCard(index, direction) {
            scripturesCards.forEach(function(card, i) {
                card.classList.remove('is-active', 'is-leaving', 'is-entering');
                if (i === index) {
                    card.classList.add(direction === 'back' ? 'is-entering-back' : 'is-entering');
                }
            });

            // ─── FORCE REFLOW SO THE TRANSITION RUNS ───
            void scripturesCards[index].offsetWidth;

            scripturesCards[index].classList.remove('is-entering', 'is-entering-back');
            scripturesCards[index].classList.add('is-active');

            currentIndex = index;
            updateDots();
        }

        // ─── NEXT ───
        function nextCard() {
            if (isAnimating) return;
            isAnimating = true;

            const nextIndex = (currentIndex + 1) % scripturesCards.length;
            const currentCard = scripturesCards[currentIndex];

            currentCard.classList.remove('is-active');
            currentCard.classList.add('is-leaving');

            showCard(nextIndex, 'forward');

            setTimeout(function() {
                currentCard.classList.remove('is-leaving');
                isAnimating = false;
            }, FLIP_DURATION);
        }

        // ─── PREV ───
        function prevCard() {
            if (isAnimating) return;
            isAnimating = true;

            const prevIndex = (currentIndex - 1 + scripturesCards.length) % scripturesCards.length;
            const currentCard = scripturesCards[currentIndex];

            currentCard.classList.remove('is-active');
            currentCard.classList.add('is-leaving-back');

            showCard(prevIndex, 'back');

            setTimeout(function() {
                currentCard.classList.remove('is-leaving-back');
                isAnimating = false;
            }, FLIP_DURATION);
        }

        // ─── GO TO SPECIFIC ───
        function goToCard(index) {
            if (index === currentIndex) return;
            if (isAnimating) return;

            const direction = index > currentIndex ? 'forward' : 'back';
            isAnimating = true;

            const currentCard = scripturesCards[currentIndex];
            currentCard.classList.remove('is-active');
            currentCard.classList.add(direction === 'back' ? 'is-leaving-back' : 'is-leaving');

            showCard(index, direction);

            setTimeout(function() {
                currentCard.classList.remove('is-leaving', 'is-leaving-back');
                isAnimating = false;
            }, FLIP_DURATION);
        }

        // ─── START CAROUSEL ───
        function startCarousel() {
            if (carouselStarted) return;
            carouselStarted = true;

            showCard(0, 'forward');

            carouselInterval = setInterval(nextCard, CYCLE_TIME);
        }

        // ─── PAUSE / RESUME ───
        function pauseCarousel() {
            if (carouselInterval) {
                clearInterval(carouselInterval);
                carouselInterval = null;
            }
        }

        function resumeCarousel() {
            if (carouselStarted && !carouselInterval) {
                carouselInterval = setInterval(nextCard, CYCLE_TIME);
            }
        }

        // ─── CONTROLS: ARROWS ───
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                pauseCarousel();
                prevCard();
                resumeCarousel();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                pauseCarousel();
                nextCard();
                resumeCarousel();
            });
        }

        // ─── CONTROLS: DOTS ───
        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                const index = parseInt(this.dataset.index, 10);
                pauseCarousel();
                goToCard(index);
                resumeCarousel();
            });
        });

        // ─── OBSERVER — START WHEN IN VIEW ───
        const flipObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    startCarousel();
                } else {
                    pauseCarousel();
                }
            });
        }, {
            threshold: 0.15
        });

        flipObserver.observe(scripturesGrid);

        // ─── PAUSE ON HOVER ───
        scripturesGrid.addEventListener('mouseenter', pauseCarousel);
        scripturesGrid.addEventListener('mouseleave', resumeCarousel);
    }
});