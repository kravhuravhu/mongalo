// ─── iN COMMUNITY PAGE ───
document.addEventListener('DOMContentLoaded', function() {
    const root = document.querySelector('.in--community');
    
    if (!root) return;
    
    // ─── PROGRAM TABS ───
    const tabs = root.querySelectorAll('.in__tab');
    const rows = root.querySelectorAll('.in__row');
    const rowsWrap = document.getElementById('inRows');
    const emptyState = document.getElementById('inEmpty');
    const invitePanel = document.getElementById('inInvite');
    
    function filterRows(cat) {
        tabs.forEach(function(tab) {
            tab.classList.toggle('is-active', tab.dataset.cat === cat);
        });

        if (cat === 'invite') {
            rowsWrap.classList.add('is-hidden');
            invitePanel.classList.remove('is-hidden');
            return;
        }

        invitePanel.classList.add('is-hidden');
        rowsWrap.classList.remove('is-hidden');

        let shown = 0;
        rows.forEach(function(row) {
            const show = cat === 'all' || row.dataset.cat === cat;
            row.classList.toggle('is-hidden', !show);
            if (show) shown++;
        });

        emptyState.classList.toggle('is-hidden', shown > 0);
    }
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            filterRows(tab.dataset.cat);
        });
    });

    root.querySelectorAll('[data-filter]').forEach(function(link) {
        link.addEventListener('click', function() {
            filterRows(link.dataset.filter);
        });
    });

    filterRows(root.dataset.initialCat || 'all');

    // ─── POSTER TILT ───
    const posterWrap = document.getElementById('inPosterWrap');
    const poster = document.getElementById('inPoster');
    if (posterWrap && poster) {
        posterWrap.addEventListener('mousemove', function(e) {
            const rect = posterWrap.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            poster.style.transform = 'rotateY(' + (-10 + x * 14).toFixed(2) + 'deg) rotateX(' + (4 - y * 10).toFixed(2) + 'deg)';
        });
        posterWrap.addEventListener('mouseleave', function() {
            poster.style.transform = '';
        });
    }

    // ─── REGISTER MODAL ───
    const modal = document.getElementById('inRegisterModal');
    const form = document.getElementById('inRegForm');
    const formView = document.getElementById('inRegFormView');
    const successView = document.getElementById('inRegSuccessView');
    const eventIdInput = document.getElementById('inRegEventId');
    const occurrenceField = document.getElementById('inRegOccurrenceField');
    const occurrenceSelect = document.getElementById('inRegOccurrence');
    const errorBox = document.getElementById('inRegError');
    const submitBtn = document.getElementById('inRegSubmit');
    const submitText = document.getElementById('inRegSubmitText');
    const submitLoader = document.getElementById('inRegSubmitLoader');
    const state = { title: '', occurrences: [], timer: null, target: null };
    
    // ─── COUNTDOWN ───
    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function tick() {
        if (!state.target) return;
        
        let left = Math.max(0, Math.floor((state.target - Date.now()) / 1000));
        
        document.getElementById('cdDays').textContent = pad(Math.floor(left / 86400));
        document.getElementById('cdHours').textContent = pad(Math.floor((left % 86400) / 3600));
        document.getElementById('cdMins').textContent = pad(Math.floor((left % 3600) / 60));
        document.getElementById('cdSecs').textContent = pad(left % 60);
    }

    function startCountdown(iso) {
        state.target = new Date(iso).getTime();
        clearInterval(state.timer);
        tick();
        state.timer = setInterval(tick, 1000);
    }

    // ─── REMEMBERED REGISTRATIONS (48H) ───
    function storageKey() {
        return 'in_reg_' + eventIdInput.value + '_' + (occurrenceSelect.value || 'once');
    }

    function readStored() {
        try {
            const raw = localStorage.getItem(storageKey());
            
            if (!raw) return null;
            
            const data = JSON.parse(raw);
            if (data.expires_at && new Date(data.expires_at) < new Date()) {
                localStorage.removeItem(storageKey());
                return null;
            }

            return data;
        } catch (e) {
            return null;
        }
    }

    function storeRegistration(data) {
        try {
            localStorage.setItem(storageKey(), JSON.stringify(data));
        } catch (e) {}
    }

    // ─── VIEWS ───
    function selectedOccurrence() {
        return state.occurrences.find(function(o) { return o.value === occurrenceSelect.value; }) || state.occurrences[0];
    }

    function showForm() {
        formView.hidden = false;
        successView.hidden = true;
        errorBox.hidden = true;
        
        resetSubmit();
    }

    function showSuccess(reg, message) {
        const occurrence = selectedOccurrence();
        document.getElementById('inSuccessMessage').textContent = message || 'Thank you for registering. A confirmation has been sent to your email.';
        document.getElementById('inSuccessId').textContent = reg.registration_id || '';
        document.getElementById('inSuccessName').textContent = reg.name || '';
        document.getElementById('inSuccessDateRow').hidden = !occurrence;
        document.getElementById('inSuccessDate').textContent = occurrence ? occurrence.label : '';
        
        const bank = reg.banking_details;
        const bankBox = document.getElementById('inSuccessBank');
        bankBox.hidden = !bank;
        
        if (bank) {
            document.getElementById('bankName').textContent = bank.bank;
            document.getElementById('bankAccountName').textContent = bank.account_name;
            document.getElementById('bankAccountNumber').textContent = bank.account_number;
            document.getElementById('bankBranch').textContent = bank.branch_code;
            document.getElementById('bankReference').textContent = bank.reference;
        }

        formView.hidden = true;
        successView.hidden = false;
    }

    function refreshView() {
        const stored = readStored();
        if (stored) {
            showSuccess(stored, 'You are already registered for this event.');
        } else {
            showForm();
        }
    }

    function resetSubmit() {
        submitBtn.disabled = false;
        submitText.hidden = false;
        submitLoader.hidden = true;
    }

    // ─── OPEN / CLOSE ───
    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        clearInterval(state.timer);
    }

    modal.querySelectorAll('[data-modal-close]').forEach(function(btn) {
        btn.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    function openRegister(btn) {
        const data = btn.dataset;
        state.title = data.title;
        state.occurrences = JSON.parse(data.occurrences || '[]');
        document.getElementById('inRegTitle').textContent = data.title;
        document.getElementById('inRegMeta').textContent = [data.location, data.time].filter(Boolean).join(', ');
        document.getElementById('inRegDesc').textContent = data.desc || '';
        document.getElementById('inRegPrice').textContent = data.isFree === '1' ? 'Free' : data.priceLabel + ' per person';
        
        const repeat = document.getElementById('inRegRepeat');
        repeat.hidden = !data.recurrence;
        document.getElementById('inRegRepeatText').textContent = data.recurrence || '';
        eventIdInput.value = data.eventId;
        
        // ─── DATE PICKER (RECURRING EVENTS ONLY) ───
        occurrenceSelect.innerHTML = '';
        if (data.recurrence) {
            state.occurrences.forEach(function(o) {
                const option = document.createElement('option');
                option.value = o.value;
                option.textContent = o.label;
                occurrenceSelect.appendChild(option);
            });
            occurrenceField.hidden = false;
        } else {
            occurrenceField.hidden = true;
        }

        if (state.occurrences.length) {
            startCountdown(state.occurrences[0].target);
        }

        refreshView();

        openModal();
    }
    occurrenceSelect.addEventListener('change', function() {
        const occurrence = selectedOccurrence();
        
        if (occurrence) startCountdown(occurrence.target);
        
        refreshView();
    });

    root.querySelectorAll('.in__row-open').forEach(function(btn) {
        btn.addEventListener('click', function() {
            openRegister(btn);
        });
    });

    root.querySelectorAll('[data-register-next]').forEach(function(link) {
        link.addEventListener('click', function() {
            const first = root.querySelector('.in__row:not(.is-hidden) .in__row-open') || root.querySelector('.in__row-open');
            if (first) openRegister(first);
        });
    });

    document.getElementById('inSuccessClear').addEventListener('click', function() {
        try {
            localStorage.removeItem(storageKey());
        } catch (e) {}
        showForm();
    });

    // ─── SUBMIT ───
    function showError(message) {
        errorBox.textContent = message;
        errorBox.hidden = false;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        errorBox.hidden = true;
        submitBtn.disabled = true;
        submitText.hidden = true;
        submitLoader.hidden = false;
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        })
        .then(function(response) {
            return response.json().then(function(data) {
                return { status: response.status, data: data };
            });
        })
        .then(function(result) {
            
            const data = result.data;
            if (data.success) {
                storeRegistration(data.registration_data);
                showSuccess(data.registration_data, data.message);
                return;
            }

            if (result.status === 409 && data.registration_data) {
                storeRegistration(data.registration_data);
                showSuccess(data.registration_data, data.message);
                return;
            }

            resetSubmit();

            if (window.turnstile) window.turnstile.reset();
            
            let message = data.message || 'Something went wrong. Please try again.';
            if (data.errors) {
                const first = Object.values(data.errors)[0];
                if (first && first.length) message = first[0];
            }

            showError(message);
        })
        .catch(function() {
            resetSubmit();
            if (window.turnstile) window.turnstile.reset();
            showError('Registration failed. Please try again.');
        });
    });
    
    // ─── OPEN FROM ?open=SLUG (OLD EVENT LINKS) ───
    const openSlug = new URLSearchParams(window.location.search).get('open');
    if (openSlug) {
        const row = Array.from(rows).find(function(r) { return r.dataset.slug === openSlug; });
        if (row) {
            filterRows('all');
            openRegister(row.querySelector('.in__row-open'));
        }
    }
});