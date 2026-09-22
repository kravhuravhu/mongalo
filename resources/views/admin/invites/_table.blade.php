@forelse($invites as $invite)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="invites-index__requester">
                <strong>{{ $invite->name }}</strong>
                <a href="mailto:{{ $invite->email }}" style="color: var(--muted); text-decoration: none; font-size: 0.8rem; display: block;">
                    {{ $invite->email }}
                </a>
                <a href="tel:{{ $invite->phone }}" style="color: var(--muted); text-decoration: none; font-size: 0.75rem;">
                    <i class="fas fa-phone"></i> {{ $invite->phone }}
                </a>
            </div>
        </td>
        <td>
            <span class="invites-index__event">{{ $invite->event_name }}</span>
            @if($invite->message)
                <span style="display: block; font-size: 0.75rem; color: var(--muted); margin-top: 2px;">
                    {{ Str::limit($invite->message, 40) }}
                </span>
            @endif
        </td>
        <td>
            <div class="invites-index__date">
                <span>{{ $invite->event_date->format('M d, Y') }}</span>
                <span class="invites-index__date-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $invite->location }}
                </span>
            </div>
        </td>
        <td>
            @if($invite->expected_attendance)
                <span class="invites-index__attendance">
                    <i class="fas fa-users"></i>
                    {{ $invite->expected_attendance }}
                </span>
            @else
                <span style="color: var(--muted); font-size: 0.8rem;">Not specified</span>
            @endif
        </td>
        <td>
            <span class="badge badge-{{ $invite->status }}">
                {{ ucfirst($invite->status) }}
            </span>
        </td>
        <td>
            <div class="invites-index__actions">
                <form method="POST" action="{{ route('admin.invites.update', $invite) }}" class="status-update-form">
                    @csrf
                    @method('PUT')
                    <select name="status" class="invites-index__status-select" onchange="this.form.submit()">
                        <option value="pending" {{ $invite->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="contacted" {{ $invite->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="confirmed" {{ $invite->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    </select>
                </form>
                <a href="mailto:{{ $invite->email }}" class="btn btn--secondary btn--sm" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="tel:{{ $invite->phone }}" class="btn btn--secondary btn--sm" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" style="text-align: center; color: var(--muted); padding: 48px;">
            <i class="fas fa-handshake" style="font-size: 2rem; display: block; margin-bottom: 16px; opacity: 0.3;"></i>
            No invite requests found.
        </td>
    </tr>
@endforelse