<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Admin\SaleController as AdminSaleController;
use App\Http\Controllers\Agent\ProductController as AgentProductController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['prefix' => 'admin' , 'middleware' => 'auth'], function(){

    // , 'middleware' => 'admin'

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('{slug}', function () {
        return view('welcome');
    });

     //Routes for products
    Route::get('/products/all_products', [AdminProductController::class, 'index']);
    Route::post('/products/create_product', [AdminProductController::class, 'store']);
    Route::post('/products/edit_product', [AdminProductController::class, 'update']);
    Route::post('/products/delete_product', [AdminProductController::class, 'destroy']);
    Route::post('/products/upload', [AdminProductController::class, 'upload']);
    Route::post('/products/delete_image', [AdminProductController::class, 'delete_upload']);

     //Routes for products
    Route::get('/expenses/all_expenses', [AdminExpenseController::class, 'index']);
    Route::get('/expenses/expenses_types', [AdminExpenseController::class, 'list_expenseTypes']);
    Route::get('/expenses/expense_sub_types', [AdminExpenseController::class, 'list_expense_subTypes']);
    Route::post('/expenses/create_expense', [AdminExpenseController::class, 'store']);
    Route::post('/expenses/edit_expense', [AdminExpenseController::class, 'update']);
    Route::post('/expenses/delete_expense', [AdminExpenseController::class, 'destroy']);

    //Routes for sales
    Route::get('/sales/all_sales', [AdminSaleController::class, 'index']);
    Route::get('/sales/all_products', [AdminSaleController::class, 'getProductsList']);
    // Route::post('/sales/expense_sub_types', [AdminSaleController::class, 'list_expense_subTypes']);
    Route::post('/sales/create_sale', [AdminSaleController::class, 'store']);
    Route::post('/sales/edit_sale', [AdminSaleController::class, 'update']);
    Route::post('/sales/delete_sale', [AdminSaleController::class, 'destroy']);

});


Route::group(['prefix' => 'agent' , 'middleware' => 'auth'], function(){


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('{slug}', function () {
        return view('welcome');
    });

     //Routes for products
    Route::get('/products/all_products', [AdminProductController::class, 'index']);
    Route::post('/products/create_product', [AdminProductController::class, 'store']);
    Route::post('/products/edit_product', [AdminProductController::class, 'update']);
    Route::post('/products/delete_product', [AdminProductController::class, 'destroy']);
    Route::post('/products/upload', [AdminProductController::class, 'upload']);
    Route::post('/products/delete_image', [AdminProductController::class, 'delete_upload']);

     //Routes for products
    Route::get('/expenses/all_expenses', [AdminExpenseController::class, 'index']);
    Route::get('/expenses/expenses_types', [AdminExpenseController::class, 'list_expenseTypes']);
    Route::get('/expenses/expense_sub_types', [AdminExpenseController::class, 'list_expense_subTypes']);
    Route::post('/expenses/create_expense', [AdminExpenseController::class, 'store']);
    Route::post('/expenses/edit_expense', [AdminExpenseController::class, 'update']);
    // Route::post('/expenses/delete_expense', [AdminExpenseController::class, 'destroy']);

    //Routes for sales
    Route::get('/sales/all_sales', [AdminSaleController::class, 'index']);
    Route::get('/sales/all_products', [AdminSaleController::class, 'getProductsList']);
    // Route::post('/sales/expense_sub_types', [AdminSaleController::class, 'list_expense_subTypes']);
    Route::post('/sales/create_sale', [AdminSaleController::class, 'store']);
    Route::post('/sales/edit_sale', [AdminSaleController::class, 'update']);
    // Route::post('/sales/delete_sale', [AdminSaleController::class, 'destroy']);

});