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
   * Displays a single game.
   * Requests are based on the slug
   */

  public function singleGame(Request $request)
  {
    $input = $request->route("slug");

    $game = Videogame::showSingleGame($input);

    return Inertia::render("Games/Single", [
      "game" => $game,
    ]);
  }
}
