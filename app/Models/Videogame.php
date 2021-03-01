<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MarcReichel\IGDBLaravel\Models\Game;
use Illuminate\Support\Carbon;

class Videogame extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function reviews(): HasMany
  {
      return $this->hasMany(Review::class, 'game_id', 'id');
  }

  public function wishlist()
  {
    return $this->belongsToMany(Wishlist::class);
  }

  public static function getGamesById($game_id)
  {
    return Videogame::where("igdb_id", $game_id)->get();
  }

  public static function getRecentGames()
  {
    $now = Carbon::now();
    $seven_days_ago = Carbon::now()->subDays(7);

    return Game::whereBetween("first_release_date", $seven_days_ago, $now)
      ->with(["cover" => ["url", "image_id"]])
      ->limit(8)
      ->get();
  }

  public static function getPopularGames()
  {
    $now = Carbon::now();
    $three_months_ago = Carbon::now()->subMonth(3);

    return Game::whereBetween("first_release_date", $three_months_ago, $now)
      ->where("aggregated_rating", ">", 0)
      ->where("aggregated_rating_count", ">=", "10")
      ->orderBy("aggregated_rating", "desc")
      ->with(["cover" => ["url", "image_id"]])
      ->limit(8)
      ->get();
  }

  public static function getHighestRatedGames()
  {
    $now = Carbon::now();
    $ten_years_ago = Carbon::now()->subYear(10);

    return Game::whereBetween("first_release_date", $ten_years_ago, $now)
      ->where("aggregated_rating", ">", 0)
      ->where("aggregated_rating_count", ">", "10")
      ->orderBy("aggregated_rating", "desc")
      ->with(["cover" => ["url", "image_id"]])
      ->limit(8)
      ->get();
  }

  public static function getBiggerCoverImages($url)
  {
    return str_replace("thumb", "cover_big", $url);
  }

  public static function showSingleGame($game_slug)
  {
    $single_game = Game::where("slug", "=", $game_slug)
      ->with(["similar_games", "genres", "cover" => ["url", "image_id"]])
      ->with(["websites" => ["url", "category"]])
      ->get();

    $videogame = Videogame::updateOrCreate(
      ["igdb_id" => $single_game[0]["id"]],
      [
        "name" => $single_game[0]["name"],
        "slug" => $single_game[0]["slug"],
        "cover_url" => $single_game[0]["cover"]["url"] ?? null,
      ]
    );

    return [
      'id' => $videogame->id,
      'data' => $single_game[0]
    ];
  }
}
