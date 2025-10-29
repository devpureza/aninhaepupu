<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\FaqController;
use App\Http\Controllers\Site\GiftsController;
use App\Http\Controllers\Site\HomeController as PublicHomeController;
use App\Http\Controllers\Site\LocationController;
use App\Http\Controllers\Site\MessagesController;
use App\Http\Controllers\Site\PrivacyController;
use App\Http\Controllers\Site\RsvpController;
use App\Http\Controllers\Site\ScheduleController;
use App\Http\Controllers\Site\StoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Páginas Públicas
Route::get('/', [PublicHomeController::class, 'index'])->name('home');
Route::get('/nossa-historia', StoryController::class)->name('story');
Route::get('/cronograma', ScheduleController::class)->name('schedule');
Route::get('/local', LocationController::class)->name('location');
Route::get('/presentes', GiftsController::class)->name('gifts');
Route::get('/mensagens', [MessagesController::class, 'index'])->name('messages');
Route::post('/mensagens', [MessagesController::class, 'store'])->name('messages.store');
Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::get('/faq', FaqController::class)->name('faq');
Route::get('/privacidade', PrivacyController::class)->name('privacy');

Route::post('/presentes/{product:slug}/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/sucesso/{order:code}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/pendente/{order:code}', [CheckoutController::class, 'pending'])->name('checkout.pending');
Route::get('/checkout/erro/{order:code}', [CheckoutController::class, 'failure'])->name('checkout.failure');
Route::match(['post', 'get'], '/webhooks/payments/{gateway}', [CheckoutController::class, 'webhook'])->name('checkout.webhook');

// Rotas de autenticação padrão Laravel
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
