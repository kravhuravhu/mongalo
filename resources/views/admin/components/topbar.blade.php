<div class="admin-topbar">
    <div class="admin-topbar-left">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <span class="admin-breadcrumb">@yield('breadcrumb', '')</span>
    </div>

    <div class="admin-topbar-right">
        {{-- Theme Toggle --}}
        <button class="admin-theme-toggle" id="adminThemeToggle" aria-label="Toggle theme">
            <i class="fas fa-sun admin-theme-toggle__sun"></i>
            <i class="fas fa-moon admin-theme-toggle__moon"></i>
        </button>

        {{-- User --}}
        <div class="admin-user">
            <span class="admin-user-name">{{ session('admin_name') ?? 'Admin' }}</span>
        </div>
    </div>
</div>