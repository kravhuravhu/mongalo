<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\BaptismRequestController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\InviteRequestController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\ExportController;

// Admin routes | dev & prod
$adminRoutes = function () {
    // ─── AUTHENTICATION (Rate Limited) ───
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('rate.limit:login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // ─── PROTECTED ROUTES ───
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // ─── BOOKS MANAGEMENT ───
        Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

        // ─── EVENTS MANAGEMENT ───
        Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
        Route::get('/events/{event}/registrations', [EventController::class, 'registrations'])->name('admin.events.registrations');

        // ─── REGISTRATION MANAGEMENT ───
        Route::put('/events/registrations/{registration}', [EventController::class, 'updateRegistration'])->name('admin.events.registrations.update');
        Route::post('/events/registrations/{registration}/resend', [EventController::class, 'resendConfirmation'])->name('admin.events.registrations.resend');

        // ─── BAPTISM REQUESTS ───
        Route::get('/baptisms', [BaptismRequestController::class, 'index'])->name('admin.baptisms');
        Route::put('/baptisms/{baptismRequest}', [BaptismRequestController::class, 'update'])->name('admin.baptisms.update');

        // ─── CONTACT MESSAGES ───
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages');
        Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
        Route::put('/messages/{message}', [ContactMessageController::class, 'update'])->name('admin.messages.update');
        Route::post('/messages/{message}/mark-replied', [ContactMessageController::class, 'markReplied'])->name('admin.messages.mark-replied');
        Route::get('/messages/{message}/reply-template', [ContactMessageController::class, 'getReplyTemplate'])->name('admin.messages.reply-template');

        // ─── INVITE REQUESTS ───
        Route::get('/invites', [InviteRequestController::class, 'index'])->name('admin.invites');
        Route::put('/invites/{invite}', [InviteRequestController::class, 'update'])->name('admin.invites.update');

        // ─── ORDERS MANAGEMENT ───
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

        // ─── CACHE MANAGEMENT ───
        Route::get('/cache', [CacheController::class, 'index'])->name('admin.cache.index');
        Route::get('/cache/clear', [CacheController::class, 'clear'])->name('admin.cache.clear');
        Route::get('/cache/warm', [CacheController::class, 'warm'])->name('admin.cache.warm');
        Route::get('/cache/status', [CacheController::class, 'status'])->name('admin.cache.status');
        Route::get('/cache/clear/{type}', [CacheController::class, 'clearType'])->name('admin.cache.clear.type');

        // ─── EXPORTS ───
        Route::get('/export/orders', [ExportController::class, 'orders'])->name('admin.export.orders');
        Route::get('/export/registrations', [ExportController::class, 'registrations'])->name('admin.export.registrations');
        Route::get('/export/baptisms', [ExportController::class, 'baptisms'])->name('admin.export.baptisms');
        Route::get('/export/messages', [ExportController::class, 'messages'])->name('admin.export.messages');

        // ─── ADMIN PASSWORD CHANGE ───
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('admin.change-password');
    });
};

// Dev: Path-based
if (app()->environment('local')) {
    Route::prefix('admin')->group($adminRoutes);
} else {
    // Prod: Subdomain-based
    Route::domain(config('app.admin_domain'))->group($adminRoutes);
}