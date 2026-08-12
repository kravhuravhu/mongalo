@extends('admin.layouts.admin')

@section('title', 'Message from ' . $message->name . ' · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Message Details')
@section('breadcrumb', 'Messages / View')

@section('content')

<div class="message-detail">
    {{-- ─── BACK BUTTON ─── --}}
    <div class="message-detail__header">
        <a href="{{ route('admin.messages') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>
        <div class="message-detail__status">
            <span class="badge badge-{{ $message->status }}">
                {{ ucfirst($message->status) }}
            </span>
            <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="status-update-form" style="display: inline;">
                @csrf
                @method('PUT')
                <select name="status" class="message-detail__status-select" onchange="this.form.submit()">
                    <option value="unread" {{ $message->status === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                </select>
            </form>
        </div>
    </div>

    {{-- ─── MESSAGE CARD ─── --}}
    <div class="message-detail__card">
        <div class="message-detail__sender">
            <div class="message-detail__avatar">
                {{ strtoupper(substr($message->name, 0, 1)) }}
            </div>
            <div class="message-detail__sender-info">
                <h3>{{ $message->name }}</h3>
                <div class="message-detail__sender-meta">
                    <a href="mailto:{{ $message->email }}" style="color: var(--gold); text-decoration: none;">
                        <i class="fas fa-envelope"></i> {{ $message->email }}
                    </a>
                    @if($message->phone)
                        <a href="tel:{{ $message->phone }}" style="color: var(--text-muted); text-decoration: none;">
                            <i class="fas fa-phone"></i> {{ $message->phone }}
                        </a>
                    @endif
                    <span style="color: var(--text-muted);">
                        <i class="fas fa-clock"></i> {{ $message->created_at->format('F d, Y g:i A') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="message-detail__body">
            <div class="message-detail__subject">
                <h4>{{ $message->subject }}</h4>
            </div>
            <div class="message-detail__content">
                {{ nl2br($message->message) }}
            </div>
        </div>

        {{-- ─── REPLY BUTTON ─── --}}
        <div class="message-detail__actions">
            <button type="button" class="btn btn--primary btn--lg" id="replyButton">
                <i class="fas fa-reply"></i> Reply
            </button>
            <a href="mailto:{{ $message->email }}" class="btn btn--secondary btn--lg" target="_blank">
                <i class="fas fa-envelope"></i> Open Email Client
            </a>
        </div>
    </div>
</div>

{{-- ─── CONFIRMATION MODAL ─── --}}
<div class="reply-modal-overlay" id="replyModalOverlay" style="display: none;">
    <div class="reply-modal">
        <div class="reply-modal__icon">
            <i class="fas fa-reply"></i>
        </div>
        <h3 class="reply-modal__title">Reply to {{ $message->name }}</h3>
        <p class="reply-modal__text">
            This will open your default email client with a pre-filled reply template.
            <br><br>
            <strong>To:</strong> {{ $message->email }}
            <br>
            <strong>Subject:</strong> Re: {{ $message->subject }}
        </p>
        <div class="reply-modal__preview">
            <div class="reply-modal__preview-header">
                <span><i class="fas fa-quote-left"></i> Original Message</span>
            </div>
            <div class="reply-modal__preview-body">
                <div class="reply-modal__preview-meta">
                    <span><strong>From:</strong> {{ $message->name }}</span>
                    <span><strong>Date:</strong> {{ $message->created_at->format('F d, Y g:i A') }}</span>
                    <span><strong>Subject:</strong> {{ $message->subject }}</span>
                </div>
                <div class="reply-modal__preview-message">
                    {{ $message->message }}
                </div>
            </div>
        </div>
        <p class="reply-modal__note">
            <i class="fas fa-info-circle"></i>
            Status will be automatically updated to "Replied" when you open the email client.
        </p>
        <div class="reply-modal__actions">
            <button class="btn btn--secondary" id="replyModalCancel">Cancel</button>
            <button class="btn btn--primary" id="replyModalConfirm">
                <i class="fas fa-envelope"></i> Open Email Client
            </button>
        </div>
    </div>
</div>

<style>
    .message-detail__actions {
        display: flex;
        gap: 12px;
        padding: 24px 32px 32px;
        border-top: 1px solid var(--border);
        background: var(--bg);
        flex-wrap: wrap;
    }

    .message-detail__actions .btn {
        padding: 12px 32px;
    }

    /* ─── REPLY MODAL ─── */
    .reply-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        transition: opacity 0.35s ease;
        animation: modalFadeIn 0.35s ease forwards;
    }

    .reply-modal-overlay--visible {
        opacity: 1;
    }

    .reply-modal {
        background: var(--surface);
        border-radius: 20px;
        padding: 40px 36px 32px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        transform: scale(0.92) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: modalSlideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .reply-modal__icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--gold-dim);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .reply-modal__icon i {
        font-size: 2rem;
        color: var(--gold);
    }

    .reply-modal__title {
        font-family: var(--font-serif);
        font-weight: 700;
        font-size: 1.4rem;
        text-align: center;
        color: var(--text);
        margin-bottom: 8px;
    }

    .reply-modal__text {
        color: var(--text-muted);
        text-align: center;
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .reply-modal__text strong {
        color: var(--text);
    }

    .reply-modal__preview {
        background: var(--bg);
        border-radius: 12px;
        border: 1px solid var(--border);
        overflow: hidden;
        margin-bottom: 16px;
    }

    .reply-modal__preview-header {
        padding: 10px 16px;
        background: var(--gold-dim);
        border-bottom: 1px solid var(--border);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reply-modal__preview-header i {
        font-size: 0.7rem;
    }

    .reply-modal__preview-body {
        padding: 16px;
    }

    .reply-modal__preview-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 16px;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border);
    }

    .reply-modal__preview-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .reply-modal__preview-meta strong {
        color: var(--text);
    }

    .reply-modal__preview-message {
        font-size: 0.9rem;
        color: var(--text);
        line-height: 1.7;
        white-space: pre-wrap;
        max-height: 150px;
        overflow-y: auto;
        padding: 4px 0;
    }

    .reply-modal__preview-message::-webkit-scrollbar {
        width: 4px;
    }

    .reply-modal__preview-message::-webkit-scrollbar-thumb {
        background: var(--gold-dim);
        border-radius: 4px;
    }

    .reply-modal__note {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-align: center;
        margin-bottom: 20px;
        padding: 8px 12px;
        background: #fff3cd;
        border-radius: 8px;
        color: #856404;
    }

    .reply-modal__note i {
        margin-right: 6px;
    }

    .reply-modal__actions {
        display: flex;
        gap: 12px;
    }

    .reply-modal__actions .btn {
        flex: 1;
        justify-content: center;
        padding: 12px 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .reply-modal__actions .btn--secondary {
        background: var(--bg);
        color: var(--text);
        border: 1px solid var(--border);
    }

    .reply-modal__actions .btn--secondary:hover {
        background: var(--gold-dim);
        border-color: var(--gold);
    }

    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: scale(0.92) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @media (max-width: 540px) {
        .reply-modal {
            padding: 24px 20px 20px;
            border-radius: 16px;
        }

        .reply-modal__icon {
            width: 48px;
            height: 48px;
        }

        .reply-modal__icon i {
            font-size: 1.4rem;
        }

        .reply-modal__title {
            font-size: 1.1rem;
        }

        .reply-modal__text {
            font-size: 0.85rem;
        }

        .reply-modal__preview-meta {
            flex-direction: column;
            gap: 4px;
        }

        .reply-modal__actions {
            flex-direction: column;
        }

        .reply-modal__actions .btn {
            padding: 10px 16px;
        }

        .message-detail__actions {
            padding: 16px 16px 20px;
            flex-direction: column;
        }

        .message-detail__actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyButton = document.getElementById('replyButton');
        const modalOverlay = document.getElementById('replyModalOverlay');
        const modalCancel = document.getElementById('replyModalCancel');
        const modalConfirm = document.getElementById('replyModalConfirm');

        // ─── SHOW MODAL ───
        if (replyButton) {
            replyButton.addEventListener('click', function() {
                modalOverlay.style.display = 'flex';
                // ─── TRIGGER ANIMATION ───
                setTimeout(function() {
                    modalOverlay.classList.add('reply-modal-overlay--visible');
                }, 10);
            });
        }

        // ─── CLOSE MODAL ───
        function closeModal() {
            modalOverlay.classList.remove('reply-modal-overlay--visible');
            setTimeout(function() {
                modalOverlay.style.display = 'none';
            }, 400);
        }

        if (modalCancel) {
            modalCancel.addEventListener('click', closeModal);
        }

        // ─── CLOSE ON OVERLAY CLICK ───
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // ─── CLOSE ON ESC ───
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (modalOverlay.style.display === 'flex') {
                    closeModal();
                }
            }
        });

        // ─── CONFIRM REPLY ───
        if (modalConfirm) {
            modalConfirm.addEventListener('click', function() {
                // ─── DISABLE BUTTON ───
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening...';

                // ─── MARK AS REPLIED ───
                fetch('{{ route("admin.messages.mark-replied", $message) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        // ─── UPDATE STATUS BADGE ───
                        const badge = document.querySelector('.badge-' + '{{ $message->status }}');
                        if (badge) {
                            badge.textContent = 'Replied';
                            badge.className = 'badge badge-replied';
                        }

                        // ─── UPDATE STATUS SELECT ───
                        const statusSelect = document.querySelector('.message-detail__status-select');
                        if (statusSelect) {
                            statusSelect.value = 'replied';
                        }

                        // ─── GET REPLY TEMPLATE ───
                        return fetch('{{ route("admin.messages.reply-template", $message) }}');
                    }
                    return Promise.reject(data.message);
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    // ─── BUILD MAILTO LINK ───
                    const mailtoLink = 'mailto:' + encodeURIComponent(data.to) +
                        '?subject=' + encodeURIComponent(data.subject) +
                        '&body=' + encodeURIComponent(data.body);

                    // ─── OPEN EMAIL CLIENT ───
                    window.open(mailtoLink, '_blank');

                    // ─── CLOSE MODAL ───
                    closeModal();

                    // ─── RESET BUTTON ───
                    modalConfirm.disabled = false;
                    modalConfirm.innerHTML = '<i class="fas fa-envelope"></i> Open Email Client';
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    // ─── FALLBACK: OPEN EMAIL WITH BASIC INFO ───
                    const fallbackLink = 'mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}';
                    window.open(fallbackLink, '_blank');
                    closeModal();
                    modalConfirm.disabled = false;
                    modalConfirm.innerHTML = '<i class="fas fa-envelope"></i> Open Email Client';

                    // ─── SHOW ERROR ───
                    alert('Could not mark message as replied. Please update status manually.');
                });
            });
        }
    });
</script>
@endpush