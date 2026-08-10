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

        {{-- ─── REPLY SECTION ─── --}}
        <div class="message-detail__reply-section">
            <h4 style="font-family: var(--font-serif); font-weight: 700; font-size: 1rem; margin-bottom: 12px; color: var(--text);">
                <i class="fas fa-reply" style="color: var(--gold);"></i> Reply to {{ $message->name }}
            </h4>

            {{-- ─── ORIGINAL MESSAGE CONTEXT ─── --}}
            <div class="message-detail__reply-context">
                <div class="message-detail__reply-context-header">
                    <span class="message-detail__reply-context-from">
                        <i class="fas fa-user"></i> From: {{ $message->name }}
                    </span>
                    <span class="message-detail__reply-context-date">
                        <i class="fas fa-clock"></i> {{ $message->created_at->format('F d, Y g:i A') }}
                    </span>
                </div>
                <div class="message-detail__reply-context-body">
                    {{ $message->message }}
                </div>
            </div>

            {{-- ─── REPLY FORM ─── --}}
            <form method="POST" action="mailto:{{ $message->email }}" class="message-detail__reply-form" id="replyForm">
                @csrf
                <input type="hidden" name="to" value="{{ $message->email }}">
                <input type="hidden" name="reply_to" value="{{ $message->email }}">

                <div class="message-detail__reply-field">
                    <label for="reply_to_display">To</label>
                    <input type="text" id="reply_to_display" value="{{ $message->name }} <{{ $message->email }}>" readonly style="background: var(--bg); cursor: default;">
                </div>

                <div class="message-detail__reply-field">
                    <label for="reply_subject">Subject</label>
                    <input type="text" name="subject" id="reply_subject" value="RE: {{ $message->subject }}" required>
                </div>

                <div class="message-detail__reply-field">
                    <label for="reply_message">Message</label>
                    <textarea name="message" id="reply_message" rows="6" placeholder="Write your reply here..." required></textarea>
                </div>

                <div class="message-detail__reply-actions">
                    <button type="submit" class="btn btn--primary" id="replySendBtn">
                        <i class="fas fa-paper-plane"></i> 
                        <span id="replyBtnText">Send Reply</span>
                        <span id="replyBtnLoader" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i> Sending...
                        </span>
                    </button>
                    <a href="{{ route('admin.messages') }}" class="btn btn--secondary">Cancel</a>
                </div>

                <div id="replyMessage" style="margin-top: 12px;"></div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/messages.css') }}">
    <style>
        /* ─── REPLY SECTION ─── */
        .message-detail__reply-section {
            padding: 24px 32px 32px;
            border-top: 1px solid var(--border);
            background: var(--bg);
        }

        .message-detail__reply-context {
            background: #fff;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            padding: 16px 20px;
            margin-bottom: 20px;
            border-left: 3px solid var(--gold);
        }

        .message-detail__reply-context-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 10px;
        }

        .message-detail__reply-context-from {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
        }

        .message-detail__reply-context-from i {
            color: var(--gold);
            margin-right: 4px;
        }

        .message-detail__reply-context-date {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .message-detail__reply-context-date i {
            color: var(--gold);
            margin-right: 4px;
        }

        .message-detail__reply-context-body {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.7;
            padding: 4px 0;
            max-height: 120px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .message-detail__reply-context-body::-webkit-scrollbar {
            width: 4px;
        }

        .message-detail__reply-context-body::-webkit-scrollbar-thumb {
            background: var(--gold-dim);
            border-radius: 4px;
        }

        .message-detail__reply-field {
            margin-bottom: 16px;
        }

        .message-detail__reply-field label {
            display: block;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text);
            margin-bottom: 4px;
        }

        .message-detail__reply-field input,
        .message-detail__reply-field textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #fff;
            color: var(--text);
        }

        .message-detail__reply-field input:focus,
        .message-detail__reply-field textarea:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-dim);
        }

        .message-detail__reply-field input:read-only {
            background: var(--bg);
            cursor: default;
        }

        .message-detail__reply-field textarea {
            resize: vertical;
            min-height: 100px;
        }

        .message-detail__reply-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        .message-detail__reply-actions .btn {
            padding: 10px 24px;
        }

        @media (max-width: 540px) {
            .message-detail__reply-section {
                padding: 16px 16px 20px;
            }

            .message-detail__reply-context-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .message-detail__reply-actions {
                flex-direction: column;
            }

            .message-detail__reply-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replyForm = document.getElementById('replyForm');
        const sendBtn = document.getElementById('replySendBtn');
        const btnText = document.getElementById('replyBtnText');
        const btnLoader = document.getElementById('replyBtnLoader');
        const messageDiv = document.getElementById('replyMessage');

        if (replyForm) {
            replyForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // ─── SHOW LOADING ───
                sendBtn.disabled = true;
                btnText.style.display = 'none';
                btnLoader.style.display = 'inline';
                messageDiv.innerHTML = '';

                // ─── GET FORM DATA ───
                const subject = document.getElementById('reply_subject').value;
                const message = document.getElementById('reply_message').value;
                const to = document.querySelector('input[name="to"]').value;

                // ─── BUILD MAILTO LINK ───
                const mailtoLink = 'mailto:' + to +
                    '?subject=' + encodeURIComponent(subject) +
                    '&body=' + encodeURIComponent(message);

                // ─── OPEN EMAIL CLIENT ───
                window.location.href = mailtoLink;

                // ─── SHOW SUCCESS MESSAGE ───
                messageDiv.innerHTML = `
                    <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 10px; border-left: 4px solid #28a745;">
                        <i class="fas fa-check-circle"></i> 
                        Your email client has been opened. Please send the reply to complete.
                        <br>
                        <small style="display: block; margin-top: 6px; color: #155724; opacity: 0.7;">
                            <i class="fas fa-info-circle"></i> 
                            If your email client didn't open, please manually send to: <strong>${to}</strong>
                        </small>
                    </div>
                `;

                // ─── UPDATE STATUS TO REPLIED ───
                const statusSelect = document.querySelector('.message-detail__status-select');
                if (statusSelect) {
                    statusSelect.value = 'replied';
                    // ─── SUBMIT STATUS UPDATE ───
                    const statusForm = statusSelect.closest('.status-update-form');
                    if (statusForm) {
                        statusForm.submit();
                    }
                }

                // ─── RESET BUTTON ───
                sendBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoader.style.display = 'none';

                // ─── DISABLE FORM AFTER SEND ───
                const textarea = document.getElementById('reply_message');
                if (textarea) {
                    textarea.disabled = true;
                }
                const subjectInput = document.getElementById('reply_subject');
                if (subjectInput) {
                    subjectInput.disabled = true;
                }
                sendBtn.innerHTML = '<i class="fas fa-check"></i> Reply Sent';
                sendBtn.style.opacity = '0.7';
                sendBtn.style.cursor = 'default';
            });
        }
    });
</script>
@endpush