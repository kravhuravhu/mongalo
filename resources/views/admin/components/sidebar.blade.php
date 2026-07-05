<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="logo">The <span>Collective</span></a>

    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-simple"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.books.index') }}" class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> <span>Books</span>
        </a>
        <a href="{{ route('admin.events.index') }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="fas fa-calendar"></i> <span>Events</span>
        </a>
        <a href="{{ route('admin.baptisms') }}" class="nav-item {{ request()->routeIs('admin.baptisms') ? 'active' : '' }}">
            <i class="fas fa-water"></i> <span>Baptisms</span>
        </a>
        <a href="{{ route('admin.messages') }}" class="nav-item {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> <span>Messages</span>
        </a>
        <a href="{{ route('admin.invites') }}" class="nav-item {{ request()->routeIs('admin.invites') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i> <span>Invites</span>
        </a>
    </nav>

    <div style="margin-top:auto;padding-top:20px;border-top:1px solid var(--border);">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="background:none;border:none;width:100%;cursor:pointer;font-family:var(--font);">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </button>
        </form>
    </div>
</aside>