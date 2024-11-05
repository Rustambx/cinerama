<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::select('id', 'name', 'cover')
            ->paginate(8);
        $genres = Genre::select('id', 'name')->get();

        return view('index', compact('movies', 'genres'));
    }

    public function show($id)
    {
        $movie = Movie::with('genres:id,name')->findOrFail($id);
        $genres = Genre::select('id', 'name')->get();

        return view('show', compact('movie', 'genres'));
    }

    public function search(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('genre_id')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre_id);
            });
        }

        $movies = $query->get();

        $genres = Genre::all();

        return view('results', compact('movies', 'genres'));
    }

}
