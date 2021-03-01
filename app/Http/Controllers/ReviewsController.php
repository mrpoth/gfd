<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index(Videogame $videogame)
    {
        return $videogame->reviews()->latest()->get();
    }

    public function store(Request $request, Videogame $videogame)
    {
        $this->validate($request, [
            'body' => 'required|string|min:10'
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        return $user->reviews()->updateOrCreate(['game_id' => $videogame->id], $request->only(['body']));
    }
}
