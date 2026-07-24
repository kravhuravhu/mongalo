<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\BaptismRequest;
use App\Models\ContactMessage;
use App\Models\InviteRequest;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('admin.components.sidebar', function ($view) {
            $view->with([
                'pendingBaptisms' => BaptismRequest::where('status', 'pending')->count(),
                'unreadMessages' => ContactMessage::where('status', 'unread')->count(),
                'pendingInvites' => InviteRequest::where('status', 'pending')->count(),
            ]);
        });
    }
}