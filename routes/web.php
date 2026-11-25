<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\LibraryController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\CommunityController;
use App\Http\Controllers\Web\ResourceController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\InviteController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\PrivacyController;
use App\Http\Controllers\Web\TermsController;

// ─── HOME ───
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── ABOUT ───
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ─── BOOKS ───
Route::get('/books', [LibraryController::class, 'books'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/download/{book}', [BookController::class, 'download'])->name('books.download');
Route::get('/books/preview/{slug}', [BookController::class, 'preview'])->name('books.preview');

// ─── EVENTS ───
// ─── EVENTS LIVE ON THE COMMUNITY PAGE (CALENDAR RETIRED) ───
Route::get('/events/calendar', fn () => redirect()->route('community', [], 301));
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::post('/events/clear-registration', [EventController::class, 'clearRegistration'])->name('events.clear.registration');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

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

// ─── BAPTISM (NOW AN EVENT CATEGORY IN iN COMMUNITY) ───
Route::redirect('/baptism', '/community?cat=baptism', 301)->name('baptism');

// ─── COMMUNITY ───
Route::get('/community', [CommunityController::class, 'index'])->name('community');

// ─── RESOURCES ───
Route::get('/resources', [LibraryController::class, 'resources'])->name('resources');
Route::get('/resources/{slug}', [ResourceController::class, 'show'])->name('resources.show');

// ─── CONTACT ───
// GET route with rate limiting to prevent abuse
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact')
    ->middleware('rate.limit:contact_get');

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

    // ─── RETURN (Success) - Requires CSRF validation ───
    Route::any('/return/{gateway}', [PaymentController::class, 'return'])->name('return');

    // ─── CANCEL - Requires CSRF validation ───
    Route::any('/cancel/{gateway}', [PaymentController::class, 'cancel'])->name('cancel');

    // ─── WEBHOOK - POST (CSRF exempt) ───
    Route::post('/webhook/{gateway}', [PaymentController::class, 'webhook'])->name('webhook');

    // ─── SUCCESS ───
    Route::get('/success/{order}', [PaymentController::class, 'success'])->name('success');

    // ─── FAILURE ───
    Route::get('/failure/{order?}', [PaymentController::class, 'failure'])->name('failure');

    // ─── DOWNLOAD ───
    Route::get('/download/{token}', [PaymentController::class, 'download'])->name('download');
});

// ─── LEGAL PAGES ───
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');