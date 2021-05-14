<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\LandingPageController;

use App\Http\Controllers\ShopController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\SaveForLaterController;

use App\Http\Controllers\ImageRemoverController;

use Gloudemans\Shoppingcart\Facades\Cart;

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

//Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');


//Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');

Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');

Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy'); 
//remove product from cart


//SaveForLater Routes
Route::post('/cart/switchToSaveForLater/{product}', [CartController::class, 'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])->name('saveForLater.destroy');

Route::post('/saveForLater/switchToCart/{product}', [SaveForLaterController::class, 'switchToCart'] )->name('saveForLater.switchToCart');

Route::get('/removeproductimage/delete_value/{id}', [ImageRemoverController::class, 'delete_value'])->name('admin.productimageremoval.delete_value');

Route::get('empty', function() {
  Cart::instance('saveForLater')->destroy();
});

//Route::view('/shop', 'shop'); //show the view called shop for the /shop route


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
