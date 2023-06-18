<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HouseController;
use App\Http\Controllers\HouseReservationController;
use App\Http\Controllers\OrderController;

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

// unauthed, redirect 401
Route::get('login', function (Request $request) {
    return response()->json(['message' => "Please login first!"], 401);
})->name('login');

// houses
Route::get('house-infos', [HouseController::class, 'info']);
Route::get('houses', [HouseController::class, 'index']);
Route::get("/users/{id}/houses", [HouseController::class, 'indexByOwnerId'])->middleware('auth:sanctum');
Route::post("/houses", [HouseController::class, 'store'])->middleware('auth:sanctum');
Route::get("/houses/{id}", [HouseController::class, 'show']);
Route::patch("/houses/{id}", [HouseController::class, 'update'])->middleware('auth:sanctum');
Route::delete("/houses/{id}", [HouseController::class, 'destroy'])->middleware('auth:sanctum');

// house reservations
Route::get("/houses-reservations", [HouseReservationController::class, 'showAllReservationsByHouseIdAndDate']);

// order
Route::post("/orders", [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::get("/orders/{id}", [OrderController::class, 'index'])->middleware('auth:sanctum');
