@php
    $pendingBaptisms = App\Models\BaptismRequest::where('status', 'pending')->count();
    $unreadMessages = App\Models\ContactMessage::where('status', 'unread')->count();
    $pendingInvites = App\Models\InviteRequest::where('status', 'pending')->count();
    $pendingOrders = App\Models\Order::where('payment_status', 'pending')->count();
@endphp

<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <span>Admin</span>
        <br>
        {{ env('PROJECT_NAME', 'The Collective') }}
    </a>

    <nav class="admin-nav">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>

        {{-- Books --}}
        <a href="{{ route('admin.books.index') }}" 
           class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Books</span>
        </a>

        {{-- Events --}}
        <a href="{{ route('admin.events.index') }}" 
           class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
        </a>

        {{-- Orders --}}
        <a href="{{ route('admin.orders.index') }}" 
           class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
            @if($pendingOrders > 0)
                <span class="nav-badge">{{ $pendingOrders }}</span>
            @endif
        </a>

        {{-- Baptism Requests --}}
        <a href="{{ route('admin.baptisms') }}" 
           class="nav-item {{ request()->routeIs('admin.baptisms') ? 'active' : '' }}">
            <i class="fas fa-water"></i>
            <span>Baptism</span>
            @if($pendingBaptisms > 0)
                <span class="nav-badge">{{ $pendingBaptisms }}</span>
            @endif
        </a>

        {{-- Contact Messages --}}
        <a href="{{ route('admin.messages') }}" 
           class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i>
            <span>Messages</span>
            @if($unreadMessages > 0)
                <span class="nav-badge nav-badge--danger">{{ $unreadMessages }}</span>
            @endif
        </a>

        {{-- Invite Requests --}}
        <a href="{{ route('admin.invites') }}" 
           class="nav-item {{ request()->routeIs('admin.invites') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i>
            <span>Invites</span>
            @if($pendingInvites > 0)
                <span class="nav-badge">{{ $pendingInvites }}</span>
            @endif
        </a>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- ─── SYSTEM ─── --}}
        <a href="{{ route('admin.cache.index') }}" 
           class="nav-item {{ request()->routeIs('admin.cache.*') ? 'active' : '' }}">
            <i class="fas fa-database"></i>
            <span>Cache</span>
        </a>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- ─── EXPORTS (Collapsible) ─── --}}
        <div class="nav-item nav-item--toggle" id="exportsToggle">
            <i class="fas fa-file-export"></i>
            <span>Exports</span>
            <i class="fas fa-chevron-down nav-item__chevron"></i>
        </div>

        <div class="nav-submenu" id="exportsSubmenu">
            <a href="{{ route('admin.export.orders') }}" class="nav-item nav-item--sub">
                <i class="fas fa-file-csv"></i>
                <span>Export Orders</span>
            </a>
            <a href="{{ route('admin.export.registrations') }}" class="nav-item nav-item--sub">
                <i class="fas fa-file-csv"></i>
                <span>Export Registrations</span>
            </a>
            <a href="{{ route('admin.export.baptisms') }}" class="nav-item nav-item--sub">
                <i class="fas fa-file-csv"></i>
                <span>Export Baptisms</span>
            </a>
            <a href="{{ route('admin.export.messages') }}" class="nav-item nav-item--sub">
                <i class="fas fa-file-csv"></i>
                <span>Export Messages</span>
            </a>
        </div>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- ─── VIEW SITE  ─── --}}
        <a href="{{ route('home') }}" target="_blank" class="nav-item nav-item--view-site">
            <i class="fas fa-external-link-alt"></i>
            <span>View Site</span>
            <i class="fas fa-external-link-alt nav-item__external" style="font-size: 0.6rem; opacity: 0.4; margin-left: auto;"></i>
        </a>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- ─── CHANGE PASSWORD ─── --}}
        <a href="#" class="nav-item" id="changePasswordLink">
            <i class="fas fa-key"></i>
            <span>Change Password</span>
        </a>

        {{-- Divider --}}
        <div class="nav-divider"></div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('admin.logout') }}" class="nav-logout-form">
            @csrf
            <button type="submit" class="nav-item nav-item--logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</aside>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── EXPORTS TOGGLE ───
    const toggle = document.getElementById('exportsToggle');
    const submenu = document.getElementById('exportsSubmenu');

    if (toggle && submenu) {
        // ─── CHECK SESSION STATE ───
        const isOpen = sessionStorage.getItem('exports_open') === 'true';
        if (isOpen) {
            toggle.classList.add('nav-item--toggle--open');
            submenu.classList.add('nav-submenu--open');
            const chevron = toggle.querySelector('.nav-item__chevron');
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
            }
        }

        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isCurrentlyOpen = submenu.classList.contains('nav-submenu--open');
            const chevron = this.querySelector('.nav-item__chevron');

            if (isCurrentlyOpen) {
                submenu.classList.remove('nav-submenu--open');
                this.classList.remove('nav-item--toggle--open');
                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
                sessionStorage.setItem('exports_open', 'false');
            } else {
                submenu.classList.add('nav-submenu--open');
                this.classList.add('nav-item--toggle--open');
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
                sessionStorage.setItem('exports_open', 'true');
            }
        });

        // ─── CLOSE ON CLICK OUTSIDE ───
        document.addEventListener('click', function(e) {
            if (!toggle.contains(e.target) && !submenu.contains(e.target)) {
                submenu.classList.remove('nav-submenu--open');
                toggle.classList.remove('nav-item--toggle--open');
                const chevron = toggle.querySelector('.nav-item__chevron');
                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
                sessionStorage.setItem('exports_open', 'false');
            }
        });
    }
});
</script>
@endpush