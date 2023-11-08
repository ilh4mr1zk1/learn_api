<?php

use App\Http\Controllers\API\TimnasIndonesiaController;
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

Route::get('timnaslist', [TimnasIndonesiaController::class, 'index']);
Route::post('timnas/store', [TimnasIndonesiaController::class, 'store']);
Route::get('timnas/showdata', [TimnasIndonesiaController::class, 'show']);
Route::post('timnas/updatedata', [TimnasIndonesiaController::class, 'update']);
Route::delete('timnas/destroy', [TimnasIndonesiaController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
