// ─── BOOKS ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.books__grid-item, ' +
        '.books__author-container, ' +
        '.books__challenge-container'
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
    const pills = document.querySelectorAll('.books__categories-pill');
    const cards = document.querySelectorAll('.books__grid-item');

    if (pills.length > 0 && cards.length > 0) {
        pills.forEach(pill => {
            pill.addEventListener('click', function() {
                pills.forEach(p => p.classList.remove('books__categories-pill--active'));
                this.classList.add('books__categories-pill--active');

                const filter = this.textContent.trim().toLowerCase();
                
                cards.forEach(card => {
                    if (filter === 'all' || filter === '') {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else if (filter === 'free') {
                        if (card.classList.contains('books__grid-item--free')) {
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
                    } else if (filter === 'featured') {
                        const badge = card.querySelector('.books__grid-cover-badge');
                        if (badge && badge.textContent.includes('Featured')) {
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
                    } else {
                        // For 'paperback' and 'digital' - show all for demo
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    }
                });
            });
        });
    }

    // ─── SEARCH FUNCTIONALITY ───
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

    // ─── PROGRESS BAR ANIMATION ───
    const progressBar = document.querySelector('.books__author-books-fill');
    if (progressBar) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    progressBar.style.width = '75%';
                }
            });
        }, { threshold: 0.5 });

        observer.observe(progressBar);
    }

});