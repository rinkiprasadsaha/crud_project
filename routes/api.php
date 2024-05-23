<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
/*
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->post('/refresh', [AuthController::class, 'refresh']);
    $router->get('/user-profile', [AuthController::class, 'userProfile']);
    $router->post('/forgotPassword', [AuthController::class,'forgotPassword']);

    $router->post('/resetPassword/{token}', [AuthController::class,'resetPassword']);


});

// Route::group(['middleware' =>['auth:api']], function ()
// {
//     Route::group(['middleware' => ['permission:view-users']], function() {
//         Route::get('/users', [UserController::class, 'index'])->name('users.index');;
//     });
//     Route::group(['middleware' => ['permission:create-users']], function() {
//         Route::post('/users', [UserController::class, 'createUser'])->name('users.createUser');;
//         });
//     Route::group(['middleware' => ['permission:edit-users']], function() {
//             Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.updateUser');;
//         });
//     Route::group(['middleware' => ['permission:delete-users']], function() {
//             Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.deleteUser');;
//             });


// });


Route::group(['middleware' =>['auth:api']], function () {
    Route::group(['middleware' => ['role:admin|super-admin']], function() {
        // Routes for admin and superadmin with all permissions
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'createUser'])->name('users.createUser');
        Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.updateUser');
        Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.deleteUser');
    });

    // Other routes for authenticated users with specific permissions or roles
});

Route::group(['middleware' =>['auth:api']], function () {
    Route::group(['middleware' => ['role:admin|super-admin|user']], function() {
        // Routes for admin and superadmin with all permissions
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::post('/products', [ProductController::class, 'createProduct'])->name('products.createUser');
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.updateUser');
        Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.deleteUser');
        Route::get('/products/{id}', [ProductController::class,'showProduct'])->name('products.showProduct');
        Route::post('/products/restore/{id}', [ProductController::class,'restoreProduct'])->name('products.restoreProduct');
    });

    // Other routes for authenticated users with specific permissions or roles
});

Route::group(['middleware' =>['auth:api']], function () {
    Route::group(['middleware' => ['role:admin|super-admin|user']], function() {
        // Routes for admin and superadmin with all permissions
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/category', [CategoryController::class, 'createCategory'])->name('category.createCategory');
        Route::put('/category/{id}', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
        Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
    });

    // Other routes for authenticated users with specific permissions or roles
});

