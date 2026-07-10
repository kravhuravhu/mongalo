document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.resources__grid-card, ' +
        '.resources__featured-container, ' +
        '.resources__faq-item'
    );

    if (revealElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // ─── CATEGORY FILTER ───
    const pills = document.querySelectorAll('.resources__categories-pill');
    const cards = document.querySelectorAll('.resources__grid-card');

    if (pills.length > 0 && cards.length > 0) {
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('resources__categories-pill--active'));
                this.classList.add('resources__categories-pill--active');

                const category = this.getAttribute('data-category');

                cards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'flex';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // ─── FAQ ACCORDION ───
    const faqItems = document.querySelectorAll('.resources__faq-item');

    if (faqItems.length > 0) {
        faqItems.forEach(item => {
            const header = item.querySelector('.resources__faq-item-header');
            const answer = item.querySelector('.resources__faq-answer');
            const toggle = item.querySelector('.resources__faq-toggle');

            if (header && answer && toggle) {
                // Open first item by default
                if (item === faqItems[0]) {
                    answer.classList.add('resources__faq-answer--open');
                    toggle.classList.add('resources__faq-toggle--open');
                    toggle.innerHTML = '<i class="fas fa-minus"></i>';
                }

                header.addEventListener('click', function() {
                    const isOpen = answer.classList.contains('resources__faq-answer--open');

                    // Close all
                    faqItems.forEach(otherItem => {
                        const otherAnswer = otherItem.querySelector('.resources__faq-answer');
                        const otherToggle = otherItem.querySelector('.resources__faq-toggle');
                        if (otherAnswer && otherToggle) {
                            otherAnswer.classList.remove('resources__faq-answer--open');
                            otherToggle.classList.remove('resources__faq-toggle--open');
                            otherToggle.innerHTML = '<i class="fas fa-plus"></i>';
                        }
                    });

                    // Toggle current
                    if (!isOpen) {
                        answer.classList.add('resources__faq-answer--open');
                        toggle.classList.add('resources__faq-toggle--open');
                        toggle.innerHTML = '<i class="fas fa-minus"></i>';
                    }
                });
            }
        });
    }

});