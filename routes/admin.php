<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\BaptismRequestController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\InviteRequestController;

// Admin routes | dev & prod
$adminRoutes = function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Protected Routes
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Books Management
        Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
        Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

        // Events Management
        Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
        Route::get('/events/{id}/registrations', [EventController::class, 'registrations'])->name('admin.events.registrations');

        // Baptism Requests
        Route::get('/baptisms', [BaptismRequestController::class, 'index'])->name('admin.baptisms');
        Route::put('/baptisms/{baptismRequest}', [BaptismRequestController::class, 'update'])->name('admin.baptisms.update');

        // Contact Messages
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages');
        Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
        Route::put('/messages/{message}', [ContactMessageController::class, 'update'])->name('admin.messages.update');

        // Invite Requests
        Route::get('/invites', [InviteRequestController::class, 'index'])->name('admin.invites');
        Route::put('/invites/{invite}', [InviteRequestController::class, 'update'])->name('admin.invites.update');
    });
};

// Dev: Path-based
if (app()->environment('local')) {
    Route::prefix('admin')->group($adminRoutes);
} else {
    // Prod: Subdomain-based
    Route::domain(config('app.admin_domain'))->group($adminRoutes);
}