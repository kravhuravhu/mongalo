<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\BaptismRequestController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\InviteRequestController;

Route::domain(config('app.admin_domain', 'admin.thecollective.test'))->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/books', BookController::class)->names('admin.books');
        Route::resource('/events', EventController::class)->names('admin.events');
        Route::get('/events/{id}/registrations', [EventController::class, 'registrations'])->name('admin.events.registrations');
        Route::get('/baptisms', [BaptismRequestController::class, 'index'])->name('admin.baptisms');
        Route::put('/baptisms/{id}', [BaptismRequestController::class, 'update'])->name('admin.baptisms.update');
        Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages');
        Route::get('/messages/{id}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
        Route::put('/messages/{id}', [ContactMessageController::class, 'update'])->name('admin.messages.update');
        Route::get('/invites', [InviteRequestController::class, 'index'])->name('admin.invites');
        Route::put('/invites/{id}', [InviteRequestController::class, 'update'])->name('admin.invites.update');
    });
});