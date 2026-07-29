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
        </div>
    </div>

    {{-- ─── DEBUG: Show if registrations exist ─── --}}
    @php
        $count = $registrations->count();
    @endphp
    <div style="background: #e8f0fe; color: #1a5a8c; padding: 10px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem; border-left: 3px solid #1a5a8c; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-info-circle" style="font-size: 1.1rem;"></i>
        <span>Found <strong>{{ $count }}</strong> registration(s) for this event.</span>
        @if($count > 0)
            <span style="background: #d4edda; color: #155724; padding: 2px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600;">
                <i class="fas fa-check-circle"></i> Data loaded
            </span>
        @endif
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
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
            <a href="#" class="btn btn--secondary btn--sm">
                <i class="fas fa-file-csv"></i> CSV
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/events.css') }}">
@endpush