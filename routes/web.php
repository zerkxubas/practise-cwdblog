<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/{provider}/redirect', [ProviderController::class,'redirect'])->name('auth.redirect');

Route::get('/auth/{provider}/callback', [ProviderController::class,'callback'])->name('');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/index', [PhotoController::class,'index'])->name('user.index');
    Route::get('/user/create', [PhotoController::class,'create'])->name('user.create');
    Route::post('/user/index/', [PhotoController::class,'store'])->name('user.store');
});



require __DIR__.'/auth.php';
