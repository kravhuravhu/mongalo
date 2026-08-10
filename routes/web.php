<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\EventCalendarController;
use App\Http\Controllers\Web\BaptismController;
use App\Http\Controllers\Web\CommunityController;
use App\Http\Controllers\Web\ResourceController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\InviteController;
use App\Http\Controllers\Web\PaymentController;

// ─── HOME ───
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── ABOUT ───
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ─── BOOKS ───
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/download/{book}', [BookController::class, 'download'])->name('books.download');

// ─── EVENTS ───
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/calendar', [EventCalendarController::class, 'index'])->name('events.calendar');
Route::get('/events/calendar/events', [EventCalendarController::class, 'getEventsByDate'])->name('events.calendar.events');
Route::post('/events/clear-registration', [EventController::class, 'clearRegistration'])->name('events.clear.registration');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/register', [EventController::class, 'register'])->name('events.register')->middleware('rate.limit:payment');

// ─── RATE LIMITED: EVENT REGISTRATION ───
Route::post('/events/register', [EventController::class, 'register'])
    ->name('events.register')
    ->middleware('rate.limit:payment');

// ─── INVITE ARTHUR ───
Route::get('/invite', [InviteController::class, 'index'])->name('invite');

// ─── RATE LIMITED: INVITE SEND ───
Route::post('/invite', [InviteController::class, 'send'])
    ->name('invite.send')
    ->middleware('rate.limit:invite');

// ─── BAPTISM ───
Route::get('/baptism', [BaptismController::class, 'index'])->name('baptism');

// ─── RATE LIMITED: BAPTISM REQUEST ───
Route::post('/baptism/request', [BaptismController::class, 'request'])
    ->name('baptism.request')
    ->middleware('rate.limit:baptism');

// ─── COMMUNITY ───
Route::get('/community', [CommunityController::class, 'index'])->name('community');

// ─── RESOURCES ───
Route::get('/resources', [ResourceController::class, 'index'])->name('resources');

// ─── CONTACT ───
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// ─── RATE LIMITED: CONTACT SEND ───
Route::post('/contact', [ContactController::class, 'send'])
    ->name('contact.send')
    ->middleware('rate.limit:contact');

// ─── PAYMENT ROUTES ───
Route::prefix('payment')->name('payment.')->group(function () {
    // ─── RATE LIMITED: INITIATE PAYMENT ───
    Route::post('/initiate', [PaymentController::class, 'initiate'])
        ->name('initiate')
        ->middleware('rate.limit:payment');

    Route::get('/checkout/{gateway}/{order}', [PaymentController::class, 'checkout'])->name('checkout');

    // ─── RETURN (Success) - GET ───
    Route::any('/return/{gateway}', [PaymentController::class, 'return'])->name('return');

    // ─── CANCEL - GET ───
    Route::any('/cancel/{gateway}', [PaymentController::class, 'cancel'])->name('cancel');

    // ─── WEBHOOK - POST ───
    Route::post('/webhook/{gateway}', [PaymentController::class, 'webhook'])->name('webhook');

    // ─── SUCCESS ───
    Route::get('/success/{order}', [PaymentController::class, 'success'])->name('success');

    // ─── FAILURE ───
    Route::get('/failure/{order?}', [PaymentController::class, 'failure'])->name('failure');

    // ─── DOWNLOAD ───
    Route::get('/download/{token}', [PaymentController::class, 'download'])->name('download');
});