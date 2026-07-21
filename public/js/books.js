document.addEventListener('DOMContentLoaded', function() {
    // ─── BOOKS ORBS PARALLAX ───
    const booksOrbs = document.querySelectorAll('.books__orb');
    if (booksOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                booksOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR AUTHOR CARD ───
    const authorCard = document.querySelector('.books__author-visual');
    if (authorCard) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('books__author-visual--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(authorCard);
    }

    // ─── SCROLL REVEAL FOR SPOTLIGHT ───
    const spotlightCover = document.querySelector('.books__spotlight-cover');
    const spotlightContent = document.querySelector('.books__spotlight-content');
    
    if (spotlightCover && spotlightContent) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    spotlightCover.classList.add('books__spotlight-cover--visible');
                    spotlightContent.classList.add('books__spotlight-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(spotlightCover);
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.books__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('books__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── CATEGORY FILTER ───
    const pills = document.querySelectorAll('.books__filters-pill');
    const cards = document.querySelectorAll('.books__grid-item');

    if (pills.length > 0 && cards.length > 0) {
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('books__filters-pill--active'));
                this.classList.add('books__filters-pill--active');

                const filter = this.dataset.filter;

                cards.forEach((card, index) => {
                    if (filter === 'all' || card.dataset.category === filter) {
                        card.style.display = 'block';
                        card.style.animation = 'none';
                        // Force reflow
                        void card.offsetHeight;
                        card.style.animation = `booksGridFade 0.6s ease forwards`;
                        card.style.animationDelay = `${index * 0.05}s`;
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // ─── SEARCH ───
    const searchInput = document.querySelector('.books__hero-search-input');
    const searchBtn = document.querySelector('.books__hero-search-btn');

    if (searchInput && searchBtn) {
        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            cards.forEach((card, index) => {
                const title = card.querySelector('.books__grid-name')?.textContent?.toLowerCase() || '';
                const desc = card.querySelector('.books__grid-desc')?.textContent?.toLowerCase() || '';

                if (title.includes(query) || desc.includes(query) || query === '') {
                    card.style.display = 'block';
                    card.style.animation = 'none';
                    void card.offsetHeight;
                    card.style.animation = `booksGridFade 0.6s ease forwards`;
                    card.style.animationDelay = `${index * 0.05}s`;
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.books__hero-badge');
    if (heroBadge) {
        heroBadge.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(15deg) scale(1.2)';
            }
        });
        heroBadge.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(0deg) scale(1)';
            }
        });
    }

    // ─── HERO SHAPES PARALLAX ───
    const heroShapes = document.querySelectorAll('.books__hero-shape');
    if (heroShapes.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                heroShapes.forEach((shape, index) => {
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    shape.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }

    // ─── SHELF BOOKS HOVER PARALLAX ───
    const shelfBooks = document.querySelectorAll('.books__hero-shelf-book');
    if (shelfBooks.length > 0 && window.innerWidth > 768) {
        shelfBooks.forEach((book, index) => {
            book.addEventListener('mouseenter', function() {
                this.style.animationPlayState = 'paused';
            });
            book.addEventListener('mouseleave', function() {
                this.style.animationPlayState = 'running';
            });
        });
    }
});