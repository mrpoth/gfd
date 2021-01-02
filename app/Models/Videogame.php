<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MarcReichel\IGDBLaravel\Models\Game;
use Illuminate\Support\Carbon;

class Videogame extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function wishlist()
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public static function getGamesById($game_id)
    {
        return Videogame::where('igdb_id', $game_id)->get();
    }

    public static function getRecentGames()
    {
        $now = Carbon::now();
        $seven_days_ago = Carbon::now()->subDays(7);

        return Game::whereBetween('first_release_date', $seven_days_ago, $now)->with(['cover' => ['url', 'image_id']])->limit(8)->get();
    }

    public static function getPopularGames()
    {
        $now = Carbon::now();
        $one_year_ago = Carbon::now()->subYear(5);

        return Game::whereBetween('first_release_date', $one_year_ago, $now)
            ->where('aggregated_rating', '>', 0)
            ->where('aggregated_rating_count', '>', '10')
            ->orderBy('aggregated_rating', 'desc')
            ->with(['cover' => ['url', 'image_id']])
            ->limit(8)
            ->get();
    }

    public static function getBiggerCoverImages($url)
    {
        return str_replace("thumb", "cover_big", $url);
    }

    public static function showSingleGame($game_slug)
    {
        return  Game::where('slug', '=', $game_slug)->with(['similar_games', 'genres', 'cover' => ['url', 'image_id']])->get();
    }
}
