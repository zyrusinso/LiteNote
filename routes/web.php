<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/notes/trashed', [App\Http\Controllers\TrashedNoteController::class, 'index'])->name('trashed.index');
    Route::get('/notes/trashed/{note}', [App\Http\Controllers\TrashedNoteController::class, 'show'])->withTrashed()->name('trashed.show');
    Route::get('/notes/trashed/{note}', [App\Http\Controllers\TrashedNoteController::class, 'update'])->withTrashed()->name('trashed.update');
    
    Route::resource('/notes', App\Http\Controllers\NoteController::class);
});
