@forelse($messages as $message)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="messages-index__from">
                <strong>{{ $message->name }}</strong>
                <a href="mailto:{{ $message->email }}" style="color: var(--muted); text-decoration: none; font-size: 0.8rem; display: block;">
                    {{ $message->email }}
                </a>
                @if($message->phone)
                    <span style="font-size: 0.75rem; color: var(--muted); display: inline-block; margin-top: 2px;">
                        <i class="fas fa-phone"></i> {{ $message->phone }}
                    </span>
                @endif
            </div>
        </td>
        <td>
            <span class="messages-index__subject">{{ $message->subject }}</span>
        </td>
        <td>
            <span class="messages-index__preview">
                {{ Str::limit($message->message, 60) }}
            </span>
        </td>
        <td>
            <span class="badge badge-{{ $message->status }}">
                {{ ucfirst($message->status) }}
            </span>
        </td>
        <td>
            <span style="font-size: 0.8rem; color: var(--muted);">
                {{ $message->created_at->diffForHumans() }}
            </span>
        </td>
        <td>
            <div class="messages-index__actions">
                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn--primary btn--sm" title="View">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" style="text-align: center; color: var(--muted); padding: 48px;">
            <i class="fas fa-envelope" style="font-size: 2rem; display: block; margin-bottom: 16px; opacity: 0.3;"></i>
            No messages found.
        </td>
    </tr>
@endforelse