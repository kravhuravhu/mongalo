@extends('admin.layouts.admin')

@section('title', 'Registrations · ' . $event->title . ' · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Registrations ' . $event->title)
@section('breadcrumb', 'Events / Registrations')

@section('content')

<div class="events-registrations">
    {{-- ─── HEADER ─── --}}
    <div class="events-registrations__header">
        <a href="{{ route('admin.events.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
        <div class="events-registrations__stats">
            <span class="events-registrations__stat">
                <i class="fas fa-users"></i> 
                {{ $registrations->count() }} 
                @if($event->capacity)
                    / {{ $event->capacity }}
                @endif
                registrations
            </span>
            <span class="events-registrations__stat">
                <i class="fas fa-calendar-alt"></i>
                @if($event->date)
                    {{ $event->date->format('M d, Y') }}
                @else
                    <span style="color: var(--text-muted);">Date TBD</span>
                @endif
            </span>
            <span class="events-registrations__stat">
                <i class="fas fa-clock"></i>
                @if($event->time)
                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                @else
                    <span style="color: var(--text-muted);">Time TBD</span>
                @endif
            </span>
            <span class="events-registrations__stat">
                <i class="fas fa-map-marker-alt"></i> 
                {{ $event->location ?? 'Location TBD' }}
            </span>
            <span class="events-registrations__stat">
                <i class="fas fa-tag"></i>
                @if($event->is_free)
                    Free Event
                @else
                    R{{ number_format($event->price ?? 0, 2) }} per person
                @endif
            </span>
            <a href="{{ route('admin.export.registrations', ['event_id' => $event->id]) }}" class="btn btn--success btn--sm">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- ─── DEBUG: Show if registrations exist ─── --}}
    @php
        $count = $registrations->count();
    @endphp
    <div style="background: #e8f0fe; color: #1a5a8c; padding: 10px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem; border-left: 3px solid #1a5a8c; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-info-circle" style="font-size: 1.1rem;"></i>
        <span>Found <strong>{{ $count }}</strong> registration(s) for this event.</span>
    </div>

    {{-- ─── REGISTRATIONS TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registration ID</th>
                    <th>Payment Status</th>
                    <th>Registered At</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $registration->name }}</strong>
                        </td>
                        <td>
                            <a href="mailto:{{ $registration->email }}" style="color: var(--gold); text-decoration: none;">
                                {{ $registration->email }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $registration->phone }}" style="color: var(--text-muted); text-decoration: none;">
                                {{ $registration->phone }}
                            </a>
                        </td>
                        <td>
                            <code style="background: var(--bg); padding: 2px 8px; border-radius: 4px; font-size: 0.7rem;">
                                {{ $registration->registration_id }}
                            </code>
                        </td>
                        <td>
                            <span class="badge badge-{{ $registration->payment_status ?? 'pending' }}">
                                {{ ucfirst($registration->payment_status ?? 'pending') }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; color: var(--text-muted);">
                                {{ $registration->created_at->format('M d, Y g:i A') }}
                            </span>
                        </td>
                        <td>
                            <div class="registrations-actions">
                                {{-- ─── MARK AS PAID ─── --}}
                                @if($registration->payment_status === 'pending' && !$event->is_free)
                                    <form method="POST" action="{{ route('admin.events.registrations.update', $registration) }}" class="delete-confirm inline-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="btn btn--success btn--sm" 
                                                data-title="{{ $registration->name }}" 
                                                data-type="Registration">
                                            <i class="fas fa-check-circle"></i>
                                            <span class="btn-label">Mark Paid</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- ─── MARK AS FREE (if event is free) ─── --}}
                                @if($event->is_free && $registration->payment_status !== 'free')
                                    <form method="POST" action="{{ route('admin.events.registrations.update', $registration) }}" class="delete-confirm inline-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="free">
                                        <button type="submit" class="btn btn--secondary btn--sm" 
                                                data-title="{{ $registration->name }}" 
                                                data-type="Registration">
                                            <i class="fas fa-gift"></i>
                                            <span class="btn-label">Mark Free</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- ─── RESEND EMAIL ─── --}}
                                @if($registration->payment_status === 'pending' || $registration->payment_status === 'free')
                                    <form method="POST" action="{{ route('admin.events.registrations.resend', $registration) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn btn--secondary btn--sm" 
                                                title="Resend confirmation email to {{ $registration->email }}">
                                            <i class="fas fa-envelope"></i>
                                            <span class="btn-label">Resend</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-users" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No registrations for this event yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ─── EXPORT OPTIONS ─── --}}
    @if($registrations->count() > 0)
        <div class="events-registrations__export">
            <span class="events-registrations__export-label">
                <i class="fas fa-download"></i> Export:
            </span>
            <a href="{{ route('admin.export.registrations') }}" class="btn btn--secondary btn--sm">
                <i class="fas fa-file-csv"></i> CSV
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/events.css') }}">
    <style>
        .registrations-actions {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }
        .registrations-actions .inline-form {
            display: inline;
        }
        .registrations-actions .btn--sm {
            padding: 4px 10px;
            font-size: 0.65rem;
            white-space: nowrap;
        }
        .registrations-actions .btn--sm .btn-label {
            display: inline;
        }
        .registrations-actions .btn--success {
            background: #28a745;
            color: #fff;
        }
        .registrations-actions .btn--success:hover {
            background: #218838;
        }
        @media (max-width: 640px) {
            .registrations-actions .btn--sm .btn-label {
                display: none;
            }
        }
    </style>
@endpush