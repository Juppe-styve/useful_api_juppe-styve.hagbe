<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortenController;
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
    //routes for module
    Route::get("/modules", [ModuleController::class, "index"]);
    Route::post("/modules/{id}/activate", [UserModulesController::class, "activate"]);
    Route::post("/modules/{id}/deactivate", [UserModulesController::class, "deactivate"]);

    //route for shorten Url
    Route::middleware("checkModule")->group(function () {
        Route::post("/shorten", [ShortenController::class, "store"]);
        Route::get("/links", [ShortenController::class, "index"]);
        Route::delete("/links/{id}", [ShortenController::class, "destroy"]);
    });
});

//redirection vers url
Route::get("/s/{code}", [ShortenController::class, "redirect"]);