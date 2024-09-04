<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
Route::middleware(['auth:sanctum', 'role:Manager'])->group(function () {
//    Route::get('/manager', [\App\Http\Controllers\ManagerController::class, 'index'])
    return'bonjour';
});
//
//
//Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
//    Route::get('/client', [\App\Http\Controllers\ClientController::class, 'index']);
//});

//Authentification

Route::post('register',[\App\Http\Controllers\AuthControllerController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthControllerController::class,'login'])->name('login');
Route::post('logout',[\App\Http\Controllers\AuthControllerController::class,'logout'])->middleware('auth');

//Candidat

Route::apiResource('/candidat',\App\Http\Controllers\CandidatController::class);

//Consultant

Route::apiResource('/consultant',\App\Http\Controllers\ConsultantController::class);

//Mission

Route::apiResource('/missions',\App\Http\Controllers\MissionController::class);
