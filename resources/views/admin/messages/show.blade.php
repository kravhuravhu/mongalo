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
        {{-- ─── SENDER HEADER ─── --}}
        <div class="message-detail__sender">
            <div class="message-detail__avatar">
                {{ strtoupper(substr($message->name, 0, 1)) }}
            </div>
            <div class="message-detail__sender-info">
                <h3>{{ $message->name }}</h3>
                <div class="message-detail__sender-meta">
                    <a href="mailto:{{ $message->email }}" class="message-detail__sender-email">
                        <i class="fas fa-envelope"></i> {{ $message->email }}
                    </a>
                    @if($message->phone)
                        <a href="tel:{{ $message->phone }}" class="message-detail__sender-phone">
                            <i class="fas fa-phone"></i> {{ $message->phone }}
                        </a>
                    @endif
                    <span class="message-detail__sender-date">
                        <i class="fas fa-clock"></i> {{ $message->created_at->format('F d, Y g:i A') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── MESSAGE BODY ─── --}}
        <div class="message-detail__body">
            <div class="message-detail__subject">
                <span class="message-detail__subject-label">Subject</span>
                <h4>{{ $message->subject }}</h4>
            </div>
            <div class="message-detail__content">
                {{ nl2br($message->message) }}
            </div>
        </div>

        {{-- ─── ACTIONS ─── --}}
        <div class="message-detail__actions">
            <button type="button" class="btn btn--primary btn--lg" id="replyButton">
                <i class="fas fa-reply"></i> Reply to {{ $message->name }}
            </button>
        </div>
    </div>
</div>

{{-- ─── CONFIRMATION MODAL ─── --}}
<div class="reply-modal-overlay" id="replyModalOverlay" style="display: none;">
    <div class="reply-modal">
        <button class="reply-modal__close" id="replyModalClose">
            <i class="fas fa-times"></i>
        </button>

        <div class="reply-modal__icon">
            <i class="fas fa-reply"></i>
        </div>

        <h3 class="reply-modal__title">Reply to {{ $message->name }}</h3>

        <div class="reply-modal__recipient">
            <div class="reply-modal__recipient-row">
                <span class="reply-modal__recipient-label">To:</span>
                <span class="reply-modal__recipient-value">{{ $message->email }}</span>
            </div>
            <div class="reply-modal__recipient-row">
                <span class="reply-modal__recipient-label">Subject:</span>
                <span class="reply-modal__recipient-value">Re: {{ $message->subject }}</span>
            </div>
        </div>

        <div class="reply-modal__preview">
            <div class="reply-modal__preview-header">
                <i class="fas fa-quote-left"></i>
                Original Message
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

        <div class="reply-modal__note">
            <i class="fas fa-info-circle"></i>
            Your email client will open with a pre-filled reply template. Status will be updated to "Replied".
        </div>

        <div class="reply-modal__actions">
            <button class="btn btn--secondary" id="replyModalCancel">Cancel</button>
            <button class="btn btn--primary" id="replyModalConfirm">
                <i class="fas fa-envelope"></i> Open Email Client
            </button>
        </div>
    </div>
</div>

