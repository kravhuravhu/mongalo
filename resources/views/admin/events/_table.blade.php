@forelse($events as $event)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="events-index__title">
                <strong>{{ $event->title }}</strong>
                @if($event->description)
                    <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">
                        {{ Str::limit($event->description, 60) }}
                    </span>
                @endif
            </div>
        </td>
        <td>
            <div class="events-index__date">
                <span class="events-index__date-day">{{ $event->date->format('M d, Y') }}</span>
                <span class="events-index__date-time">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
            </div>
        </td>
        <td>
            <span class="events-index__location">
                <i class="fas fa-map-marker-alt" style="color: var(--gold); font-size: 0.7rem;"></i>
                {{ $event->location }}
            </span>
        </td>
        <td>
            <span class="events-index__registrations">
                {{ $event->registrations()->count() }}
                @if($event->capacity)
                    / {{ $event->capacity }}
                @endif
            </span>
        </td>
        <td>
            @if($event->is_free)
                <span class="badge badge-free">Free</span>
            @else
                <span class="events-index__price">R{{ number_format($event->price ?? 0, 2) }}</span>
            @endif
        </td>
        <td>
            @if($event->is_past)
                <span class="badge badge-completed">Past</span>
            @else
                <span class="badge badge-contacted">Upcoming</span>
            @endif
        </td>
        <td>
            <div class="events-index__actions">
                {{-- Pass the ENTIRE event object --}}
                <a href="{{ route('admin.events.registrations', $event) }}" class="btn btn--secondary btn--sm" title="View Registrations">
                    <i class="fas fa-users"></i>
                </a>
                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn--secondary btn--sm" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="delete-confirm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--danger btn--sm" title="Delete" 
                            data-title="{{ $event->title }}" 
                            data-type="Event">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
            <i class="fas fa-calendar-alt" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
            No events found.
        </td>
    </tr>
@endforelse