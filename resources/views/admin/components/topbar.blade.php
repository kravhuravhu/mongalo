<div class="admin-topbar">
    <h1>@yield('title', 'Dashboard')</h1>
    <div class="admin-user">
        <span>{{ session('admin_name', 'Admin') }}</span>
        <div class="avatar">{{ substr(session('admin_name', 'A'), 0, 1) }}</div>
    </div>
</div>