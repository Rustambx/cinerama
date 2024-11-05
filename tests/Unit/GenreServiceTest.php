<?php

namespace Tests\Unit;

use App\Models\Genre;
use App\Services\GenreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $genreService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genreService = new GenreService();
    }

    public function test_get_all_genres()
    {
        Genre::factory()->count(3)->create();

        $result = $this->genreService->getAllGenres();

        $this->assertCount(3, $result);
    }

    public function test_get_genre_by_id()
    {
        $genre = Genre::factory()->create(['name' => 'Comedy']);

        $result = $this->genreService->getGenreById($genre->id);

        $this->assertInstanceOf(Genre::class, $result);
        $this->assertEquals('Comedy', $result->name);
    }

    public function test_update_genre()
    {
        $genre = Genre::factory()->create(['name' => 'Drama']);

        $data = ['name' => 'Thriller'];
        $result = $this->genreService->updateGenre($genre->id, $data);

        $this->assertEquals('Thriller', $result->name);
        $this->assertDatabaseHas('genres', ['id' => $genre->id, 'name' => 'Thriller']);
    }

    public function test_delete_genre()
    {
        $genre = Genre::factory()->create(['name' => 'Horror']);

        $this->genreService->deleteGenre($genre->id);

        $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
    }
}
