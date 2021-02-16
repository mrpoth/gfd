<?php

use App\Http\Controllers\CollectionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\LibrariesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistsController;
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

Route::post("/game/store", [CollectionsController::class, "storeToList"]);

Route::post("/game/remove", [CollectionsController::class, "removeFromList"]);

Route::get("/search", [SearchController::class, "search"]);

Route::any("/results", [SearchController::class, "searchGame"]);

Route::get("/wishlist", [
  WishlistsController::class,
  "displayWishlist",
])->middleware("auth");

Route::get("/library", [
  LibrariesController::class,
  "displayLibrary",
])->middleware("auth");

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
