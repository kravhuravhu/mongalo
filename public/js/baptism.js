// ─── BAPTISM ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.baptism__info-card, ' +
        '.baptism__scripture-card, ' +
        '.baptism__steps-card, ' +
        '.baptism__story-container, ' +
        '.baptism__faq-item'
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

    // ─── FAQ ACCORDION ───
    const faqItems = document.querySelectorAll('.baptism__faq-item');

    if (faqItems.length > 0) {
        faqItems.forEach(item => {
            const header = item.querySelector('.baptism__faq-item-header');
            const answer = item.querySelector('.baptism__faq-answer');
            const toggle = item.querySelector('.baptism__faq-toggle');

            if (header && answer && toggle) {
                // Open first item by default
                if (item === faqItems[0]) {
                    answer.classList.add('baptism__faq-answer--open');
                    toggle.classList.add('baptism__faq-toggle--open');
                    toggle.innerHTML = '<i class="fas fa-minus"></i>';
                }

                header.addEventListener('click', function() {
                    const isOpen = answer.classList.contains('baptism__faq-answer--open');

                    // Close all
                    faqItems.forEach(otherItem => {
                        const otherAnswer = otherItem.querySelector('.baptism__faq-answer');
                        const otherToggle = otherItem.querySelector('.baptism__faq-toggle');
                        if (otherAnswer && otherToggle) {
                            otherAnswer.classList.remove('baptism__faq-answer--open');
                            otherToggle.classList.remove('baptism__faq-toggle--open');
                            otherToggle.innerHTML = '<i class="fas fa-plus"></i>';
                        }
                    });

                    // Toggle current
                    if (!isOpen) {
                        answer.classList.add('baptism__faq-answer--open');
                        toggle.classList.add('baptism__faq-toggle--open');
                        toggle.innerHTML = '<i class="fas fa-minus"></i>';
                    }
                });
            }
        });
    }

});