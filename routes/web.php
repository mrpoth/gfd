<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamesController;
use App\Http\Resources\Gaming;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(["auth:sanctum", "verified"])
  ->get("/dashboard", function () {
    return Inertia\Inertia::render("Dashboard");
  })
  ->name("dashboard");

Route::get("/", [GamesController::class, "index"]);

Route::get("/game/{slug}", [GamesController::class, "singleGame"]);

Route::post("/game/store", [GamesController::class, "storeToList"]);

Route::post("/game/remove", [GamesController::class, "removeFromList"]);

Route::post("/game/library", [GamesController::class, "storeToLibrary"]);

Route::get("/search", [GamesController::class, "search"]);

Route::any("/results", [GamesController::class, "searchGame"]);

Route::get("/wishlist", [
  GamesController::class,
  "displayWishlist",
])->middleware("auth");

Route::get("/library", [GamesController::class, "displayLibrary"])->middleware(
  "auth"
);
