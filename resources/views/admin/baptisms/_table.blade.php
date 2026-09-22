@forelse($baptisms as $baptism)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <strong>{{ $baptism->name }}</strong>
        </td>
        <td>
            <div class="baptisms-index__contact">
                <a href="mailto:{{ $baptism->email }}" style="color: var(--gold); text-decoration: none; font-size: 0.85rem;">
                    {{ $baptism->email }}
                </a>
                <a href="tel:{{ $baptism->phone }}" style="color: var(--muted); text-decoration: none; font-size: 0.8rem; display: block;">
                    {{ $baptism->phone }}
                </a>
            </div>
        </td>
        <td>
            <span class="baptisms-index__location">
                <i class="fas fa-map-marker-alt"></i>
                {{ $baptism->location }}
            </span>
        </td>
        <td>
            @if($baptism->preferred_date)
                <span style="font-size: 0.85rem;">
                    {{ $baptism->preferred_date->format('M d, Y') }}
                </span>
            @else
                <span style="color: var(--muted); font-size: 0.8rem;">Not specified</span>
            @endif
        </td>
        <td>
            <span class="badge badge-{{ $baptism->status }}">
                {{ ucfirst($baptism->status) }}
            </span>
        </td>
        <td>
            <div class="baptisms-index__actions">
                <form method="POST" action="{{ route('admin.baptisms.update', $baptism) }}" class="status-update-form">
                    @csrf
                    @method('PUT')
                    <select name="status" class="baptisms-index__status-select" onchange="this.form.submit()">
                        <option value="pending" {{ $baptism->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="contacted" {{ $baptism->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="completed" {{ $baptism->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </form>
                <a href="mailto:{{ $baptism->email }}" class="btn btn--secondary btn--sm" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="tel:{{ $baptism->phone }}" class="btn btn--secondary btn--sm" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" style="text-align: center; color: var(--muted); padding: 48px;">
            <i class="fas fa-water" style="font-size: 2rem; display: block; margin-bottom: 16px; opacity: 0.3;"></i>
            No baptism requests found.
        </td>
    </tr>
@endforelse