<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game;

class SearchController extends Controller
{
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
}
