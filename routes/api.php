<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShortenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionTimeController;
use App\Http\Controllers\UserModulesController;
use App\Models\SessionTime;
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


    Route::middleware("checkModule")->group(function () {
        //route for shorten Url
        Route::post("/shorten", [ShortenController::class, "store"]);
        Route::get("/links", [ShortenController::class, "index"]);
        Route::delete("/links/{id}", [ShortenController::class, "destroy"]);

        //route for wallet
        Route::get("/wallet", [UserController::class, "wallet"]);
        Route::post("/wallet/transfer", [UserController::class, "transfert"]);
        Route::post("/wallet/topup", [UserController::class, "topUp"]);
        Route::get("/wallet/transactions", [UserController::class, "getTransactions"]);

        //route for products
        Route::post("/products", [ProductController::class, "store"]);
        Route::get("/products", [ProductController::class, "index"]);
        Route::post("/orders", [OrderController::class, "store"]);
        Route::post("/products/{id}/restock", [ProductController::class, "restock"]);

        //route for sessions
        Route::post("/sessions/start", [SessionTimeController::class, "store"]);
    });
});

//redirection vers url
Route::get("/s/{code}", [ShortenController::class, "redirect"]);