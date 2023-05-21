<?php

use App\Http\Controllers\Api\V1\CameraController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RecorderController;
use App\Models\AuthContorller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('login',[AuthContorller::class ,'login']);
Route::post('register',[AuthContorller::class ,'register']);


Route::group(['middleware'=>['auth:sanctum']], function (){
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('recorders', RecorderController::class);
    Route::apiResource('cameras', CameraController::class);
    Route::post('logout',[AuthContorller::class ,'logout']);
});
/*Addat titkositás
 *
 use Illuminate\Support\Facades\Crypt;

// Adat titkosítása
$encryptedData = Crypt::encryptString($dataToEncrypt);

// Titkosított adat visszafejtése
$decryptedData = Crypt::decryptString($encryptedData);
*/
