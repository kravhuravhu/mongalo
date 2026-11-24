document.addEventListener('DOMContentLoaded', function() {
    // ─── FLOATING GOLD DUST ───
    const dustField = document.getElementById('homeDust');
    if (dustField) {
        for (let i = 0; i < 28; i++) {
            const dust = document.createElement('span');
            const size = Math.random() * 3 + 1.5;
            dust.className = 'home__dust-particle';
            dust.style.width = size + 'px';
            dust.style.height = size + 'px';
            dust.style.left = Math.random() * 100 + '%';
            dust.style.opacity = (Math.random() * 0.6 + 0.2).toFixed(2);
            dust.style.animationDuration = (Math.random() * 14 + 12) + 's';
            dust.style.animationDelay = (-Math.random() * 20) + 's';
            dustField.appendChild(dust);
        }
    }
    // ─── WORD-BY-WORD QUOTE REVEAL ───
    const quote = document.getElementById('homeQuote');
    if (quote) {
        const words = quote.textContent.trim().split(' ');
        quote.innerHTML = words.map(function(word) {
            return '<span class="home__vision-word">' + word + '</span>';
        }).join(' ');
        quote.querySelectorAll('.home__vision-word').forEach(function(el, i) {
            el.style.animationDelay = (1100 + i * 70) + 'ms';
            el.classList.add('is-in');
        });
    }
    // ─── 3D TILT ON CARDS ───
    document.querySelectorAll('.home__card').forEach(function(card) {
        card.addEventListener('animationend', function() {
            card.style.opacity = 1;
            card.classList.remove('home__reveal');
        });
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = 'translateY(-8px) rotateX(' + (-y * 7).toFixed(2) + 'deg) rotateY(' + (x * 7).toFixed(2) + 'deg)';
        });
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
        });
    });
});