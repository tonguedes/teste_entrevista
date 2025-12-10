<?php

use App\Livewire\Produtos as ProdutosIndex;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

/**
 * Redirects the root URL ("/") to the registration page.
 * Since Breeze is being used, this sends the user to the default auth route.
 */
Route::get('/', function () {
    return redirect()->route('register'); // redirect to Breeze's register route
});

/**
 * Route that loads the product listing page.
 * The view 'produtos' contains a Livewire component responsible for the UI.
 * Only authenticated and email-verified users can access this route.
 */
Route::get('/produtos', function() {
    return view('produtos');
})->middleware(['auth', 'verified'])->name('produtos');

/**
 * Dashboard route.
 * Only accessible for users who are authenticated and verified.
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Group of routes that require the user to be authenticated.
 * Handles profile editing, updating, and deleting.
 */
Route::middleware('auth')->group(function () {

    // Shows the profile edit form
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    // Saves profile changes
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Deletes the user account
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



/**
 * Loads authentication routes from the Breeze 'auth.php' file.
 * This includes login, logout, registration, password reset, etc.
 */
require __DIR__.'/auth.php';
