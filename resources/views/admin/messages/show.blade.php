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

        <div class="message-detail__actions">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn--primary">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="btn btn--success" style="background: #25D366; color: #fff;">
                <i class="fab fa-whatsapp"></i> Reply via WhatsApp
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/messages.css') }}">
@endpush