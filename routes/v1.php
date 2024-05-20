<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

// Route::group(['middleware' => 'api','prefix' => 'product'], function ($router)
Route::group(['middleware' => ['auth:api'], 'prefix' => 'products'], function ($router)
{

    $router->post('/',[ProductController::class,'createProduct']);
    $router->get('/',[ProductController::class,'index']);
    $router->get('/archive',[ProductController::class,'archiveProduct']);
    $router->get('/{id}',[ProductController::class,'showProduct']);
    $router->put('/{id}',[ProductController::class,'updateProduct']);
    $router->delete('/{id}',[ProductController::class,'deleteProduct']);
    $router->post('/restore/{id}',[ProductController::class,'restoreProduct']);

});

Route::group(['middleware' => 'auth:api','prefix' => 'category'], function ($router)
{
    $router->get('/',[CategoryController::class,'index']);
    $router->post('/',[CategoryController::class,'createCategory']);
    $router->get('/{id}',[CategoryController::class,'showCategory']);
    $router->put('/{id}',[CategoryController::class,'updateCategory']);
    $router->delete('/{id}',[CategoryController::class,'deleteCategory']);

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



