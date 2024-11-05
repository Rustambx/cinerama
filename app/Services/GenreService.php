<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllGenres(): Collection
    {
        return Genre::all();
    }

    /**
     * @param array $data
     * @return Genre
     */
    public function createGenre(array $data): Genre
    {
        return Genre::create($data);
    }

    /**
     * @param string $id
     * @return Genre
     */
    public function getGenreById(string $id): Genre
    {
        return Genre::findOrFail($id);
    }

    /**
     * @param string $id
     * @param array $data
     * @return Genre
     */
    public function updateGenre(string $id, array $data): Genre
    {
        $genre = $this->getGenreById($id);
        $genre->update($data);

        return $genre;
    }

    /**
     * @param string $id
     * @return void
     */
    public function deleteGenre(string $id): void
    {
        $genre = $this->getGenreById($id);

        $genre->delete();
    }
}
