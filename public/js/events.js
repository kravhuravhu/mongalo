document.addEventListener('DOMContentLoaded', function() {
    // ─── EVENTS ORBS PARALLAX ───
    const eventsOrbs = document.querySelectorAll('.events__orb');
    if (eventsOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                eventsOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── SCROLL REVEAL FOR UPCOMING EVENTS ───
    const upcomingCards = document.querySelectorAll('.events__upcoming-card');
    if (upcomingCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('events__upcoming-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        upcomingCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR PAST EVENTS ───
    const pastCards = document.querySelectorAll('.events__past-card');
    if (pastCards.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    const delay = index * 80;
                    setTimeout(() => {
                        entry.target.classList.add('events__past-card--visible');
                    }, delay);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        pastCards.forEach(card => observer.observe(card));
    }

    // ─── SCROLL REVEAL FOR INVITE VISUAL ───
    const inviteVisual = document.querySelector('.events__invite-visual');
    if (inviteVisual) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('events__invite-visual--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        });
        observer.observe(inviteVisual);
    }

    // ─── SCROLL REVEAL FOR COMMUNITY CTA ───
    const communitySection = document.querySelector('.events__community-content');
    if (communitySection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('events__community-content--visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        observer.observe(communitySection);
    }

    // ─── COUNTDOWN TIMER — MM : DD : HH : MM : SS ───
    const countdownEl = document.querySelector('.events__countdown');
    if (countdownEl) {
        const eventDate = countdownEl.dataset.eventDate;
        const eventTime = countdownEl.dataset.eventTime;

        function updateCountdown() {
            if (!eventDate || !eventTime) {
                document.getElementById('cd-months').textContent = '00';
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                return;
            }

            const targetDate = new Date(`${eventDate}T${eventTime}`).getTime();
            if (isNaN(targetDate)) return;

            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                document.getElementById('cd-months').textContent = '00';
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-minutes').textContent = '00';
                document.getElementById('cd-seconds').textContent = '00';
                return;
            }

            let totalSeconds = Math.floor(distance / 1000);
            let totalMinutes = Math.floor(totalSeconds / 60);
            let totalHours = Math.floor(totalMinutes / 60);
            let totalDays = Math.floor(totalHours / 24);

            const months = Math.floor(totalDays / 30.44);
            const remainingDays = Math.floor(totalDays % 30.44);
            const hours = totalHours % 24;
            const minutes = totalMinutes % 60;
            const seconds = totalSeconds % 60;

            document.getElementById('cd-months').textContent = String(months).padStart(2, '0');
            document.getElementById('cd-days').textContent = String(remainingDays).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('cd-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.events__hero-badge');
    if (heroBadge) {
        heroBadge.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(15deg) scale(1.2)';
            }
        });
        heroBadge.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(0deg) scale(1)';
            }
        });
    }

    // ─── HERO ORBS PARALLAX ───
    const heroOrbs = document.querySelectorAll('.events__hero-orb');
    if (heroOrbs.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                heroOrbs.forEach((orb, index) => {
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }

    // ─── PENDING REGISTRATION CHECK ON PAGE LOAD ───
    (function checkPendingRegistration() {
        // ─── FIND ALL PENDING REGISTRATION KEYS ───
        const keys = Object.keys(localStorage);
        const pendingKeys = keys.filter(key => key.startsWith('pending_registration_'));
        
        if (pendingKeys.length > 0) {
            // ─── CHECK THE FIRST PENDING REGISTRATION ───
            const key = pendingKeys[0];
            const data = localStorage.getItem(key);
            
            if (data) {
                try {
                    const registration = JSON.parse(data);
                    
                    // ─── CHECK IF NOT EXPIRED ───
                    if (registration.expires_at && new Date(registration.expires_at) > new Date()) {
                        // ─── FIND THE EVENT ID IN THE PAGE ───
                        const eventIdInput = document.querySelector('input[name="event_id"]');
                        const eventId = eventIdInput ? eventIdInput.value : null;
                        
                        // ─── IF THIS IS THE SAME EVENT, SHOW PENDING NOTICE ───
                        if (eventId && registration.event_id == eventId) {
                            showPendingRegistration(registration);
                        }
                    } else {
                        // ─── EXPIRED - REMOVE ───
                        localStorage.removeItem(key);
                    }
                } catch (e) {
                    console.error('Error parsing pending registration:', e);
                    localStorage.removeItem(key);
                }
            }
        }
    })();

    function showPendingRegistration(data) {
        const container = document.getElementById('pendingRegistrationContainer');
        const formCard = document.getElementById('registrationFormCard');
        
        if (container) {
            container.style.display = 'block';
        }
        
        if (formCard) {
            // ─── HIDE THE FORM ───
            const fields = formCard.querySelectorAll('.event-detail__form-group');
            fields.forEach(function(field) {
                field.style.display = 'none';
            });
            const note = formCard.querySelector('.event-detail__form-note');
            if (note) note.style.display = 'none';
            const subtitle = formCard.querySelector('.event-detail__form-subtitle');
            if (subtitle) subtitle.style.display = 'none';
            const title = formCard.querySelector('.event-detail__form-title');
            if (title) title.style.display = 'none';
            const submitBtn = document.getElementById('registerBtn');
            if (submitBtn) submitBtn.style.display = 'none';
        }

        // ─── FILL IN DATA ───
        const nameEl = document.getElementById('pendingName');
        const emailEl = document.getElementById('pendingEmail');
        const phoneEl = document.getElementById('pendingPhone');
        const regIdEl = document.getElementById('pendingRegId');
        const statusEl = document.getElementById('pendingStatus');
        const iconEl = document.getElementById('pendingIcon');
        const titleEl = document.getElementById('pendingTitle');
        
        if (nameEl) nameEl.textContent = data.name;
        if (emailEl) emailEl.textContent = data.email;
        if (phoneEl) phoneEl.textContent = data.phone;
        if (regIdEl) regIdEl.textContent = data.registration_id;

        // ─── STATUS ───
        if (statusEl) {
            if (data.payment_status === 'paid' || data.is_free) {
                statusEl.innerHTML = '<span class="badge badge-completed">Confirmed</span>';
                if (iconEl) iconEl.innerHTML = '<i class="fas fa-check-circle" style="color: #28a745;"></i>';
                if (titleEl) titleEl.textContent = 'You\'re Registered!';
            } else {
                statusEl.innerHTML = '<span class="badge badge-pending">Pending Payment</span>';
                if (iconEl) iconEl.innerHTML = '<i class="fas fa-clock" style="color: #e8a838;"></i>';
                if (titleEl) titleEl.textContent = 'Payment Pending';
            }
        }

        // ─── BANKING DETAILS ───
        const bankingEl = document.getElementById('pendingBanking');
        if (bankingEl && data.banking_details && !data.is_free && data.payment_status === 'pending') {
            bankingEl.style.display = 'block';
            const bankEl = document.getElementById('pendingBank');
            const accountNameEl = document.getElementById('pendingAccountName');
            const accountNumberEl = document.getElementById('pendingAccountNumber');
            const branchCodeEl = document.getElementById('pendingBranchCode');
            const referenceEl = document.getElementById('pendingReference');
            
            if (bankEl) bankEl.textContent = data.banking_details.bank;
            if (accountNameEl) accountNameEl.textContent = data.banking_details.account_name;
            if (accountNumberEl) accountNumberEl.textContent = data.banking_details.account_number;
            if (branchCodeEl) branchCodeEl.textContent = data.banking_details.branch_code;
            if (referenceEl) referenceEl.textContent = data.banking_details.reference;
        } else if (bankingEl) {
            bankingEl.style.display = 'none';
        }
    }
});

// ─── EVENT DETAIL SCROLL REVEAL ───
document.addEventListener('DOMContentLoaded', function() {

    // ─── EVENT DETAIL ORBS PARALLAX ───
    const detailOrbs = document.querySelectorAll('.event-detail__orb');
    if (detailOrbs.length > 0 && window.innerWidth > 768) {
        let rafId = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            rafId = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                detailOrbs.forEach((orb, index) => {
                    const speed = 12 + index * 4;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId = null;
            });
        }, { passive: true });
    }

    // ─── HERO BADGE INTERACTION ───
    const heroBadge = document.querySelector('.event-detail__hero-badge');
    if (heroBadge) {
        heroBadge.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(15deg) scale(1.2)';
            }
        });
        heroBadge.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(0deg) scale(1)';
            }
        });
    }

    // ─── HERO ORBS PARALLAX ───
    const heroOrbs = document.querySelectorAll('.event-detail__hero-orb');
    if (heroOrbs.length > 0 && window.innerWidth > 768) {
        let rafId2 = null;

        document.addEventListener('mousemove', function(e) {
            if (rafId2) {
                cancelAnimationFrame(rafId2);
            }

            rafId2 = requestAnimationFrame(() => {
                const x = (e.clientX / window.innerWidth - 0.5) * 2;
                const y = (e.clientY / window.innerHeight - 0.5) * 2;
                
                heroOrbs.forEach((orb, index) => {
                    const speed = 15 + index * 6;
                    const moveX = x * speed;
                    const moveY = y * speed;
                    orb.style.transform = `translate(${moveX}px, ${moveY}px)`;
                });

                rafId2 = null;
            });
        }, { passive: true });
    }

    // ─── REGISTRATION FORM HANDLING ───
    const form = document.getElementById('eventRegistrationForm');
    const messageDiv = document.getElementById('registrationMessage');
    const submitBtn = document.getElementById('registerBtn');
    const btnText = document.getElementById('registerBtnText');
    const btnLoader = document.getElementById('registerBtnLoader');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // ─── SHOW LOADING ───
            if (submitBtn) {
                submitBtn.disabled = true;
                if (btnText) btnText.style.display = 'none';
                if (btnLoader) btnLoader.style.display = 'inline';
            }

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
            .then(function(response) {
                // ─── CHECK IF RESPONSE IS JSON ───
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server returned HTML instead of JSON.');
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // ─── SAVE TO LOCALSTORAGE ───
                    const STORAGE_KEY = 'pending_registration_' + data.registration_data.event_id;
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data.registration_data));

                    // ─── SHOW SUCCESS MESSAGE ───
                    if (messageDiv) {
                        let html = `
                            <div class="registration-success">
                                <div class="registration-success__icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h4 class="registration-success__title">Registration Successful!</h4>
                                <p class="registration-success__message">${data.message}</p>
                                <div class="registration-success__id">
                                    <strong>Registration ID:</strong> ${data.registration_id}
                                </div>
                                <div class="registration-success__actions">
                                    <button onclick="window.location.reload()" class="btn btn--secondary btn--sm">
                                        <i class="fas fa-eye"></i> View Status
                                    </button>
                                </div>
                        `;

                        if (!data.is_free && data.banking_details) {
                            html += `
                                <div class="registration-success__banking">
                                    <h5>Banking Details</h5>
                                    <div class="registration-success__banking-grid">
                                        <div>
                                            <span class="label">Bank</span>
                                            <span class="value">${data.banking_details.bank}</span>
                                        </div>
                                        <div>
                                            <span class="label">Account Name</span>
                                            <span class="value">${data.banking_details.account_name}</span>
                                        </div>
                                        <div>
                                            <span class="label">Account Number</span>
                                            <span class="value">${data.banking_details.account_number}</span>
                                        </div>
                                        <div>
                                            <span class="label">Branch Code</span>
                                            <span class="value">${data.banking_details.branch_code}</span>
                                        </div>
                                        <div style="grid-column: 1 / -1;">
                                            <span class="label">Reference</span>
                                            <span class="value" style="font-weight: 700; color: var(--gold);">${data.banking_details.reference}</span>
                                        </div>
                                        <div style="grid-column: 1 / -1; text-align: center; font-weight: 600; font-size: 1.1rem; padding-top: 8px; border-top: 1px solid rgba(21, 87, 36, 0.1);">
                                            Amount: R${data.amount}
                                        </div>
                                    </div>
                                    <p>
                                        <i class="fas fa-info-circle"></i> 
                                        Please use your Registration ID as reference when making payment.
                                    </p>
                                </div>
                            `;
                        }

                        html += `</div>`;
                        messageDiv.innerHTML = html;
                    }

                    // ─── HIDE FORM ───
                    const formCard = document.getElementById('registrationFormCard');
                    if (formCard) {
                        const fields = formCard.querySelectorAll('.event-detail__form-group');
                        fields.forEach(function(field) {
                            field.style.display = 'none';
                        });
                        const note = formCard.querySelector('.event-detail__form-note');
                        if (note) note.style.display = 'none';
                        const subtitle = formCard.querySelector('.event-detail__form-subtitle');
                        if (subtitle) subtitle.style.display = 'none';
                        const title = formCard.querySelector('.event-detail__form-title');
                        if (title) title.style.display = 'none';
                        if (submitBtn) submitBtn.style.display = 'none';
                    }

                    // ─── SHOW WHATSAPP POPUP ───
                    if (data.show_whatsapp) {
                        setTimeout(function() {
                            const popup = document.getElementById('whatsappPopup');
                            if (popup) {
                                popup.classList.add('show');
                            }
                        }, 1000);
                    }

                    // ─── RESET BUTTON ───
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        if (btnText) btnText.style.display = 'inline';
                        if (btnLoader) btnLoader.style.display = 'none';
                    }
                } else {
                    // ─── HANDLE DUPLICATE REGISTRATION ───
                    if (data.existing) {
                        // ─── SHOW THAT USER IS ALREADY REGISTERED ───
                        if (messageDiv) {
                            messageDiv.innerHTML = `
                                <div class="registration-error" style="background: #fff3cd; color: #856404; border-left-color: #e8a838;">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <strong>${data.message}</strong>
                                        <br>
                                        <span style="font-size: 0.85rem;">Registration ID: ${data.registration_id}</span>
                                        <br>
                                        <button onclick="window.location.reload()" class="btn btn--primary btn--sm" style="margin-top: 8px;">
                                            <i class="fas fa-eye"></i> View Status
                                        </button>
                                    </div>
                                </div>
                            `;
                        }
                    } else {
                        // ─── HANDLE OTHER ERRORS ───
                        let errorMessage = data.message || 'Something went wrong. Please try again.';
                        
                        if (data.field === 'phone') {
                            const phoneInput = document.getElementById('phone');
                            if (phoneInput) {
                                phoneInput.style.borderColor = '#dc3545';
                                phoneInput.focus();
                                phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                        
                        if (data.field === 'email') {
                            const emailInput = document.getElementById('email');
                            if (emailInput) {
                                emailInput.style.borderColor = '#dc3545';
                                emailInput.focus();
                                emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }

                        if (messageDiv) {
                            messageDiv.innerHTML = `
                                <div class="registration-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    ${errorMessage}
                                </div>
                            `;
                        }
                    }

                    // ─── RESET BUTTON ───
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        if (btnText) btnText.style.display = 'inline';
                        if (btnLoader) btnLoader.style.display = 'none';
                    }
                }
            })
            .catch(function(error) {
                console.error('Registration error:', error);
                
                if (messageDiv) {
                    messageDiv.innerHTML = `
                        <div class="registration-error">
                            <i class="fas fa-exclamation-circle"></i>
                            Error: ${error.message || 'Something went wrong. Please try again.'}
                        </div>
                    `;
                }
                
                // ─── RESET BUTTON ───
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (btnText) btnText.style.display = 'inline';
                    if (btnLoader) btnLoader.style.display = 'none';
                }
            });
        });
    }

    // ─── CLEAR REGISTRATION FORM ───
    const clearForm = document.getElementById('clearRegistrationForm');
    if (clearForm) {
        clearForm.addEventListener('submit', function(e) {
            // ─── CLEAR LOCALSTORAGE BEFORE SUBMIT ───
            const eventId = this.querySelector('input[name="event_id"]')?.value;
            if (eventId) {
                const STORAGE_KEY = 'pending_registration_' + eventId;
                localStorage.removeItem(STORAGE_KEY);
            }
        });
    }
});