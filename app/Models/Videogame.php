<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videogame extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_videogame', 'user_id', 'game_id')->withPivot('library', 'wishlist')->withTimestamps();;
    // }

    public function wishlist()
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public static function getGamesById($game_id)
    {
        return Videogame::where('igdb_id', $game_id)->get();

    }
}
