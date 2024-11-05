<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Role;
use Mockery;
use App\Services\MovieService;
use App\Models\User;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $movieServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        Role::factory()->create(['name' => 'admin']);
        Genre::factory()->count(3)->create(); // Создаем несколько жанров для тестов

        $this->movieServiceMock = Mockery::mock(MovieService::class);
        $this->app->instance(MovieService::class, $this->movieServiceMock);
    }

    protected function actingAsAdmin()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->actingAs($admin);
    }

    public function test_create()
    {
        $this->actingAsAdmin();

        $genres = Genre::factory()->count(3)->create();

        $this->movieServiceMock->shouldReceive('getAllGenres')->once()->andReturn($genres);

        $response = $this->get(route('admin.movies.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.movies.create');
        $response->assertViewHas('genres');
    }

    public function test_store()
    {
        $this->actingAsAdmin();

        $file = UploadedFile::fake()->image('cover.jpg');
        $video = UploadedFile::fake()->create('trailer.mp4', 100);
        $genres = Genre::factory()->count(3)->create();

        $data = [
            'name' => 'Test Movie',
            'description' => 'Test Description',
            'release_date' => '2024-11-01',
            'cover' => $file,
            'trailer' => $video,
            'genres' => $genres->pluck('id')->toArray()
        ];

        $this->movieServiceMock->shouldReceive('createMovie')->once()->with($data)->andReturn(new Movie($data));

        $response = $this->post(route('admin.movies.store'), $data);

        $response->assertRedirect(route('admin.movies.index'));
        $response->assertSessionHas('success', 'Фильм успешно создан');
    }

    public function test_edit()
    {
        $this->actingAsAdmin();

        $movie = Movie::factory()->create();
        $genres = Genre::factory()->count(3)->create();
        $this->movieServiceMock->shouldReceive('getMovieById')->with($movie->id)->once()->andReturn($movie);
        $this->movieServiceMock->shouldReceive('getAllGenres')->once()->andReturn($genres);

        $response = $this->get(route('admin.movies.edit', $movie->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.movies.edit');
        $response->assertViewHas('movie', $movie);
        $response->assertViewHas('genres');
    }

    public function test_update()
    {
        $this->actingAsAdmin();

        $movie = Movie::factory()->create();
        $file = UploadedFile::fake()->image('new_cover.jpg');
        $video = UploadedFile::fake()->create('new_trailer.mp4', 100);
        $genres = Genre::all()->pluck('id')->toArray();

        $data = [
            'name' => 'Updated Movie',
            'description' => 'Updated Description',
            'release_date' => '2024-12-01',
            'cover' => $file,
            'trailer' => $video,
            'genres' => $genres
        ];

        $this->movieServiceMock->shouldReceive('updateMovie')->once()->with($movie->id, $data);

        $response = $this->put(route('admin.movies.update', $movie->id), $data);

        $response->assertRedirect(route('admin.movies.index'));
        $response->assertSessionHas('success', 'Фильм успешно обновлен');
    }

    public function test_destroy()
    {
        $this->actingAsAdmin();

        $movie = Movie::factory()->create();
        $this->movieServiceMock->shouldReceive('deleteMovie')->once()->with($movie->id);

        $response = $this->delete(route('admin.movies.destroy', $movie->id));

        $response->assertRedirect(route('admin.movies.index'));
        $response->assertSessionHas('success', 'Фильм успешно удален');
    }
}
