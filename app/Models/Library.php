<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function videogames()
    {
        return $this->hasMany(Videogame::class);
    }

    public static function libraryGames($user_id)
    {
        return Library::where('user_id', $user_id)->get();
    }
}
