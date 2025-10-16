<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserModulesController;
use App\Models\UserModules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Auth routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/modules", [ModuleController::class, "index"]);
    Route::post("/modules/{id}/activate", [UserModulesController::class, "activate"]);
    Route::post("/modules/{id}/deactivate", [UserModulesController::class, "deactivate"]);
});