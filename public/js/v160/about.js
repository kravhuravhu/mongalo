// ─── ABOUT PAGE ───
document.addEventListener('DOMContentLoaded', function() {
    // ─── TABS ───
    const tabs = document.querySelectorAll('.about__tab');
    const panes = document.querySelectorAll('.about__pane');

    function activateTab(tab) {
        const target = document.getElementById('aboutPane-' + tab.dataset.tab);
        
        if (!target) return;
        panes.forEach(function(pane) {
            pane.classList.remove('is-active');
        });

        tabs.forEach(function(btn) {
            btn.classList.remove('is-active');
            btn.setAttribute('aria-selected', 'false');
        });

        target.classList.add('is-active');
        tab.classList.add('is-active');
        tab.setAttribute('aria-selected', 'true');
    }

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            activateTab(tab);
        });
    });
});