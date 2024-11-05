<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/show/{id}', [HomeController::class, 'show'])->name('show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'authLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']],function() {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/movies', [MovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/movies/store', [MovieController::class, 'store'])->name('admin.movies.store');
    Route::get('/movies/edit/{id}', [MovieController::class, 'edit'])->name('admin.movies.edit');
    Route::put('/movies/update/{id}', [MovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('/movies/delete/{id}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');

    Route::get('/genres', [GenreController::class, 'index'])->name('admin.genres.index');
    Route::get('/genres/create', [GenreController::class, 'create'])->name('admin.genres.create');
    Route::post('/genres/store', [GenreController::class, 'store'])->name('admin.genres.store');
    Route::get('/genres/edit/{id}', [GenreController::class, 'edit'])->name('admin.genres.edit');
    Route::put('/genres/update/{id}', [GenreController::class, 'update'])->name('admin.genres.update');
    Route::delete('/genres/delete/{id}', [GenreController::class, 'destroy'])->name('admin.genres.destroy');
});
