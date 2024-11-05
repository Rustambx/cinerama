<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Services\MovieService;
use Image;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService->getAllMovies();

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = $this->movieService->getAllGenres();

        return view('admin.movies.create', compact('genres'));
    }

    public function store(StoreMovieRequest $request)
    {
        $data = $request->validated();
        $this->movieService->createMovie($data);

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно создан');
    }

    public function edit($id)
    {
        $movie = $this->movieService->getMovieById($id);
        $genres = $this->movieService->getAllGenres();

        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    public function update(UpdateMovieRequest $request, $id)
    {
        $data = $request->validated();
        $this->movieService->updateMovie($id, $data);

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлен');
    }

    public function destroy($id)
    {
        $this->movieService->deleteMovie($id);

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно удален');
    }
}
