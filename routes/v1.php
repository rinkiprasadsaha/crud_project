<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

// Route::group(['middleware' => 'api','prefix' => 'product'], function ($router)
Route::group(['middleware' => ['auth:api']], function()
{
    Route::group(['middleware' => ['permission:view-products']], function() {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');;
    });

    Route::group(['middleware' => ['permission:create-products']], function() {
        Route::post('/products',  [ProductController::class,'createProduct'])->name('products.createProduct');
    });

    Route::group(['middleware' => ['permission:edit-products']], function() {
        Route::put('/products/{id}', [ProductController::class,'updateProduct'])->name('products.updateProduct');
    });

    Route::group(['middleware' => ['permission:delete-products']], function() {
        Route::delete('/products/{id}', [ProductController::class,'deleteProduct'])->name('products.deleteProduct');

    });

    Route::group(['middleware' => ['permission:show-products-by-id']], function() {
        Route::get('/products/{id}', [ProductController::class,'showProduct'])->name('products.showProduct');

    });

    Route::group(['middleware' => ['permission:restore-products']], function() {
        Route::post('/products/restore/{id}', [ProductController::class,'restoreProduct'])->name('products.restoreProduct');

    });


});

Route::group(['middleware' => ['auth:api']], function()
{
    Route::group(['middleware' => ['permission:view-categorys']], function() {
        Route::get('/category', [CategoryController::class, 'index'])->name('categorys.index');;
    });

    Route::group(['middleware' => ['permission:create-categorys']], function() {
        Route::post('/category',  [CategoryController::class,'createCategory'])->name('categorys.createProduct');
    });

    Route::group(['middleware' => ['permission:edit-categorys']], function() {
        Route::put('/category/{id}', [CategoryController::class,'updateCategory'])->name('categorys.updateCategory');
    });

    Route::group(['middleware' => ['permission:delete-categorys']], function() {
        Route::delete('/category/{id}', [CategoryController::class,'deleteCategory'])->name('categorys.deleteCategory');

    });


});



Route::group(['middleware' => 'auth:api','prefix' => 'item'], function ($router)
{
    $router->get('/',[ItemController::class,'index']);
    $router->post('/',[ItemController::class,'createItem']);
    $router->get('/{id}',[ItemController::class,'showItem']);
    $router->put('/{id}',[ItemController::class,'updateItem']);
    $router->delete('/{id}',[ItemController::class,'deleteItem']);
    $router->post('/restore/{id}',[ItemController::class,'restoreItem']);

});



