<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn() => redirect()->route('redirects.index'));
Route::get('r/{redirect}', [RedirectController::class, 'redirect'])->name('r.redirect');

Route::resource('redirects', RedirectController::class)->except('show');
