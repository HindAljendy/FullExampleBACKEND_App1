<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\API\AuthController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);

    /* Items */
    Route::get('/items',[ItemController::class, 'index']);
    Route::post('/add',[ItemController::class, 'store']);  
    Route::put('/update/{item}',[ItemController::class, 'update']);  
    Route::get('/items/{item}',[ItemController::class, 'show']);  
    Route::delete('/items/{item}',[ItemController::class, 'destroy']);  



});
