document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.resources__filters, .resources__grid, .resources__how-grid, .resources__books-cta-content, .resources__community-content'
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

    // ─── BOOK COVER 3D TILT (desktop only) ───
    if (window.innerWidth > 768) {
        const covers = document.querySelectorAll('.resource-detail__cover-book');

        covers.forEach(function(cover) {
            cover.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                const rotateY = x * 15;
                const rotateX = -y * 12;

                this.style.transform = 'perspective(1000px) rotateY(' + rotateY + 'deg) rotateX(' + rotateX + 'deg) translateY(-10px)';
            });

            cover.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }
});