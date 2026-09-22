document.addEventListener('DOMContentLoaded', function() {

    /* ─── OVERLAY LOADER ─── */
    const overlayHTML = `
        <div class="admin-overlay" id="adminOverlay">
            <div class="admin-overlay__spinner">
                <div class="admin-overlay__ring admin-overlay__ring--1"></div>
                <div class="admin-overlay__ring admin-overlay__ring--2"></div>
                <div class="admin-overlay__ring admin-overlay__ring--3"></div>
                <span class="admin-overlay__text">Loading...</span>
            </div>
        </div>
    `;

    // Inject overlay into body (hidden by default)
    if (!document.getElementById('adminOverlay')) {
        document.body.insertAdjacentHTML('beforeend', overlayHTML);
    }

    const overlay = document.getElementById('adminOverlay');

    function showOverlay() {
        if (overlay) {
            overlay.classList.add('admin-overlay--visible');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideOverlay() {
        if (overlay) {
            overlay.classList.remove('admin-overlay--visible');
            document.body.style.overflow = '';
        }
    }

    // Expose globally
    window.showAdminOverlay = showOverlay;
    window.hideAdminOverlay = hideOverlay;

    /* ─── INITIAL PAGE LOAD OVERLAY ─── */
    // The layout has `adminWrapper` with `display: none; opacity: 0;`.
    // We show overlay right away, then fade it out once the page is ready.
    showOverlay();

    window.addEventListener('load', function() {
        // Small delay so the fade-out feels intentional
        setTimeout(function() {
            hideOverlay();
        }, 200);
    });

    // Safety — if `load` never fires (some browsers), force hide after 3s
    setTimeout(function() {
        if (overlay && overlay.classList.contains('admin-overlay--visible')) {
            hideOverlay();
        }
    }, 3000);

    // If user comes back via bfcache (browser back button), hide overlay
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) hideOverlay();
    });

    /* ─── FLASH MESSAGES ─── */
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function(msg) {
        setTimeout(function() {
            msg.classList.add('flash-message--fade-out');
            setTimeout(function() {
                msg.remove();
            }, 400);
        }, 5000);
    });

    /* ─── CUSTOM CONFIRMATION MODAL ─── */
    document.querySelectorAll('.delete-confirm').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = this.querySelector('button[type="submit"]');
            const itemName = btn.getAttribute('data-title') || 'this item';
            const itemType = btn.getAttribute('data-type') || 'item';

            const isMarkPaid = this.querySelector('input[name="status"]')?.value === 'paid';
            const actionLabel = isMarkPaid ? 'Mark as Paid' : 'Delete';
            const actionIcon = isMarkPaid ? 'fa-check-circle' : 'fa-trash-alt';
            const actionColor = isMarkPaid ? '#28A745' : '#DC3545';
            const confirmText = isMarkPaid
                ? `Are you sure you want to mark <strong>${itemName}</strong> as PAID? This confirms payment and cannot be undone.`
                : `Are you sure you want to delete <strong>${itemName}</strong>?<br><span class="delete-modal__warning">This action cannot be undone.</span>`;

            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'delete-modal-overlay';
            modalOverlay.innerHTML = `
                <div class="delete-modal">
                    <div class="delete-modal__icon" style="background: ${isMarkPaid ? '#D4EDDA' : '#F8D7DA'};">
                        <i class="fas ${actionIcon}" style="color: ${actionColor};"></i>
                    </div>
                    <h3 class="delete-modal__title">${actionLabel} ${itemType}</h3>
                    <p class="delete-modal__text">${confirmText}</p>
                    <div class="delete-modal__actions">
                        <button class="btn btn--secondary delete-modal__cancel">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button class="btn ${isMarkPaid ? 'btn--success' : 'btn--danger'} delete-modal__confirm">
                            <i class="fas ${actionIcon}"></i> ${isMarkPaid ? 'Yes, Mark Paid' : 'Yes, Delete'}
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(modalOverlay);
            modalOverlay._originalForm = this;

            requestAnimationFrame(function() {
                modalOverlay.classList.add('delete-modal-overlay--visible');
                const modal = modalOverlay.querySelector('.delete-modal');
                if (modal) modal.classList.add('delete-modal--visible');
            });

            modalOverlay.querySelector('.delete-modal__cancel').addEventListener('click', function() {
                closeDeleteModal(modalOverlay);
            });

            modalOverlay.querySelector('.delete-modal__confirm').addEventListener('click', function() {
                const confirmBtn = this;
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                showOverlay();
                modalOverlay._originalForm.submit();
            });

            modalOverlay.addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal(this);
            });

            function handleEsc(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal(modalOverlay);
                    document.removeEventListener('keydown', handleEsc);
                }
            }
            document.addEventListener('keydown', handleEsc);
        });
    });

    function closeDeleteModal(modalOverlay) {
        modalOverlay.classList.remove('delete-modal-overlay--visible');
        const modal = modalOverlay.querySelector('.delete-modal');
        if (modal) modal.classList.remove('delete-modal--visible');
        setTimeout(function() {
            modalOverlay.remove();
        }, 350);
    }

    /* ─── SEARCH HELPERS ─── */
    function bindSearch(config) {
        const input = document.getElementById(config.inputId);
        const results = document.getElementById(config.resultsId);
        const spinner = document.getElementById(config.spinnerId);
        const clearBtn = document.getElementById(config.clearId);
        const countEl = config.countSelector ? document.querySelector(config.countSelector) : null;

        if (!input || !results) return;

        let timeout = null;

        function performSearch(query) {
            const url = new URL(window.location.href);
            const preserved = config.preservedParam ? url.searchParams.get(config.preservedParam) : null;

            let searchUrl = window.location.pathname + '?';
            if (preserved) {
                searchUrl += config.preservedParam + '=' + preserved + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (spinner) spinner.style.display = 'inline-block';

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    results.innerHTML = data.html;
                }

                if (data.total !== undefined && countEl) {
                    countEl.textContent = data.total + ' ' + config.countLabel;
                }

                if (clearBtn) {
                    clearBtn.style.display = query.length > 0 ? 'inline-flex' : 'none';
                }

                if (spinner) spinner.style.display = 'none';
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (spinner) spinner.style.display = 'none';
            });
        }

        input.addEventListener('input', function() {
            const query = this.value.trim();
            if (timeout) clearTimeout(timeout);
            timeout = setTimeout(function() {
                performSearch(query);
            }, 400);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = '';
                input.focus();
                performSearch('');
            });
        }

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                input.focus();
                input.select();
            }

            if (e.key === 'Escape') {
                if (document.activeElement === input) {
                    input.value = '';
                    input.blur();
                    performSearch('');
                }
            }
        });

        if (input.value.trim().length > 0 && clearBtn) {
            clearBtn.style.display = 'inline-flex';
        }
    }

    /* ─── BIND ALL SEARCH SECTIONS ─── */
    bindSearch({
        inputId: 'adminSearchInput',
        resultsId: 'adminSearchResults',
        spinnerId: 'adminSearchSpinner',
        clearId: 'adminSearchClear',
        countSelector: '.books-index__filter-count',
        countLabel: 'books',
        preservedParam: 'filter',
    });

    bindSearch({
        inputId: 'eventsSearchInput',
        resultsId: 'eventsSearchResults',
        spinnerId: 'eventsSearchSpinner',
        clearId: 'eventsSearchClear',
        countSelector: '.events-index__filter-count',
        countLabel: 'events',
        preservedParam: 'filter',
    });

    bindSearch({
        inputId: 'baptismsSearchInput',
        resultsId: 'baptismsSearchResults',
        spinnerId: 'baptismsSearchSpinner',
        clearId: 'baptismsSearchClear',
        countSelector: '.baptisms-index__count',
        countLabel: 'total requests',
        preservedParam: 'status',
    });

    bindSearch({
        inputId: 'messagesSearchInput',
        resultsId: 'messagesSearchResults',
        spinnerId: 'messagesSearchSpinner',
        clearId: 'messagesSearchClear',
        countSelector: '.messages-index__count',
        countLabel: 'total messages',
        preservedParam: 'status',
    });

    bindSearch({
        inputId: 'invitesSearchInput',
        resultsId: 'invitesSearchResults',
        spinnerId: 'invitesSearchSpinner',
        clearId: 'invitesSearchClear',
        countSelector: '.invites-index__count',
        countLabel: 'total requests',
        preservedParam: 'status',
    });

    bindSearch({
        inputId: 'ordersSearchInput',
        resultsId: 'ordersSearchResults',
        spinnerId: 'ordersSearchSpinner',
        clearId: 'ordersSearchClear',
        countSelector: '.orders-index__filter-count',
        countLabel: 'orders',
        preservedParam: 'status',
    });

    /* ─── FORM SUBMIT WITH OVERLAY + BUTTON LOADER ─── */
    document.querySelectorAll('.form-loading').forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');

            showOverlay();

            if (submitBtn) {
                const originalHTML = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn._originalHTML = originalHTML;
            }
        });
    });

    /* ─── GLOBAL NAVIGATION OVERLAY ─── */
    // Intercept ANY link click (not just same-origin) as long as it stays in admin panel.
    document.addEventListener('click', function(e) {
        // Find the closest anchor
        const link = e.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href');
        const target = link.getAttribute('target');

        // Skip conditions
        if (!href ||
            href.startsWith('#') ||
            href.startsWith('javascript:') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:') ||
            target === '_blank' ||
            link.hasAttribute('download') ||
            e.ctrlKey || e.metaKey || e.shiftKey || e.altKey ||
            e.button !== 0) {
            return;
        }

        // Only show overlay for admin panel navigation (relative URLs)
        if (href.startsWith('/') || href.startsWith(window.location.origin)) {
            showOverlay();
        }
    });

    /* ─── BACK/FORWARD NAVIGATION ─── */
    window.addEventListener('beforeunload', function() {
        showOverlay();
    });

    /* ─── STATUS UPDATE (AJAX) WITH FEEDBACK ─── */
    document.querySelectorAll('.status-update-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHTML = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            }

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(function(response) {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showFlashMessage(data.message || 'Updated successfully!', 'success');

                    const statusBadge = submitBtn ? submitBtn.closest('tr')?.querySelector('.badge') : null;
                    if (statusBadge && data.status) {
                        statusBadge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        statusBadge.className = 'badge badge-' + data.status;
                    }
                } else {
                    showFlashMessage(data.message || 'Something went wrong.', 'error');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                showFlashMessage('Error updating status. Please try again.', 'error');
            })
            .finally(function() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                }
            });
        });
    });

    /* ─── FLASH MESSAGE HELPER ─── */
    function showFlashMessage(message, type) {
        const existing = document.querySelector('.flash-message');
        if (existing) existing.remove();

        const flash = document.createElement('div');
        flash.className = 'flash-message flash-message--' + type;
        flash.innerHTML = `
            <span class="flash-message__content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                ${message}
            </span>
            <button class="flash-message__close" onclick="this.parentElement.remove()">&times;</button>
        `;

        document.body.appendChild(flash);

        setTimeout(function() {
            flash.classList.add('flash-message--fade-out');
            setTimeout(function() {
                flash.remove();
            }, 400);
        }, 5000);
    }

    // Expose globally for inline usage (used in orders/show.blade.php)
    window.showFlashMessage = showFlashMessage;

    /* ─── SAFETY — NEVER LET OVERLAY GET STUCK FOREVER ─── */
    document.addEventListener('submit', function() {
        setTimeout(function() {
            if (overlay && overlay.classList.contains('admin-overlay--visible')) {
                if (document.readyState === 'complete') hideOverlay();
            }
        }, 15000);
    });

});