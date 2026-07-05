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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/register', [EventController::class, 'register'])->name('events.register');
Route::get('/invite', [InviteController::class, 'index'])->name('invite');
Route::post('/invite', [InviteController::class, 'send'])->name('invite.send');
Route::get('/baptism', [BaptismController::class, 'index'])->name('baptism');
Route::post('/baptism/request', [BaptismController::class, 'request'])->name('baptism.request');
Route::get('/community', [CommunityController::class, 'index'])->name('community');
Route::get('/resources', [ResourceController::class, 'index'])->name('resources');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');