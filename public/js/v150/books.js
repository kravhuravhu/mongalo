// ─── BOOKS PAGE ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── MODAL CONTROLLER (REUSABLE) ───
    // ─── OPENS ON [data-modal-open="ID"] AND CLOSES ON [data-modal-close] OR ESC ───
    const modalTriggers = document.querySelectorAll('[data-modal-open]');

    modalTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-open');
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.classList.add('book-detail__modal--open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('book-detail__modal-open');

            // ─── FOCUS FIRST INPUT ───
            const firstInput = modal.querySelector('input:not([type="hidden"]):not([type="radio"]), select, textarea');
            if (firstInput) {
                setTimeout(function() { firstInput.focus(); }, 120);
            }
        });
    });

    // ─── CLOSE ON [data-modal-close] ───
    document.querySelectorAll('[data-modal-close]').forEach(function(el) {
        el.addEventListener('click', function() {
            const modal = this.closest('.book-detail__modal');
            if (!modal) return;

            modal.classList.remove('book-detail__modal--open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('book-detail__modal-open');
        });
    });

    // ─── CLOSE ON ESC ───
    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;

        const openModal = document.querySelector('.book-detail__modal.book-detail__modal--open');
        if (!openModal) return;

        openModal.classList.remove('book-detail__modal--open');
        openModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('book-detail__modal-open');
    });

    // ─── SCROLL REVEAL ───
    const revealElements = document.querySelectorAll(
        '.books__featured-grid, .books__secondary-card, .books__free-strip-content, .books__community-content'
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
            threshold: 0.1,
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
        const covers = document.querySelectorAll('.books__featured-cover-book');

        covers.forEach(function(cover) {
            cover.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                const rotateY = x * 20;
                const rotateX = -y * 15;

                this.style.transform = 'perspective(1000px) rotateY(' + rotateY + 'deg) rotateX(' + rotateX + 'deg) translateY(-10px)';
            });

            cover.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }
});

// ─── BOOK DETAIL — BUY MODAL SPINNER WIRING ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── CURRENCY SYMBOL (READ FROM SETTINGS) ───
    const currency = window.__BUY_MODAL_CURRENCY__ || 'R';

    // ─── PAYMENT FORM SUBMIT ───
    const paymentForm = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('buyNowBtn');
    const btnText = document.getElementById('buyBtnText');
    const btnLoader = document.getElementById('buyBtnLoader');
    const messageDiv = document.getElementById('paymentMessage');

    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // ─── SHOW CUSTOM PAGE SPINNER (app.js overlay) ───
            if (typeof window.showAppOverlay === 'function') {
                window.showAppOverlay();
            }

            submitBtn.disabled = true;
            if (btnText) btnText.style.display = 'none';
            if (btnLoader) btnLoader.style.display = 'inline';
            if (messageDiv) messageDiv.innerHTML = '';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                    return;
                }

                // ─── HIDE CUSTOM PAGE SPINNER ON ERROR ───
                if (typeof window.hideAppOverlay === 'function') {
                    window.hideAppOverlay();
                }

                let errorMessage = data.message || 'Something went wrong. Please try again.';

                if (data.field === 'phone') {
                    const phoneInput = document.getElementById('buyer_phone');
                    if (phoneInput) {
                        phoneInput.style.borderColor = '#dc3545';
                        phoneInput.focus();
                        phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                if (data.field === 'email') {
                    const emailInput = document.getElementById('buyer_email');
                    if (emailInput) {
                        emailInput.style.borderColor = '#dc3545';
                        emailInput.focus();
                        emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                if (messageDiv) {
                    messageDiv.innerHTML = `
                        <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-circle"></i>
                            ${errorMessage}
                        </div>
                    `;
                }

                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoader) btnLoader.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);

                // ─── HIDE CUSTOM PAGE SPINNER ON ERROR ───
                if (typeof window.hideAppOverlay === 'function') {
                    window.hideAppOverlay();
                }

                if (messageDiv) {
                    messageDiv.innerHTML = `
                        <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-circle"></i>
                            Payment initiation failed. Please try again.
                        </div>
                    `;
                }
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoader) btnLoader.style.display = 'none';
            });
        });
    }

    // ─── DELIVERY TYPE TOGGLE + PRICE SUMMARY ───
    const digitalPrice = window.__BUY_MODAL_DIGITAL_PRICE__ || 0;
    const hardcopyPrice = window.__BUY_MODAL_HARDCOPY_PRICE__ || 0;
    const hasHardcopy = window.__BUY_MODAL_HAS_HARDCOPY__ === true;

    if (hasHardcopy) {
        const deliveryRadios = document.querySelectorAll('input[name="delivery_type"]');
        const hardcopyFields = document.getElementById('hardcopyFields');
        const summaryBookPrice = document.getElementById('summaryBookPrice');
        const summaryShippingRow = document.getElementById('summaryShippingRow');
        const summaryShipping = document.getElementById('summaryShipping');
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryDeliveryNote = document.getElementById('summaryDeliveryNote');
        const summaryDeliveryDays = document.getElementById('summaryDeliveryDays');
        const buyBtnText = document.getElementById('buyBtnText');
        const regionSelect = document.getElementById('delivery_region');

        function fmt(n) {
            return currency + ' ' + n.toFixed(2);
        }

        function getShippingFee() {
            if (!regionSelect) return 0;
            const opt = regionSelect.options[regionSelect.selectedIndex];
            return parseFloat(opt.getAttribute('data-fee') || '0');
        }

        function getShippingDays() {
            if (!regionSelect) return '';
            const opt = regionSelect.options[regionSelect.selectedIndex];
            return opt.getAttribute('data-days') || '';
        }

        function updateSummary() {
            const selected = document.querySelector('input[name="delivery_type"]:checked');
            const isHard = selected && selected.value === 'hardcopy';

            document.querySelectorAll('.book-detail__delivery-option').forEach(function (label) {
                const input = label.querySelector('input');
                label.classList.toggle('book-detail__delivery-option--active', input.checked);
            });

            if (hardcopyFields) {
                hardcopyFields.style.display = isHard ? 'block' : 'none';
                hardcopyFields.querySelectorAll('input, select').forEach(function (el) {
                    el.required = isHard && el.dataset.required !== 'false';
                });
            }

            if (isHard) {
                const shipping = getShippingFee();
                const bookPrice = hardcopyPrice;
                const total = bookPrice + shipping;

                summaryBookPrice.textContent = fmt(bookPrice);
                summaryShippingRow.style.display = 'flex';
                summaryShipping.textContent = fmt(shipping);
                summaryTotal.textContent = fmt(total);
                summaryDeliveryNote.style.display = 'flex';
                summaryDeliveryDays.textContent = getShippingDays();
                buyBtnText.innerHTML = '<i class="fas fa-lock"></i> Pay ' + fmt(total);
            } else {
                summaryBookPrice.textContent = fmt(digitalPrice);
                summaryShippingRow.style.display = 'none';
                summaryTotal.textContent = fmt(digitalPrice);
                summaryDeliveryNote.style.display = 'none';
                buyBtnText.innerHTML = '<i class="fas fa-lock"></i> Pay ' + fmt(digitalPrice);
            }
        }

        deliveryRadios.forEach(function (radio) {
            radio.addEventListener('change', updateSummary);
        });

        if (regionSelect) {
            regionSelect.addEventListener('change', updateSummary);
        }

        updateSummary();
    }
});