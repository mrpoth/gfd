<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Videogame;
use MarcReichel\IGDBLaravel\Models\Game;
use App\Models\Wishlist;
use App\Models\Library;
use Exception;

class CollectionsController extends Controller
{
  /*
   * Adds to either library or wishlist
   * Also updates videogames table with basic info
   */
  public function storeToList(Request $request)
  {
    $game = $request->game;

    $collectionOption = $request->collectionOption;

    $current_user = Auth::user();

    if (!$current_user) {
      return response()->json([
        "success" => false,
        "error" => "You need to login!",
      ]);
    }
    try {
      Videogame::updateOrCreate(
        ["igdb_id" => $game["id"]],
        [
          "name" => $game["name"],
          "slug" => $game["slug"],
          "cover_url" => $game["cover"]["url"] ?? null,
        ]
      );
    } catch (Exception $e) {
      return $e->getMessage();
    }
    if ($collectionOption == "wishlist") {
      try {
        Wishlist::create([
          "game_id" => $game["id"],
          "user_id" => $current_user->id,
        ]);
      } catch (Exception $e) {
        return response()->json([
          "error" => "The game has already been added to your wishlist!",
          "dev_error" => $e->getMessage(),
        ]);
      }
      return response()->json(["message" => "Added to wishlist!"]);
    } else {
      try {
        Library::create([
          "game_id" => $game["id"],
          "user_id" => $current_user->id,
        ]);
      } catch (Exception $e) {
        return response()->json([
          "error" => "The game has already been added to your library!",
          "dev_error" => $e->getMessage(),
        ]);
      }
      return response()->json(["message" => "Added to library!"]);
    }
  }

  // Removes from wishlist or library

  public function removeFromList(Request $request)
  {
    $game = $request->game;

    $collectionOption = $request->collectionOption;

    try {
      if ($collectionOption == "wishlist") {
        Wishlist::where("game_id", $game["igdb_id"])->delete();
      } else {
        Library::where("game_id", $game["igdb_id"])->delete();
      }
    } catch (Exception $e) {
      return response()->json(["dev_error" => $e->getMessage()]);
    }
  }
}
