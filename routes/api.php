<?php

use App\Http\Controllers\Api\Categories\ApiCategoryController;
use App\Http\Controllers\Api\Rent\ApiRentMeABitController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


    Route::get('rent/', [ApiRentMeABitController::class, 'get_products'])->name('ecommerce-shop');
    // TODO da spostare sotto prodotto
    Route::get('rent/details/{id}', [ApiRentMeABitController::class, 'ecommerce_detail'])->name('ecommerce-details');
    Route::get('rent/checkout', [ApiRentMeABitController::class, 'ecommerce_checkout'])->name('ecommerce-checkout');


    /*
     * List of endpoints related with categories
     *  GET	        /product	            index
     *  GET	        /product/create	        create
     *  POST	    /product	            store
     *  GET	        /product/{id}	        show
     *  GET	        /product/{id}/edit	    edit
     *  PUT/PATCH	/product/{id}	        update
     *  DELETE	    /product/{id}	        destroy
     */
    Route::resource('product', ApiWishlistController::class);


    /*
     * List of endpoints related with categories
     *  GET	        /category	            index
     *  GET	        /category/create	    create
     *  POST	    /category	            store
     *  GET	        /category/{id}	        show
     *  GET	        /category/{id}/edit	    edit
     *  PUT/PATCH	/category/{id}	        update
     *  DELETE	    /category/{id}	        destroy
     */
    Route::resource('category', ApiCategoryController::class);

    /*
     * List of endpoints related with categories
     *  GET	        /wishlist	            index
     *  GET	        /wishlist/create	    create
     *  POST	    /wishlist	            store
     *  GET	        /wishlist/{id}	        show
     *  GET	        /wishlist/{id}/edit	    edit
     *  PUT/PATCH	/wishlist/{id}	        update
     *  DELETE	    /wishlist/{id}	        destroy
     */
    Route::resource('wishlist', ApiWishlistController::class);
