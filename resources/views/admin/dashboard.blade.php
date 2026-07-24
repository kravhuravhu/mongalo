@extends('admin.layouts.admin')

@section('title', 'Dashboard · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')

<div class="stats-grid">
    {{-- Total Books --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_books'] }}</div>
        <div class="stat-label"><i class="fas fa-book"></i> Total Books</div>
    </div>

    {{-- Total Events --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_events'] }}</div>
        <div class="stat-label"><i class="fas fa-calendar-alt"></i> Total Events</div>
    </div>

    {{-- Event Registrations --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_registrations'] }}</div>
        <div class="stat-label"><i class="fas fa-users"></i> Registrations</div>
    </div>

    {{-- Baptism Requests --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_baptisms'] }}</div>
        <div class="stat-label"><i class="fas fa-water"></i> Baptism Requests</div>
    </div>

    {{-- Contact Messages --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_messages'] }}</div>
        <div class="stat-label"><i class="fas fa-envelope"></i> Messages</div>
    </div>

    {{-- Invite Requests --}}
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_invites'] }}</div>
        <div class="stat-label"><i class="fas fa-handshake"></i> Invite Requests</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 8px;">

    {{-- Pending Items --}}
    <div class="table-wrap">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 0.9rem; font-weight: 600;">Pending Items</h3>
        </div>
        <table>
            <tbody>
                <tr>
                    <td><i class="fas fa-water" style="color: var(--gold); width: 20px;"></i> Baptism Requests</td>
                    <td><span class="badge badge-pending">{{ $stats['pending_baptisms'] }}</span></td>
                </tr>
                <tr>
                    <td><i class="fas fa-envelope" style="color: var(--gold); width: 20px;"></i> Unread Messages</td>
                    <td><span class="badge badge-unread">{{ $stats['unread_messages'] }}</span></td>
                </tr>
                <tr>
                    <td><i class="fas fa-handshake" style="color: var(--gold); width: 20px;"></i> Pending Invites</td>
                    <td><span class="badge badge-pending">{{ $stats['pending_invites'] }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Recent Events --}}
    <div class="table-wrap">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 0.9rem; font-weight: 600;">Recent Events</h3>
        </div>
        <table>
            <tbody>
                @forelse($recentEvents as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->title }}</strong>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">
                                {{ $event->date->format('M d, Y') }} · {{ $event->location }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <span class="badge {{ $event->is_past ? 'badge-completed' : 'badge-contacted' }}">
                                {{ $event->is_past ? 'Past' : 'Upcoming' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="color: var(--text-muted);">No events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Recent Registrations --}}
<div class="table-wrap" style="margin-top: 24px;">
    <div style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 0.9rem; font-weight: 600;">Recent Registrations</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Event</th>
                <th>Registration ID</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentRegistrations as $reg)
                <tr>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->event->title ?? 'N/A' }}</td>
                    <td><code>{{ $reg->registration_id }}</code></td>
                    <td>{{ $reg->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="color: var(--text-muted);">No registrations yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection