<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LibrariesController extends Controller
{
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
