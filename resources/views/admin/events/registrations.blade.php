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
                    <span style="color: var(--muted);">Date TBD</span>
                @endif
            </span>
            <span class="events-registrations__stat">
                <i class="fas fa-clock"></i>
                @if($event->time)
                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                @else
                    <span style="color: var(--muted);">Time TBD</span>
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

    {{-- ─── INFO BANNER ─── --}}
    <div class="events-registrations__debug">
        <i class="fas fa-info-circle"></i>
        <span>Found <strong>{{ $registrations->count() }}</strong> registration(s) for this event.</span>
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
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $registration->name }}</strong></td>
                        <td>
                            <a href="mailto:{{ $registration->email }}" style="color: var(--gold); text-decoration: none;">
                                {{ $registration->email }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $registration->phone }}" style="color: var(--muted); text-decoration: none;">
                                {{ $registration->phone }}
                            </a>
                        </td>
                        <td>
                            <code>{{ $registration->registration_id }}</code>
                        </td>
                        <td>
                            <span class="badge badge-{{ $registration->payment_status ?? 'pending' }}">
                                {{ ucfirst($registration->payment_status ?? 'pending') }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.85rem; color: var(--muted);">
                                {{ $registration->created_at->format('M d, Y g:i A') }}
                            </span>
                        </td>
                        <td>
                            <div class="registrations-actions">
                                {{-- ─── MARK AS PAID ─── --}}
                                @if($registration->payment_status === 'pending' && !$event->is_free)
                                    <form method="POST" action="{{ route('admin.events.registrations.update', $registration) }}" class="inline-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="btn btn--success btn--sm" title="Mark as Paid">
                                            <i class="fas fa-check-circle"></i>
                                            <span class="btn-label">Mark Paid</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- ─── MARK AS FREE ─── --}}
                                @if($event->is_free && $registration->payment_status !== 'free')
                                    <form method="POST" action="{{ route('admin.events.registrations.update', $registration) }}" class="inline-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="free">
                                        <button type="submit" class="btn btn--secondary btn--sm" title="Mark as Free">
                                            <i class="fas fa-gift"></i>
                                            <span class="btn-label">Mark Free</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- ─── RESEND EMAIL ─── --}}
                                @if($registration->payment_status === 'pending' || $registration->payment_status === 'free')
                                    <form method="POST" action="{{ route('admin.events.registrations.resend', $registration) }}" class="inline-form">
                                        @csrf
                                        <button type="submit" class="btn btn--secondary btn--sm" title="Resend email to {{ $registration->email }}">
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
                        <td colspan="8" style="text-align: center; color: var(--muted); padding: 48px;">
                            <i class="fas fa-users" style="font-size: 2rem; display: block; margin-bottom: 16px; opacity: 0.3;"></i>
                            No registrations for this event yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ─── EXPORT ─── --}}
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
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/events.css') }}">
@endpush