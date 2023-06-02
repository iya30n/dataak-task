<?php

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

// Route::get("/test", fn() => "hey");

Route::prefix("/news")->group(function() {
    Route::get("/addNew", [NewsController::class, "addNew"]);
    Route::get("/search", [NewsController::class, "search"]);
});

/* Route::prefix("/instagram")->group(function() {
    Route::get("/addNew", [InstagramController::class, "addNew"]);
});

Route::prefix("/twitter")->group(function() {
    Route::get("/addNew", [TwitterController::class, "addNew"]);
}); */