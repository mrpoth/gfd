<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishlistsController extends Controller
{
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
}
