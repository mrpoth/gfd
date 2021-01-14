<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game;
use Illuminate\Support\Carbon;
use App\Models\Library;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Videogame;
use App\Models\Wishlist;
use MarcReichel\IGDBLaravel\Models\Cover;

class GamesController extends Controller
{
  // Displays the home page

  public function index()
  {
    $recent_games = Videogame::getRecentGames();

    $popular_games = Videogame::getPopularGames();

    return Inertia::render("Games/Index", [
      "recent_games" => $recent_games,
      "popular_games" => $popular_games,
    ]);
  }

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
      Videogame::updateOrCreate([
        "name" => $game["name"],
        "slug" => $game["slug"],
        "cover_url" => $game["cover"]["url"] ?? null,
        "igdb_id" => $game["id"],
      ]);
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

  /*
   * Displays a single game.
   * Requests are based on the slug
   */

  public function singleGame(Request $request)
  {
    $input = $request->route("slug");

    $game = Videogame::showSingleGame($input);

    return Inertia::render("Games/Single", [
      "game" => $game[0],
    ]);
  }

  // Simply renders the search page

  public function search()
  {
    return Inertia::render("Games/Search");
  }

  /*
   * The search function itself, based on game names
   * Will only display games that have already been released
   */

  public function searchGame(Request $request)
  {
    $now = Carbon::now();

    $input = $request->input("search-game");

    if (!$input) {
      return redirect("/search");
    }

    $search_games = Game::search($input)
      ->where("first_release_date", "<=", $now)
      ->get();

    return Inertia::render("Games/Results", [
      "search_games" => $search_games,
    ]);
  }

  // Renders user's wishlist games

  public function displayWishlist()
  {
    $wishlist = Wishlist::wishlistGames(Auth::user()->id);

    $wishlist_games = [];

    foreach ($wishlist as $game) {
      $wishlist_game = Videogame::getGamesById($game->game_id);
      array_push($wishlist_games, ...$wishlist_game);
    }

    return Inertia::render("Games/Wishlist", [
      "wishlist_games" => $wishlist_games,
    ]);
  }

  // Renders users's library games

  public function displayLibrary()
  {
    $library = Library::libraryGames(Auth::user()->id);

    $library_games = [];

    foreach ($library as $game) {
      $game = Videogame::getGamesById($game->game_id);
      array_push($library_games, ...$game);
    }

    return Inertia::render("Games/Library", [
      "library_games" => $library_games,
    ]);
  }
}
