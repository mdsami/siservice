<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmeController;
use App\Http\Controllers\BcicController;
use App\Http\Controllers\McciController;
use App\Http\Controllers\API\NiscController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/nisc', [NiscController::class, 'index']);

//Route::get('/get_table_structure',[DbSchamaController::class,'index']);

Route::post('ubid', [NiscController::class, 'store']);

Route::get('/token', [NiscController::class, 'get_token']);
Route::post('/get_table_structure',[NiscController::class, 'get_table_structure']);
Route::post('/get_ubid', [NiscController::class, 'get_ubid']);

Route::get('/sme/token', [SmeController::class, 'get_token']);
Route::post('/sme/get_table_structure',[SmeController::class, 'get_table_structure']);
Route::post('sme/get_ubid', [SmeController::class, 'get_ubid']);


Route::get('/bscic/token', [BcicController::class, 'get_token']);
Route::post('/bscic/get_table_structure',[BcicController::class, 'get_table_structure']);
Route::post('bscic/get_ubid', [BcicController::class, 'get_ubid']);


Route::get('/mcci/token', [McciController::class, 'get_token']);
Route::post('/mcci/get_table_structure',[McciController::class, 'get_table_structure']);
Route::post('mcci/get_ubid', [McciController::class, 'get_ubid']);
