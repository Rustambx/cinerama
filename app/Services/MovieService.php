<?php

namespace App\Services;

use App\Http\Helpers\FileUploader;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class MovieService
{
    /**
     * @return Collection
     */
    public function getAllMovies(): Collection
    {
        return Movie::select('id', 'name', 'release_date')
            ->with(['genres:id,name'])
            ->get();
    }

    /**
     * @param array $data
     * @return Movie
     */
    public function createMovie(array $data): Movie
    {
        if (isset($data['cover'])) {
            $data['cover'] = FileUploader::uploadImage($data['cover'], 'covers');
        }

        if (isset($data['trailer'])) {
            $data['trailer'] = FileUploader::uploadVideo($data['trailer'], 'trailers');
        }

        $movie = Movie::create($data);

        if (isset($data['genres'])) {
            $movie->genres()->attach($data['genres']);
        }

        return $movie;
    }

    /**
     * @param $id
     * @return Movie
     */
    public function getMovieById($id): Movie
    {
        return Movie::findOrFail($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return Movie
     */
    public function updateMovie($id, array $data): Movie
    {
        $movie = Movie::findOrFail($id);

        if (isset($data['cover'])) {
            Storage::disk('public')->delete($movie->cover);
            $data['cover'] = FileUploader::uploadImage($data['cover'], 'covers');
        }

        if (isset($data['trailer'])) {
            if ($movie->trailer ==! null) {
                Storage::disk('public')->delete($movie->trailer);
            }
            $data['trailer'] = FileUploader::uploadVideo($data['trailer'], 'trailers');
        }

        $movie->update($data);

        if (isset($data['genres'])) {
            $movie->genres()->sync($data['genres']);
        }

        return $movie;
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteMovie($id): void
    {
        $movie = Movie::findOrFail($id);
        Storage::disk('public')->delete($movie->cover);
        if ($movie->trailer ==! null) {
            Storage::disk('public')->delete($movie->trailer);
        }

        $movie->delete();
    }

    /**
     * @return Collection
     */
    public function getAllGenres(): Collection
    {
        return Genre::all();
    }
}
