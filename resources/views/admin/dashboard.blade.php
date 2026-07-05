@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_books'] }}</div>
        <div class="stat-label">Books</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_events'] }}</div>
        <div class="stat-label">Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_registrations'] }}</div>
        <div class="stat-label">Registrations</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_baptisms'] }}</div>
        <div class="stat-label">Baptism Requests</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_messages'] }}</div>
        <div class="stat-label">Messages</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $stats['total_invites'] }}</div>
        <div class="stat-label">Invite Requests</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div>
        <h3 style="margin-bottom:12px;">Recent Events</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Registrations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEvents as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->date->format('M d, Y') }}</td>
                            <td>{{ $event->registrations()->count() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--text-muted);">No events yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h3 style="margin-bottom:12px;">Recent Registrations</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Event</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                        <tr>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->event->title ?? 'N/A' }}</td>
                            <td>{{ $reg->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--text-muted);">No registrations yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection