<?php

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

Route::get("/", [App\Http\Controllers\FrontProductListController::class, 'index']);
Route::get("/product/{id}", [App\Http\Controllers\FrontProductListController::class, 'show'])->name('product.view');
Route::get("/orders", [App\Http\Controllers\CartController::class, 'order'])->name('order')->middleware('auth');
Route::get("/checkout/{amount}", [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::post("/charge", [App\Http\Controllers\CartController::class, 'charge'])->name('cart.charge');
Route::get("/category/{name}", [App\Http\Controllers\FrontProductListController::class, 'allProduct'])->name('product.list');
Route::get("/addToCart/{product}", [App\Http\Controllers\CartController::class, 'addToCart'])->name('add.cart');
Route::get("/cart", [App\Http\Controllers\CartController::class, 'showCart'])->name('cart.show');
Route::post("/products/{product}", [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
Route::post("/product/{product}", [App\Http\Controllers\CartController::class, 'removeCart'])->name('cart.remove');

Auth::routes();


Route::get('all/products', [App\Http\Controllers\FrontProductListController::class, 'moreProducts'])->name('more.product');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('subcatories/{id}', [App\Http\Controllers\ProductController::class, 'loadSubCategories']);
Route::group(['prefix'=>'auth','middleware'=>['auth','isAdmin']],function(){
    Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('subcategory', App\Http\Controllers\SubCategoryController::class);
    Route::resource('product', App\Http\Controllers\ProductController::class);

    Route::get('slider/create', [App\Http\Controllers\SliderController::class, 'create'])->name('slider.create');
    Route::get('slider', [App\Http\Controllers\SliderController::class, 'index'])->name('slider.index');
    Route::post('slider', [App\Http\Controllers\SliderController::class, 'store'])->name('slider.store');
    Route::delete('slider/{id}', [App\Http\Controllers\SliderController::class, 'destroy'])->name('slider.destroy');

    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');

    Route::get('/orders', [App\Http\Controllers\CartController::class, 'userOrder'])->name('order.index');
    Route::get("/orders/{userid}/{orderid}", [App\Http\Controllers\CartController::class, 'viewUserOrder'])->name('order.detail');
});