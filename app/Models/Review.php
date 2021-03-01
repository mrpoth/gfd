<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id', 'game_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function videogames()
    {
        return $this->hasMany(Videogame::class);
    }

    public static function userReviews($game_id)
    {
        return Review::where('game_id', $game_id)->get();
    }
}
