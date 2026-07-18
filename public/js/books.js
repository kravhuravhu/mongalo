document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.books__grid-item, ' +
        '.books__author-grid, ' +
        '.books__spotlight-grid'
    );

    if (revealElements.length > 0) {
        revealElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = `opacity 0.6s ease ${index * 0.08}s, transform 0.6s ease ${index * 0.08}s`;
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                } else {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(40px)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });

        revealElements.forEach(el => observer.observe(el));
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

                cards.forEach(card => {
                    if (filter === 'all' || card.dataset.category === filter) {
                        card.style.display = 'block';
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

    // ─── SEARCH ───
    const searchInput = document.querySelector('.books__hero-search-input');
    const searchBtn = document.querySelector('.books__hero-search-btn');

    if (searchInput && searchBtn) {
        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            cards.forEach(card => {
                const title = card.querySelector('.books__grid-name')?.textContent?.toLowerCase() || '';
                const desc = card.querySelector('.books__grid-desc')?.textContent?.toLowerCase() || '';

                if (title.includes(query) || desc.includes(query) || query === '') {
                    card.style.display = 'block';
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
        }

        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

});