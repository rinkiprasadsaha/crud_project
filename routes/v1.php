<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Route::group(['middleware' => 'api','prefix' => 'product'], function ($router)
Route::group(['middleware' => ['auth:api'], 'prefix' => 'product'], function ($router)
{
    Route::get('/',[ProductController::class,'index']);
    Route::get('/archive',[ProductController::class,'archive_product']);
    Route::post('/',[ProductController::class,'create_product']);
    Route::get('/{id}',[ProductController::class,'show_product']);
    Route::put('/{id}',[ProductController::class,'update_product']);
    Route::delete('/{id}',[ProductController::class,'delete_product']);
    Route::post('/restore/{id}',[ProductController::class,'restore_product']);

    Route::post('/form_request',[ProductController::class,'create']);

});

Route::group(['middleware' => 'auth:api','prefix' => 'category'], function ($router)
{
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/',[CategoryController::class,'create_category']);
    Route::get('/{id}',[CategoryController::class,'show_category']);
    Route::put('/{id}',[CategoryController::class,'update_category']);
    Route::delete('/{id}',[CategoryController::class,'delete_category']);

});



