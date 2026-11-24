// ─── LIBRARY PAGE ───
document.addEventListener('DOMContentLoaded', function() {
    const root = document.querySelector('.library');
    if (!root) return;
    // ─── TABS ───
    const tabs = root.querySelectorAll('.library__tab');
    const panes = root.querySelectorAll('.library__pane');
    function showTab(name) {
        tabs.forEach(function(tab) {
            const active = tab.dataset.tab === name;
            tab.classList.toggle('is-active', active);
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        panes.forEach(function(pane) {
            pane.classList.toggle('is-active', pane.id === 'libraryPane-' + name);
        });
        root.querySelectorAll('.library__title-row').forEach(function(row) {
            row.classList.toggle('is-active', row.dataset.for === name);
        });
    }
    history.replaceState({ tab: root.dataset.activeTab }, '');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            if (tab.classList.contains('is-active')) return;
            showTab(tab.dataset.tab);
            history.pushState({ tab: tab.dataset.tab }, '', tab.dataset.url);
        });
    });
    window.addEventListener('popstate', function(e) {
        showTab((e.state && e.state.tab) || root.dataset.activeTab);
    });
    // ─── FILTERS + LOAD MORE ───
    const cards = Array.from(root.querySelectorAll('.library__res'));
    const chips = root.querySelectorAll('.library__chip');
    const loadWrap = document.getElementById('libraryMore');
    const loadMore = document.getElementById('libraryLoadMore');
    const emptyState = document.getElementById('libraryEmpty');
    let expanded = false;
    let current = root.dataset.category || 'all';
    function render() {
        let shown = 0;
        cards.forEach(function(card) {
            const matchType = current === 'all' || card.dataset.type === current;
            const allowed = expanded || !card.dataset.more || current !== 'all';
            const show = matchType && allowed;
            card.classList.remove('library__reveal');
            card.style.opacity = '';
            if (show) {
                card.classList.remove('is-hidden');
                card.classList.remove('is-pop');
                void card.offsetWidth;
                card.style.animationDelay = (shown * 90) + 'ms';
                card.classList.add('is-pop');
                shown++;
            } else {
                card.classList.add('is-hidden');
            }
        });
        emptyState.classList.toggle('is-hidden', shown > 0);
        loadWrap.classList.toggle('is-hidden', expanded || current !== 'all' || cards.length <= 3);
    }
    chips.forEach(function(chip) {
        chip.addEventListener('click', function() {
            chips.forEach(function(c) { c.classList.remove('is-active'); });
            chip.classList.add('is-active');
            current = chip.dataset.filter;
            render();
        });
    });
    if (loadMore) {
        loadMore.addEventListener('click', function() {
            loadMore.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Loading';
            setTimeout(function() {
                expanded = true;
                render();
            }, 600);
        });
    }
    // ─── FREE RESOURCE LINKS (BOOKS TAB) ───
    root.querySelectorAll('[data-goto-category]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showTab('resources');
            history.pushState({ tab: 'resources' }, '', link.href);
            current = link.dataset.gotoCategory;
            chips.forEach(function(chip) {
                chip.classList.toggle('is-active', chip.dataset.filter === current);
            });
            render();
            root.querySelector('.library__tabs').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    // ─── QUICK DOWNLOAD FEEDBACK ───
    root.querySelectorAll('.library__res-dl').forEach(function(link) {
        link.addEventListener('click', function() {
            const original = link.textContent;
            link.innerHTML = '<i class="fa-solid fa-circle-check"></i> Downloading';
            setTimeout(function() { link.textContent = original; }, 1800);
        });
    });
    // ─── MODAL CONTROLLER ───
    function openModal(modal) {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(modal) {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
    root.querySelectorAll('.library__modal').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal(modal);
        });
        modal.querySelectorAll('[data-modal-close]').forEach(function(btn) {
            btn.addEventListener('click', function() { closeModal(modal); });
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;
        const open = root.querySelector('.library__modal.is-open');
        if (open) closeModal(open);
    });
    // ─── RESOURCE MODAL ───
    const resModal = document.getElementById('libraryResModal');
    const resDl = document.getElementById('libraryResDl');
    const dlBar = document.getElementById('libraryDlBar');
    const dlLabel = document.getElementById('libraryDlLabel');
    function openResource(card) {
        const data = card.dataset;
        const cover = document.getElementById('libraryResCover');
        cover.style.setProperty('background', card.style.getPropertyValue('--res-bg'));
        cover.style.setProperty('color', card.style.getPropertyValue('--res-fg'));
        document.getElementById('libraryResCoverLabel').textContent = data.label || 'Free Resource';
        document.getElementById('libraryResCoverTitle').textContent = data.title;
        document.getElementById('libraryResTitle').textContent = data.title;
        document.getElementById('libraryResSub').textContent = data.sub || '';
        document.getElementById('libraryResDesc').textContent = data.desc || '';
        const format = [data.format, data.size].filter(Boolean).join(' · ');
        document.getElementById('libraryResFormat').textContent = format ? format + ' · Mobile friendly' : 'Mobile friendly';
        const downloads = parseInt(data.downloads, 10) || 0;
        const downloadsRow = document.getElementById('libraryResDownloadsRow');
        downloadsRow.style.display = downloads > 0 ? 'flex' : 'none';
        document.getElementById('libraryResDownloads').textContent = downloads.toLocaleString();
        dlBar.style.width = '0';
        dlLabel.innerHTML = '<i class="fa-solid fa-download"></i> Free Download';
        if (data.downloadUrl) {
            resDl.href = data.downloadUrl;
            resDl.hidden = false;
        } else {
            resDl.hidden = true;
        }
        openModal(resModal);
    }
    root.querySelectorAll('.library__res-open').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openResource(btn.closest('.library__res'));
        });
    });
    resDl.addEventListener('click', function() {
        dlBar.style.width = '100%';
        dlLabel.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Preparing…';
        setTimeout(function() {
            dlLabel.innerHTML = '<i class="fa-solid fa-circle-check"></i> Download started';
        }, 1300);
    });
    // ─── BOOK MODAL ───
    const bookModal = document.getElementById('libraryBookModal');
    const currency = bookModal.dataset.currency || 'R';
    const paymentForm = document.getElementById('paymentForm');
    const detailsView = document.getElementById('libraryBookDetails');
    const checkoutView = document.getElementById('libraryCheckout');
    const bookIdInput = document.getElementById('libraryBookId');
    const deliveryInput = document.getElementById('libraryDeliveryType');
    const editionButtons = bookModal.querySelectorAll('.library__edition');
    const hardEdition = document.getElementById('libraryEditionHard');
    const hardcopyFields = document.getElementById('hardcopyFields');
    const orderSummary = document.getElementById('orderSummary');
    const summaryBookPrice = document.getElementById('summaryBookPrice');
    const summaryShipping = document.getElementById('summaryShipping');
    const summaryTotal = document.getElementById('summaryTotal');
    const summaryDeliveryDays = document.getElementById('summaryDeliveryDays');
    const regionSelect = document.getElementById('delivery_region');
    const submitBtn = document.getElementById('buyNowBtn');
    const btnText = document.getElementById('buyBtnText');
    const btnLoader = document.getElementById('buyBtnLoader');
    const messageDiv = document.getElementById('paymentMessage');
    const book = { price: 0, hardcopyPrice: 0, hasHardcopy: false, priceLabel: '', edition: 'digital' };
    function fmt(n) {
        return currency + ' ' + n.toFixed(2);
    }
    function getShippingFee() {
        if (!regionSelect || !regionSelect.options.length) return 0;
        return parseFloat(regionSelect.options[regionSelect.selectedIndex].getAttribute('data-fee') || '0');
    }
    function getShippingDays() {
        if (!regionSelect || !regionSelect.options.length) return '';
        return regionSelect.options[regionSelect.selectedIndex].getAttribute('data-days') || '';
    }
    function setPayLabel(text) {
        btnText.innerHTML = '<i class="fa-solid fa-lock"></i> Pay ' + text;
    }
    function updateSummary() {
        const isHard = book.edition === 'hard';
        deliveryInput.value = isHard ? 'hardcopy' : 'digital';
        hardcopyFields.hidden = !isHard;
        orderSummary.hidden = !isHard;
        hardcopyFields.querySelectorAll('input, select').forEach(function(el) {
            el.required = isHard && el.dataset.required !== 'false';
        });
        if (isHard) {
            const shipping = getShippingFee();
            const total = book.hardcopyPrice + shipping;
            summaryBookPrice.textContent = fmt(book.hardcopyPrice);
            summaryShipping.textContent = fmt(shipping);
            summaryTotal.textContent = fmt(total);
            summaryDeliveryDays.textContent = getShippingDays();
            setPayLabel(fmt(total));
        } else {
            setPayLabel(book.priceLabel);
        }
    }
    function showStep(step) {
        detailsView.hidden = step !== 'details';
        checkoutView.hidden = step !== 'checkout';
    }
    function selectEdition(button) {
        editionButtons.forEach(function(btn) {
            btn.classList.toggle('is-active', btn === button);
        });
        book.edition = button.dataset.ed;
    }
    editionButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            selectEdition(button);
        });
    });
    if (regionSelect) {
        regionSelect.addEventListener('change', updateSummary);
    }
    document.getElementById('libraryBuyBtn').addEventListener('click', function() {
        updateSummary();
        showStep('checkout');
        setTimeout(function() {
            document.getElementById('buyer_name').focus();
        }, 100);
    });
    document.getElementById('libraryBackStep').addEventListener('click', function() {
        showStep('details');
    });
    function openBook(btn) {
        const data = btn.dataset;
        book.price = parseFloat(data.price) || 0;
        book.hardcopyPrice = parseFloat(data.hardcopyPrice) || 0;
        book.hasHardcopy = data.hardcopy === '1';
        book.priceLabel = data.priceLabel;
        book.edition = 'digital';
        bookIdInput.value = data.bookId;
        document.getElementById('libraryBookTitle').textContent = data.title;
        document.getElementById('libraryBookSub').textContent = data.subtitle || '';
        document.getElementById('libraryBookDesc').textContent = data.desc || '';
        // ─── COVER ───
        const img = document.getElementById('libraryBookImg');
        const fallback = document.getElementById('libraryBookFallback');
        if (data.cover) {
            img.src = data.cover;
            img.alt = data.title + ' book cover';
            img.hidden = false;
            fallback.hidden = true;
        } else {
            img.hidden = true;
            fallback.hidden = false;
            fallback.style.background = data.color;
            document.getElementById('libraryBookFallbackTitle').textContent = data.title;
        }
        // ─── EDITIONS ───
        document.getElementById('libraryPriceDigital').textContent = data.priceLabel;
        document.getElementById('libraryPriceHard').textContent = data.hardcopyLabel + ' + delivery';
        hardEdition.hidden = !book.hasHardcopy;
        selectEdition(editionButtons[0]);
        // ─── RESET STATE ───
        messageDiv.innerHTML = '';
        submitBtn.disabled = false;
        btnText.hidden = false;
        btnLoader.hidden = true;
        paymentForm.querySelectorAll('input').forEach(function(el) {
            el.style.borderColor = '';
        });
        updateSummary();
        showStep('details');
        openModal(bookModal);
    }
    root.querySelectorAll('.library__book-open').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openBook(btn);
        });
    });
    // ─── PAYMENT FORM SUBMIT ───
    function showError(message) {
        messageDiv.innerHTML = '<div class="library__message-error"><i class="fa-solid fa-circle-exclamation"></i> ' + message + '</div>';
    }
    function resetSubmit() {
        if (typeof window.hideAppOverlay === 'function') {
            window.hideAppOverlay();
        }
        submitBtn.disabled = false;
        btnText.hidden = false;
        btnLoader.hidden = true;
    }
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (typeof window.showAppOverlay === 'function') {
            window.showAppOverlay();
        }
        submitBtn.disabled = true;
        btnText.hidden = true;
        btnLoader.hidden = false;
        messageDiv.innerHTML = '';
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(this)
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                window.location.href = data.redirect_url;
                return;
            }
            resetSubmit();
            if (data.field === 'phone' || data.field === 'email') {
                const input = document.getElementById('buyer_' + data.field);
                if (input) {
                    input.style.borderColor = '#dc3545';
                    input.focus();
                    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            showError(data.message || 'Something went wrong. Please try again.');
        })
        .catch(function(error) {
            console.error('Error:', error);
            resetSubmit();
            showError('Payment initiation failed. Please try again.');
        });
    });
    // ─── OPEN FROM ?open=SLUG (OLD DETAIL PAGE LINKS) ───
    const openSlug = new URLSearchParams(window.location.search).get('open');
    if (openSlug) {
        const target = Array.from(root.querySelectorAll('[data-slug]')).find(function(el) {
            return el.dataset.slug === openSlug;
        });
        if (target) {
            const trigger = target.querySelector('.library__res-open, .library__book-open');
            if (trigger) {
                const pane = target.closest('.library__pane');
                if (pane) showTab(pane.id.replace('libraryPane-', ''));
                trigger.click();
            }
        }
    }
    // ─── REVEAL CLEANUP ───
    root.querySelectorAll('.library__reveal').forEach(function(el) {
        el.addEventListener('animationend', function(ev) {
            if (ev.animationName === 'libraryFadeUp') {
                el.style.opacity = 1;
                el.classList.remove('library__reveal');
            }
        });
    });
    cards.forEach(function(card) {
        card.addEventListener('animationend', function(ev) {
            if (ev.animationName === 'libraryPopIn') card.classList.remove('is-pop');
        });
    });
});