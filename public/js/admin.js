document.addEventListener('DOMContentLoaded', function() {

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
            
            // ─── DETERMINE ACTION TYPE ───
            const isMarkPaid = this.querySelector('input[name="status"]')?.value === 'paid';
            const actionLabel = isMarkPaid ? 'Mark as Paid' : 'Delete';
            const actionIcon = isMarkPaid ? 'fa-check-circle' : 'fa-trash-alt';
            const actionColor = isMarkPaid ? '#28a745' : '#dc3545';
            const confirmText = isMarkPaid 
                ? `Are you sure you want to mark <strong>${itemName}</strong> as PAID? This confirms payment and cannot be undone.`
                : `Are you sure you want to delete <strong>${itemName}</strong>?<br><span class="delete-modal__warning">This action cannot be undone.</span>`;

            // ─── CREATE MODAL ───
            const overlay = document.createElement('div');
            overlay.className = 'delete-modal-overlay';
            overlay.innerHTML = `
                <div class="delete-modal">
                    <div class="delete-modal__icon" style="background: ${isMarkPaid ? '#d4edda' : '#f8d7da'};">
                        <i class="fas ${actionIcon}" style="color: ${actionColor};"></i>
                    </div>
                    <h3 class="delete-modal__title">${actionLabel} ${itemType}</h3>
                    <p class="delete-modal__text">
                        ${confirmText}
                    </p>
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

            document.body.appendChild(overlay);
            overlay._originalForm = this;

            // ─── ANIMATE IN ───
            requestAnimationFrame(function() {
                overlay.classList.add('delete-modal-overlay--visible');
                const modal = overlay.querySelector('.delete-modal');
                if (modal) {
                    modal.classList.add('delete-modal--visible');
                }
            });

            // ─── HANDLE CANCEL ───
            overlay.querySelector('.delete-modal__cancel').addEventListener('click', function() {
                closeModal(overlay);
            });

            // ─── HANDLE CONFIRM ───
            overlay.querySelector('.delete-modal__confirm').addEventListener('click', function() {
                const confirmBtn = this;
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                const originalForm = overlay._originalForm;
                originalForm.submit();
            });

            // ─── CLOSE ON OVERLAY CLICK ───
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this);
                }
            });

            // ─── CLOSE ON ESC ───
            function handleEsc(e) {
                if (e.key === 'Escape') {
                    closeModal(overlay);
                    document.removeEventListener('keydown', handleEsc);
                }
            }
            document.addEventListener('keydown', handleEsc);
        });
    });

    // ─── CLOSE MODAL FUNCTION ───
    function closeModal(overlay) {
        overlay.classList.remove('delete-modal-overlay--visible');
        const modal = overlay.querySelector('.delete-modal');
        if (modal) {
            modal.classList.remove('delete-modal--visible');
        }
        setTimeout(function() {
            overlay.remove();
        }, 350);
    }

    // ─── BOOKS SEARCH ───
    const booksSearchInput = document.getElementById('adminSearchInput');
    const booksSearchResults = document.getElementById('adminSearchResults');
    const booksSearchSpinner = document.getElementById('adminSearchSpinner');
    const booksClearBtn = document.getElementById('adminSearchClear');

    if (booksSearchInput && booksSearchResults) {
        let searchTimeout = null;

        function performBooksSearch(query) {
            const url = new URL(window.location.href);
            const filter = url.searchParams.get('filter') || '';

            let searchUrl = window.location.pathname + '?';
            if (filter) {
                searchUrl += 'filter=' + filter + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (booksSearchSpinner) {
                booksSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    booksSearchResults.innerHTML = data.html;

                    // Re-bind delete confirm on new rows
                    booksSearchResults.querySelectorAll('.delete-confirm').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            // Delete modal logic will be handled by outer listener
                        });
                    });
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.books-index__filter-count');
                    if (countEl) {
                        countEl.textContent = data.total + ' books';
                    }
                }

                if (booksClearBtn) {
                    if (query.length > 0) {
                        booksClearBtn.style.display = 'inline-flex';
                    } else {
                        booksClearBtn.style.display = 'none';
                    }
                }

                if (booksSearchSpinner) {
                    booksSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (booksSearchSpinner) {
                    booksSearchSpinner.style.display = 'none';
                }
            });
        }

        booksSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            searchTimeout = setTimeout(function() {
                performBooksSearch(query);
            }, 400);
        });

        if (booksClearBtn) {
            booksClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                booksSearchInput.value = '';
                booksSearchInput.focus();
                performBooksSearch('');
            });
        }

        // ─── KEYBOARD SHORTCUTS ───
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                booksSearchInput.focus();
                booksSearchInput.select();
            }

            if (e.key === 'Escape') {
                if (document.activeElement === booksSearchInput) {
                    booksSearchInput.value = '';
                    booksSearchInput.blur();
                    performBooksSearch('');
                }
            }
        });

        if (booksSearchInput.value.trim().length > 0 && booksClearBtn) {
            booksClearBtn.style.display = 'inline-flex';
        }
    }

    // ─── EVENTS SEARCH ───
    const eventsSearchInput = document.getElementById('eventsSearchInput');
    const eventsSearchResults = document.getElementById('eventsSearchResults');
    const eventsSearchSpinner = document.getElementById('eventsSearchSpinner');
    const eventsClearBtn = document.getElementById('eventsSearchClear');

    if (eventsSearchInput && eventsSearchResults) {
        let eventsSearchTimeout = null;

        function performEventsSearch(query) {
            const url = new URL(window.location.href);
            const filter = url.searchParams.get('filter') || '';

            let searchUrl = window.location.pathname + '?';
            if (filter) {
                searchUrl += 'filter=' + filter + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (eventsSearchSpinner) {
                eventsSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    eventsSearchResults.innerHTML = data.html;

                    eventsSearchResults.querySelectorAll('.delete-confirm').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                        });
                    });
                }

                // ─── UPDATE TOTAL COUNT ───
                if (data.total !== undefined) {
                    const countEl = document.querySelector('.events-index__filter-count');
                    if (countEl) {
                        if (data.upcomingCount !== undefined && data.pastCount !== undefined) {
                            countEl.innerHTML = data.total + ' events <span style="font-size: 0.65rem; color: var(--text-muted); margin-left: 8px;">(' + data.upcomingCount + ' upcoming · ' + data.pastCount + ' past)</span>';
                        } else {
                            countEl.textContent = data.total + ' events';
                        }
                    }
                }

                if (eventsClearBtn) {
                    if (query.length > 0) {
                        eventsClearBtn.style.display = 'inline-flex';
                    } else {
                        eventsClearBtn.style.display = 'none';
                    }
                }

                if (eventsSearchSpinner) {
                    eventsSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (eventsSearchSpinner) {
                    eventsSearchSpinner.style.display = 'none';
                }
            });
        }

        eventsSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (eventsSearchTimeout) {
                clearTimeout(eventsSearchTimeout);
            }

            eventsSearchTimeout = setTimeout(function() {
                performEventsSearch(query);
            }, 400);
        });

        if (eventsClearBtn) {
            eventsClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                eventsSearchInput.value = '';
                eventsSearchInput.focus();
                performEventsSearch('');
            });
        }

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                if (document.activeElement !== eventsSearchInput) {
                    eventsSearchInput.focus();
                    eventsSearchInput.select();
                }
            }

            if (e.key === 'Escape') {
                if (document.activeElement === eventsSearchInput) {
                    eventsSearchInput.value = '';
                    eventsSearchInput.blur();
                    performEventsSearch('');
                }
            }
        });

        if (eventsSearchInput.value.trim().length > 0 && eventsClearBtn) {
            eventsClearBtn.style.display = 'inline-flex';
        }
    }

    // ─── BAPTISMS SEARCH ───
    const baptismsSearchInput = document.getElementById('baptismsSearchInput');
    const baptismsSearchResults = document.getElementById('baptismsSearchResults');
    const baptismsSearchSpinner = document.getElementById('baptismsSearchSpinner');
    const baptismsClearBtn = document.getElementById('baptismsSearchClear');

    if (baptismsSearchInput && baptismsSearchResults) {
        let baptismsSearchTimeout = null;

        function performBaptismsSearch(query) {
            const url = new URL(window.location.href);
            const status = url.searchParams.get('status') || '';

            let searchUrl = window.location.pathname + '?';
            if (status) {
                searchUrl += 'status=' + status + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (baptismsSearchSpinner) {
                baptismsSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    baptismsSearchResults.innerHTML = data.html;
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.baptisms-index__count');
                    if (countEl) {
                        countEl.textContent = data.total + ' total requests';
                    }
                }

                if (baptismsClearBtn) {
                    if (query.length > 0) {
                        baptismsClearBtn.style.display = 'inline-flex';
                    } else {
                        baptismsClearBtn.style.display = 'none';
                    }
                }

                if (baptismsSearchSpinner) {
                    baptismsSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (baptismsSearchSpinner) {
                    baptismsSearchSpinner.style.display = 'none';
                }
            });
        }

        baptismsSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (baptismsSearchTimeout) {
                clearTimeout(baptismsSearchTimeout);
            }

            baptismsSearchTimeout = setTimeout(function() {
                performBaptismsSearch(query);
            }, 400);
        });

        if (baptismsClearBtn) {
            baptismsClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                baptismsSearchInput.value = '';
                baptismsSearchInput.focus();
                performBaptismsSearch('');
            });
        }

        if (baptismsSearchInput.value.trim().length > 0 && baptismsClearBtn) {
            baptismsClearBtn.style.display = 'inline-flex';
        }
    }

    // ─── MESSAGES SEARCH ───
    const messagesSearchInput = document.getElementById('messagesSearchInput');
    const messagesSearchResults = document.getElementById('messagesSearchResults');
    const messagesSearchSpinner = document.getElementById('messagesSearchSpinner');
    const messagesClearBtn = document.getElementById('messagesSearchClear');

    if (messagesSearchInput && messagesSearchResults) {
        let messagesSearchTimeout = null;

        function performMessagesSearch(query) {
            const url = new URL(window.location.href);
            const status = url.searchParams.get('status') || '';

            let searchUrl = window.location.pathname + '?';
            if (status) {
                searchUrl += 'status=' + status + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (messagesSearchSpinner) {
                messagesSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    messagesSearchResults.innerHTML = data.html;
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.messages-index__count');
                    if (countEl) {
                        countEl.textContent = data.total + ' total messages';
                    }
                }

                if (messagesClearBtn) {
                    if (query.length > 0) {
                        messagesClearBtn.style.display = 'inline-flex';
                    } else {
                        messagesClearBtn.style.display = 'none';
                    }
                }

                if (messagesSearchSpinner) {
                    messagesSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (messagesSearchSpinner) {
                    messagesSearchSpinner.style.display = 'none';
                }
            });
        }

        messagesSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (messagesSearchTimeout) {
                clearTimeout(messagesSearchTimeout);
            }

            messagesSearchTimeout = setTimeout(function() {
                performMessagesSearch(query);
            }, 400);
        });

        if (messagesClearBtn) {
            messagesClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                messagesSearchInput.value = '';
                messagesSearchInput.focus();
                performMessagesSearch('');
            });
        }

        if (messagesSearchInput.value.trim().length > 0 && messagesClearBtn) {
            messagesClearBtn.style.display = 'inline-flex';
        }
    }

    // ─── INVITES SEARCH ───
    const invitesSearchInput = document.getElementById('invitesSearchInput');
    const invitesSearchResults = document.getElementById('invitesSearchResults');
    const invitesSearchSpinner = document.getElementById('invitesSearchSpinner');
    const invitesClearBtn = document.getElementById('invitesSearchClear');

    if (invitesSearchInput && invitesSearchResults) {
        let invitesSearchTimeout = null;

        function performInvitesSearch(query) {
            const url = new URL(window.location.href);
            const status = url.searchParams.get('status') || '';

            let searchUrl = window.location.pathname + '?';
            if (status) {
                searchUrl += 'status=' + status + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (invitesSearchSpinner) {
                invitesSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    invitesSearchResults.innerHTML = data.html;
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.invites-index__count');
                    if (countEl) {
                        countEl.textContent = data.total + ' total requests';
                    }
                }

                if (invitesClearBtn) {
                    if (query.length > 0) {
                        invitesClearBtn.style.display = 'inline-flex';
                    } else {
                        invitesClearBtn.style.display = 'none';
                    }
                }

                if (invitesSearchSpinner) {
                    invitesSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (invitesSearchSpinner) {
                    invitesSearchSpinner.style.display = 'none';
                }
            });
        }

        invitesSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (invitesSearchTimeout) {
                clearTimeout(invitesSearchTimeout);
            }

            invitesSearchTimeout = setTimeout(function() {
                performInvitesSearch(query);
            }, 400);
        });

        if (invitesClearBtn) {
            invitesClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                invitesSearchInput.value = '';
                invitesSearchInput.focus();
                performInvitesSearch('');
            });
        }

        if (invitesSearchInput.value.trim().length > 0 && invitesClearBtn) {
            invitesClearBtn.style.display = 'inline-flex';
        }
    }

    /* ─── FORM SUBMIT WITH LOADING ─── */
    document.querySelectorAll('.form-loading').forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                const originalIcon = submitBtn.querySelector('i')?.className || '';

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                submitBtn._originalText = originalText;
                submitBtn._originalIcon = originalIcon;

                setTimeout(function() {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn._originalText || 'Submit';
                    }
                }, 30000);
            }
        });
    });

    /* ─── STATUS UPDATE WITH FEEDBACK ─── */
    document.querySelectorAll('.status-update-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';

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
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showFlashMessage(data.message || 'Updated successfully!', 'success');

                    const statusBadge = submitBtn.closest('tr').querySelector('.badge');
                    if (statusBadge && data.status) {
                        statusBadge.textContent = data.status;
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
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });

    /* ─── FLASH MESSAGE HELPER ─── */
    function showFlashMessage(message, type) {
        const existing = document.querySelector('.flash-message');
        if (existing) {
            existing.remove();
        }

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

    // ─── ORDERS SEARCH ───
    const ordersSearchInput = document.getElementById('ordersSearchInput');
    const ordersSearchResults = document.getElementById('ordersSearchResults');
    const ordersSearchSpinner = document.getElementById('ordersSearchSpinner');
    const ordersClearBtn = document.getElementById('ordersSearchClear');

    if (ordersSearchInput && ordersSearchResults) {
        let ordersSearchTimeout = null;

        function performOrdersSearch(query) {
            const url = new URL(window.location.href);
            const status = url.searchParams.get('status') || '';

            let searchUrl = window.location.pathname + '?';
            if (status) {
                searchUrl += 'status=' + status + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (ordersSearchSpinner) {
                ordersSearchSpinner.style.display = 'inline-block';
            }

            fetch(searchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.html) {
                    ordersSearchResults.innerHTML = data.html;
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.orders-index__filter-count');
                    if (countEl) {
                        countEl.textContent = data.total + ' orders';
                    }
                }

                if (ordersClearBtn) {
                    if (query.length > 0) {
                        ordersClearBtn.style.display = 'inline-flex';
                    } else {
                        ordersClearBtn.style.display = 'none';
                    }
                }

                if (ordersSearchSpinner) {
                    ordersSearchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (ordersSearchSpinner) {
                    ordersSearchSpinner.style.display = 'none';
                }
            });
        }

        ordersSearchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (ordersSearchTimeout) {
                clearTimeout(ordersSearchTimeout);
            }

            ordersSearchTimeout = setTimeout(function() {
                performOrdersSearch(query);
            }, 400);
        });

        if (ordersClearBtn) {
            ordersClearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                ordersSearchInput.value = '';
                ordersSearchInput.focus();
                performOrdersSearch('');
            });
        }

        if (ordersSearchInput.value.trim().length > 0 && ordersClearBtn) {
            ordersClearBtn.style.display = 'inline-flex';
        }
    }
});