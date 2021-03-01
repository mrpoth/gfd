<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Videogame;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReviewsController extends Controller
{

  public function displayReviews(Request $request)
  {

    $game_id = $request->game_id;
    $review = Review::userReviews( $game_id);

   return $review[0]->description;

    // return Inertia::render("Games/Library", [
    //   "user_reviews" => $user_reviews,
    // ]);
  }

  public function store(Request $request)
  {
    $id = Auth::id();
    $slug = $request->game_slug;
    $game_id = $request->game_id;
    $review = $request->validate([
      "description" => ["required", "max:200"],
    ]);
    // try {
    $review = Review::updateOrCreate(
      ["game_id" => $game_id, "user_id" => $id],
      ["description" => $review["description"]]
    );

    // } catch (Exception $e) {
    //   return response()->json([
    //     "error" => "The review could not be added",
    //     "dev_error" => $e->getMessage(),
    //   ]);
    // }
    return redirect()->route("single_game", [
      "slug" => $slug,
    ]);
  }
}
