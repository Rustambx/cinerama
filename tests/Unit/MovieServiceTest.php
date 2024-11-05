<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\Genre;
use App\Services\MovieService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MovieServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MovieService $movieService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->movieService = new MovieService();
        Storage::fake('public');
    }

    public function test_get_all_movies()
    {
        Movie::factory()->count(3)->create();

        $movies = $this->movieService->getAllMovies();

        $this->assertCount(3, $movies);
    }

    public function test_create_movie()
    {
        $genres = Genre::factory()->count(2)->create();

        $file = UploadedFile::fake()->image('cover.jpg');
        $video = UploadedFile::fake()->create('trailer.mp4', 100);

        $data = [
            'name' => 'Test Movie',
            'description' => 'Test Description',
            'release_date' => '2024-11-01',
            'cover' => $file,
            'trailer' => $video,
            'genres' => $genres->pluck('id')->toArray()
        ];

        $movie = $this->movieService->createMovie($data);

        $this->assertDatabaseHas('movies', ['name' => 'Test Movie']);
        $this->assertNotNull($movie->cover);
        $this->assertNotNull($movie->trailer);

        $coverPath = storage_path('app/public/' . $movie->cover);
        $trailerPath = storage_path('app/public/' . $movie->trailer);

        if (file_exists($coverPath)) {
            unlink($coverPath);
        }

        if (file_exists($trailerPath)) {
            unlink($trailerPath);
        }
    }

    public function test_get_movie_by_id()
    {
        $movie = Movie::factory()->create();

        $foundMovie = $this->movieService->getMovieById($movie->id);

        $this->assertEquals($movie->id, $foundMovie->id);
    }

    public function test_update_movie()
    {
        $genres = Genre::factory()->count(1)->create();

        $movie = Movie::factory()->create();

        $data = [
            'name' => 'Updated Movie',
            'genres' => $genres->pluck('id')->toArray()
        ];

        $updatedMovie = $this->movieService->updateMovie($movie->id, $data);

        $this->assertEquals('Updated Movie', $updatedMovie->name);
    }

    public function test_delete_movie()
    {
        $movie = Movie::factory()->create();

        $this->movieService->deleteMovie($movie->id);

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);

        Storage::disk('public')->assertMissing($movie->cover);
        Storage::disk('public')->assertMissing($movie->trailer);
    }

    public function test_get_all_genres()
    {
        Genre::factory()->count(5)->create();

        $genres = $this->movieService->getAllGenres();

        $this->assertCount(5, $genres);
    }
}