<style>
    /* ─── MESSAGE DETAIL ─── */
    .message-detail__card {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .message-detail__sender {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 28px 32px;
        background: linear-gradient(135deg, var(--bg) 0%, var(--surface) 100%);
        border-bottom: 2px solid var(--border);
    }

    .message-detail__avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--gold);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.4rem;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(166, 124, 78, 0.2);
    }

    .message-detail__sender-info h3 {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 4px 0;
    }

    .message-detail__sender-meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .message-detail__sender-meta a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .message-detail__sender-meta a:hover {
        color: var(--gold);
    }

    .message-detail__sender-meta .message-detail__sender-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .message-detail__body {
        padding: 32px;
    }

    .message-detail__subject {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }

    .message-detail__subject-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .message-detail__subject h4 {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .message-detail__content {
        color: var(--text);
        line-height: 1.9;
        font-size: 1rem;
        white-space: pre-wrap;
        background: var(--bg);
        padding: 20px 24px;
        border-radius: var(--radius);
        border-left: 3px solid var(--gold);
    }

    .message-detail__actions {
        display: flex;
        gap: 12px;
        padding: 20px 32px 32px;
        border-top: 1px solid var(--border);
        background: var(--bg);
        flex-wrap: wrap;
    }

    .message-detail__actions .btn {
        padding: 12px 32px;
        font-size: 0.9rem;
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
    }

    .reply-modal-overlay--visible {
        opacity: 1;
    }

    .reply-modal {
        background: var(--surface);
        border-radius: 24px;
        padding: 40px 36px 32px;
        max-width: 640px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        transform: scale(0.92) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
    }

    .reply-modal--visible {
        transform: scale(1) translateY(0);
    }

    .reply-modal__close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-muted);
        font-size: 1rem;
    }

    .reply-modal__close:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
        transform: rotate(90deg);
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
        margin-bottom: 20px;
    }

    .reply-modal__recipient {
        background: var(--bg);
        border-radius: var(--radius);
        padding: 14px 18px;
        margin-bottom: 20px;
        border: 1px solid var(--border);
    }

    .reply-modal__recipient-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
    }

    .reply-modal__recipient-row:not(:last-child) {
        border-bottom: 1px solid var(--border);
    }

    .reply-modal__recipient-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        min-width: 60px;
    }

    .reply-modal__recipient-value {
        font-size: 0.85rem;
        color: var(--text);
        font-weight: 500;
        word-break: break-all;
    }

    .reply-modal__preview {
        background: var(--bg);
        border-radius: var(--radius);
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
        padding: 10px 14px;
        background: #fff3cd;
        border-radius: var(--radius);
        color: #856404;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .reply-modal__note i {
        font-size: 1rem;
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

    /* ─── RESPONSIVE ─── */
    @media (max-width: 768px) {
        .message-detail__sender {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .message-detail__sender-meta {
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .message-detail__body {
            padding: 20px;
        }

        .message-detail__content {
            padding: 16px;
            font-size: 0.9rem;
        }

        .message-detail__actions {
            padding: 16px 20px 20px;
            flex-direction: column;
        }

        .message-detail__actions .btn {
            width: 100%;
            justify-content: center;
        }

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

        .reply-modal__recipient-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }

        .reply-modal__recipient-label {
            min-width: auto;
        }
    }

    @media (max-width: 420px) {
        .message-detail__sender {
            padding: 16px;
        }

        .message-detail__avatar {
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
        }

        .message-detail__sender-info h3 {
            font-size: 1rem;
        }

        .message-detail__body {
            padding: 16px;
        }

        .message-detail__subject h4 {
            font-size: 1.1rem;
        }

        .message-detail__content {
            padding: 12px;
            font-size: 0.85rem;
        }
    }
</style>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyButton = document.getElementById('replyButton');
        const modalOverlay = document.getElementById('replyModalOverlay');
        const modalClose = document.getElementById('replyModalClose');
        const modalCancel = document.getElementById('replyModalCancel');
        const modalConfirm = document.getElementById('replyModalConfirm');

        // ─── SHOW MODAL ───
        if (replyButton) {
            replyButton.addEventListener('click', function() {
                modalOverlay.style.display = 'flex';
                setTimeout(function() {
                    modalOverlay.classList.add('reply-modal-overlay--visible');
                    const modal = document.querySelector('.reply-modal');
                    if (modal) {
                        modal.classList.add('reply-modal--visible');
                    }
                }, 10);
            });
        }

        // ─── CLOSE MODAL ───
        function closeModal() {
            modalOverlay.classList.remove('reply-modal-overlay--visible');
            const modal = document.querySelector('.reply-modal');
            if (modal) {
                modal.classList.remove('reply-modal--visible');
            }
            setTimeout(function() {
                modalOverlay.style.display = 'none';
            }, 400);
        }

        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        if (modalCancel) {
            modalCancel.addEventListener('click', closeModal);
        }

        modalOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalOverlay.style.display === 'flex') {
                closeModal();
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
                        const badge = document.querySelector('.badge');
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

                    window.location.href = mailtoLink;

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
                    window.location.href = fallbackLink;
                    
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