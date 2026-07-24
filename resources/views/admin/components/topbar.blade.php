<div class="admin-topbar">
    <div class="admin-topbar-left">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <span class="admin-breadcrumb">@yield('breadcrumb', '')</span>
    </div>

    <div class="admin-topbar-right">
        <div class="admin-user">
            <span class="admin-user-name">{{ session('admin_name') ?? 'Admin' }}</span>
            <span class="admin-user-avatar">
                {{ strtoupper(substr(session('admin_name') ?? 'A', 0, 1)) }}
            </span>
        </div>
    </div>
</div>