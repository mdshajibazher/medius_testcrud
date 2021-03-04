<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SPAcontroller;


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

Route::resource('customers', CustomerController::class)->except('create','show');
Route::get('/customers/{query_field}/{query}', [CustomerController::class,'search']);

Route::get('/{any}', SPAcontroller::class)->where('any', '.*');



//Auth::routes();


