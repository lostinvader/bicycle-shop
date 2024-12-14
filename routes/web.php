<?php

use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// This was done for simplicity, as it avoids a 404 error on the first load and redirects to the correct page.
// However, it is prone to errors, particularly depending on the initial seeding of a fresh database.
Route::get('/', function () {
    return redirect('/products/1');
});

Route::resource('products', ProductController::class)->only(['show']);
Route::resource('carts', CartController::class)->only(['store']);

Route::middleware('auth')->group(function () {
    Route::resource('/admin/variants', VariantController::class)->only(['index', 'edit', 'update']);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
