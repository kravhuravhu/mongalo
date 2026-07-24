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

    /* ─── DELETE CONFIRMATION MODAL ─── */
    document.querySelectorAll('.delete-confirm').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = this.querySelector('button[type="submit"]');
            const itemName = btn.getAttribute('data-title') || 'this item';
            const itemType = btn.getAttribute('data-type') || 'item';

            // ─── CREATE MODAL ───
            const overlay = document.createElement('div');
            overlay.className = 'delete-modal-overlay';
            overlay.innerHTML = `
                <div class="delete-modal">
                    <div class="delete-modal__icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h3 class="delete-modal__title">Delete ${itemType}</h3>
                    <p class="delete-modal__text">
                        Are you sure you want to delete <strong>${itemName}</strong>?
                        <br>
                        <span class="delete-modal__warning">This action cannot be undone.</span>
                    </p>
                    <div class="delete-modal__actions">
                        <button class="btn btn--secondary delete-modal__cancel">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button class="btn btn--danger delete-modal__confirm">
                            <i class="fas fa-trash"></i> Yes, Delete
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(overlay);

            // Store reference to the form
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
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';

                // Submit the original form
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

    /* ─── REAL-TIME SEARCH ─── */
    const searchInput = document.getElementById('adminSearchInput');
    const searchResults = document.getElementById('adminSearchResults');
    const searchSpinner = document.getElementById('adminSearchSpinner');
    const clearBtn = document.getElementById('adminSearchClear');

    if (searchInput && searchResults) {
        let searchTimeout = null;

        function performSearch(query) {
            const url = new URL(window.location.href);
            const filter = url.searchParams.get('filter') || '';

            let searchUrl = window.location.pathname + '?';
            if (filter) {
                searchUrl += 'filter=' + filter + '&';
            }
            if (query) {
                searchUrl += 'search=' + encodeURIComponent(query);
            }

            if (searchSpinner) {
                searchSpinner.style.display = 'inline-block';
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
                    searchResults.innerHTML = data.html;

                    // Re-bind delete confirm on new rows
                    searchResults.querySelectorAll('.delete-confirm').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            // Delete modal logic will be re-attached
                            // The outer event listener will handle it
                        });
                    });
                }

                if (data.total !== undefined) {
                    const countEl = document.querySelector('.books-index__filter-count');
                    if (countEl) {
                        countEl.textContent = data.total + ' books';
                    }
                }

                if (clearBtn) {
                    if (query.length > 0) {
                        clearBtn.style.display = 'inline-flex';
                    } else {
                        clearBtn.style.display = 'none';
                    }
                }

                if (searchSpinner) {
                    searchSpinner.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Search error:', error);
                if (searchSpinner) {
                    searchSpinner.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 400);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = '';
                searchInput.focus();
                performSearch('');
            });
        }

        // ─── KEYBOARD SHORTCUTS ───
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }

            if (e.key === 'Escape') {
                if (document.activeElement === searchInput) {
                    searchInput.value = '';
                    searchInput.blur();
                    performSearch('');
                }
            }
        });

        if (searchInput.value.trim().length > 0 && clearBtn) {
            clearBtn.style.display = 'inline-flex';
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

                // Store original for reset
                submitBtn._originalText = originalText;
                submitBtn._originalIcon = originalIcon;

                // Re-enable after 30 seconds (safety net)
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
});