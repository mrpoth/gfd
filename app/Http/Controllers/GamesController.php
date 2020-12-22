<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use MarcReichel\IGDBLaravel\Models\Game;
use Illuminate\Support\Carbon;
use App\Http\Resources\GameResource;
use App\Models\Library;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Videogame;
use App\Models\Wishlist;

class GamesController extends Controller
{
    //


    public function index()
    {

        $now = Carbon::now();
        $seven_days_ago = Carbon::now()->subDays(7);
        $one_year_ago = Carbon::now()->subYear(5);

        $recent_games = Game::whereBetween('first_release_date', $seven_days_ago, $now)->with(['cover' => ['url', 'image_id']])->limit(8)->get();

        $popular_games = Game::whereBetween('first_release_date', $one_year_ago, $now)
            ->where('aggregated_rating', '>', 0)
            ->where('aggregated_rating_count', '>', '10')
            ->orderBy('aggregated_rating', 'desc')
            ->with(['cover' => ['url', 'image_id']])
            ->limit(8)
            ->get();


        return Inertia::render('Games/Index', [
            'recent_games' => $recent_games,
            'popular_games' => $popular_games
        ]);
    }

    public static function getBiggerCoverImages($url)
    {
        return str_replace("thumb", "cover_big", $url);
    }

    public function storeToList(Request $request)
    {

        $game = $request->game;

        $collectionOption = $request->collectionOption;

        $current_user = Auth::user();

        if (!$current_user) {
            return response()->json([
                'success' => false,
                'error' => 'You need to login!'
            ]);
        }

        try {
            Videogame::updateOrCreate([
                'name' => $game['name'],
                'igdb_id' => $game['id'],
            ]);
            if ($collectionOption == 'wishlist') {
                try {
                    $wishlist = Wishlist::create([
                        'game_id' => $game['id'],
                        'user_id' => $current_user->id
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'error' => 'The game has already been added to your wishlist!',
                        'dev_error' => $e->getMessage()
                    ]);
                }

                return 'Added game to wishlist';
            } else {
                try {
                    $wishlist = Library::create([
                        'game_id' => $game['id'],
                        'user_id' => $current_user->id
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'error' => 'The game has already been added to your library!',
                        'dev_error' => $e->getMessage()
                    ]);
                }

                return 'Added game to library';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function singleGame(Request $request)
    {
        $tenYearsAgo = Carbon::now()->subYear(10);
        $now = Carbon::now();

        $input = $request->route('slug');

        $game = Game::where('slug', '=', $input)->with(['similar_games', 'genres', 'cover' => ['url', 'image_id']])->get();

        return Inertia::render('Games/Single', [
            'game' => $game[0]
        ]);
    }

    public function search()
    {
        return Inertia::render('Games/Search');
    }

    public function searchGame(Request $request)
    {
        $now = Carbon::now();

        $input = $request->input('search-game');

        if (!$input) {

            return redirect('/search');
        }

        $search_games = Game::search($input)->where('first_release_date', '<=', $now)->get();

        return Inertia::render('Games/Results', [
            'search_games' => $search_games
        ]);
    }

    public function displayWishlist()
    {
        $wishlist = Wishlist::wishlistGames(Auth::user()->id);

        $wishlist_games = [];

        foreach ($wishlist as $game) {
            $game = Videogame::getGamesById($game->game_id);
            array_push($wishlist_games, ...$game);
        }

        return Inertia::render('Games/Wishlist', ['wishlist_games' => $wishlist_games]);
    }

    public function displayLibrary()
    {
        $library = Library::libraryGames(Auth::user()->id);

        $library_games = [];

        foreach ($library as $game) {
            $game = Videogame::getGamesById($game->game_id);
            array_push($library_games, ...$game);
        }

        return Inertia::render('Games/Library', ['library_games' => $library_games]);
    }
}
