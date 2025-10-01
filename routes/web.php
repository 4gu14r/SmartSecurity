<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OccurrenceController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics');

// Authentication routes (will be implemented later)
Route::get('/login', function() { return inertia('Auth/Login'); })->name('login');
Route::get('/register', function() { return inertia('Auth/Register'); })->name('register');
Route::post('/logout', function() { return redirect('/'); })->name('logout');

// Occurrences routes (public access for now)
Route::resource('occurrences', OccurrenceController::class);
Route::get('/statistics', [OccurrenceController::class, 'statistics'])->name('statistics');

// Protected routes (will be implemented later)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit', function() { return inertia('Profile/Edit'); })->name('profile.edit');
});

// Privacy and Terms routes
Route::get('/privacy', function() { return inertia('Legal/Privacy'); })->name('privacy');
Route::get('/terms', function() { return inertia('Legal/Terms'); })->name('terms');
