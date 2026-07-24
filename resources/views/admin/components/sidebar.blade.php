@php
    $pendingBaptisms = App\Models\BaptismRequest::where('status', 'pending')->count();
    $unreadMessages = App\Models\ContactMessage::where('status', 'unread')->count();
    $pendingInvites = App\Models\InviteRequest::where('status', 'pending')->count();
@endphp

<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        {{ env('PROJECT_NAME', 'The Collective') }}
        <span>Admin</span>
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