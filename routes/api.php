<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FairController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('Register', [AuthController::class, "register"]);


Route::post('Login', [AuthController::class, "login"]);



Route::middleware('auth:sanctum')->group(function () {
    // Aquí defines las rutas que requieren autenticación
    Route::get('Logout', [AuthController::class, 'logout']);

    Route::get('Show',[AuthController::class,'show']);
});



// Publicos
Route::get('State', [DataController::class, 'StateShow']);


Route::get('City', [DataController::class, 'CityShow']);


Route::get('Neighborhood', [DataController::class, 'NeighborhoodShow']);


Route::post('RegisterFair', [FairController::class, 'RegisterFair']);


Route::get('Fair', [FairController::class, 'FairShow']);



Route::get('Badge', [FairController::class, 'BadgeShow']);