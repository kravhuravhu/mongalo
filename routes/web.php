<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\BaptismController;
use App\Http\Controllers\Web\CommunityController;
use App\Http\Controllers\Web\ResourceController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\InviteController;

// Home
Route::get('/', [
    HomeController::class, 'index'
])->name('home');

// About
Route::get('/about', [
    AboutController::class, 'index'
])->name('about');

// Books
Route::get('/books', [
    BookController::class, 'index'
])->name('books.index');

Route::get('/books/{slug}', [
    BookController::class, 'show'
])->name('books.show');

// Events
Route::get('/events', [
    EventController::class, 'index'
])->name('events.index');

Route::get('/events/{slug}', [
    EventController::class, 'show'
])->name('events.show');

Route::post('/events/register', [
    EventController::class, 'register'
])->name('events.register');

// Invite Arthur
Route::get('/invite', [
    InviteController::class, 'index'
])->name('invite');

Route::post('/invite', [
    InviteController::class, 'send'
])->name('invite.send');

// Baptism
Route::get('/baptism', [
    BaptismController::class, 'index'
])->name('baptism');

Route::post('/baptism/request', [
    BaptismController::class, 'request'
])->name('baptism.request');

// Community
Route::get('/community', [
    CommunityController::class, 'index'
])->name('community');

// Resources
Route::get('/resources', [
    ResourceController::class, 'index'
])->name('resources');

// Contact
Route::get('/contact', [
    ContactController::class, 'index'
])->name('contact');

Route::post('/contact', [
    ContactController::class, 'send'
])->name('contact.send');