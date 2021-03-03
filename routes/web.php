<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\LandingPageController;

use App\Http\Controllers\ShopController;

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

/*SEE https://laravel.com/docs/8.x/routing*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('home');
// });
//Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Auth::routes();


/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  will work even if use App\Http\Controllers\HomeController; is not declared*/

/*line below works because use App\Http\Controllers\HomeController; is declared*/
//Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

//Route::view('/shop', 'shop'); //show the view called shop for the /shop route
