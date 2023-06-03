<?php

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

Route::prefix("/news")->group(function() {
    Route::post("/", [NewsController::class, "store"]);
    Route::get("/search", [NewsController::class, "search"]);
});

Route::prefix("/instagram")->group(function() {
    Route::post("/", [InstagramController::class, "store"]);
    Route::get("/search", [InstagramController::class, "search"]);
});

Route::prefix("/twitter")->group(function() {
    Route::post("/", [TwitterController::class, "store"]);
    Route::get("/search", [TwitterController::class, "search"]);
});

Route::prefix("/resource")->group(function() {
    Route::get("/list", [ResourceController::class, "list"]);
    Route::get("/{resource}/subscribe", [ResourceController::class, "subscribe"]);
});