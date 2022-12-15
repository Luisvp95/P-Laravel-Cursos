<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Livewire\ShowCourse;

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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('curso/{course:slug}', [PageController::class, 'course'])->name('course');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/categorias', function () {
    return view('show-category');
})->name('show-category');


Route::middleware(['auth:sanctum', 'verified'])->get('/cursos', function () {
    return view('show-course');
})->name('show-course');

Route::middleware(['auth:sanctum', 'verified'])->get('/posts', function () {
    return view('show-post');
})->name('show-post');


/*Route::middleware(['auth:sanctum', 'verified'])->get('/images', function () {
    return view('images');
})->name('images');*/




