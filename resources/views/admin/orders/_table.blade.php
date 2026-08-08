@forelse($orders as $order)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <span style="font-family: monospace; font-weight: 600; font-size: 0.85rem;">
                {{ $order->order_number }}
            </span>
        </td>
        <td>
            <strong>{{ $order->book->title ?? 'N/A' }}</strong>
        </td>
        <td>
            <div class="orders-index__buyer">
                <strong>{{ $order->buyer_name }}</strong>
                <a href="mailto:{{ $order->buyer_email }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.8rem; display: block;">
                    {{ $order->buyer_email }}
                </a>
                @if($order->buyer_phone)
                    <a href="tel:{{ $order->buyer_phone }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.75rem;">
                        <i class="fas fa-phone"></i> {{ $order->buyer_phone }}
                    </a>
                @endif
            </div>
        </td>
        <td>
            <span style="font-weight: 700; color: var(--gold);">
                R{{ number_format($order->amount, 2) }}
            </span>
        </td>
        <td>
            <span class="badge badge-{{ $order->payment_status }}">
                {{ ucfirst($order->payment_status) }}
            </span>
        </td>
        <td>
            <span style="font-size: 0.8rem; color: var(--text-muted);">
                {{ $order->created_at->format('M d, Y g:i A') }}
            </span>
        </td>
        <td>
            <div class="orders-index__actions">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn--primary btn--sm" title="View">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
            <i class="fas fa-shopping-cart" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
            No orders found.
        </td>
    </tr>
@endforelse