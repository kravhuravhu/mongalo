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
        </div>
    </div>

    {{-- ─── show if registrations exist ─── --}}
    @if($registrations->count() > 0)
        <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.85rem;">
            <i class="fas fa-check-circle"></i> Found {{ $registrations->count() }} registration(s) for this event.
        </div>
    @endif

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
                            <span style="font-size: 0.85rem; color: var(--text-muted);">
                                {{ $registration->created_at->format('M d, Y g:i A') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
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
            <a href="#" class="btn btn--secondary btn--sm">
                <i class="fas fa-file-excel"></i> Excel
            </a>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/events.css') }}">
@endpush