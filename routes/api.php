<?php

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

Route::prefix("/news")->group(function() {
    Route::get("/addNew", [NewsController::class, "addNew"]);
    Route::get("/search", [NewsController::class, "search"]);
});

Route::prefix("/instagram")->group(function() {
    Route::get("/addNew", [InstagramController::class, "addNew"]);
    Route::get("/search", [InstagramController::class, "search"]);
});

Route::prefix("/twitter")->group(function() {
    Route::get("/addNew", [TwitterController::class, "addNew"]);
    Route::get("/search", [TwitterController::class, "search"]);
});

Route::prefix("/resource")->group(function() {
    Route::get("/list", [ResourceController::class, "list"]);
    Route::get("/{resource}/subscribe", [ResourceController::class, "subscribe"]);
});