<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use App\Services\GenreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class GenreControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $genreServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        Role::factory()->create(['name' => 'admin']);

        $this->genreServiceMock = Mockery::mock(GenreService::class);
        $this->app->instance(GenreService::class, $this->genreServiceMock);
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

        $response = $this->get(route('admin.genres.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.genres.create');
    }

    public function test_store()
    {
        $this->actingAsAdmin();

        $data = ['name' => 'Action'];

        $this->genreServiceMock->shouldReceive('createGenre')->once()->with($data);

        $response = $this->post(route('admin.genres.store'), $data);

        $response->assertRedirect(route('admin.genres.index'));
        $response->assertSessionHas('success', 'Жанр создан успешно');
    }

    public function test_edit()
    {
        $this->actingAsAdmin();

        $genre = Genre::factory()->make(['id' => 1, 'name' => 'Comedy']);
        $this->genreServiceMock->shouldReceive('getGenreById')->with($genre->id)->once()->andReturn($genre);

        $response = $this->get(route('admin.genres.edit', $genre->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.genres.edit');
        $response->assertViewHas('genre', $genre);
    }

    public function test_update()
    {
        $this->actingAsAdmin();

        $genre = Genre::factory()->make(['id' => 1, 'name' => 'Comedy']);
        $data = ['name' => 'Thriller'];

        $this->genreServiceMock->shouldReceive('updateGenre')->once()->with($genre->id, $data);

        $response = $this->put(route('admin.genres.update', $genre->id), $data);

        $response->assertRedirect(route('admin.genres.index'));
        $response->assertSessionHas('success', 'Жанр успешно обновлен');
    }

    public function test_destroy()
    {
        $this->actingAsAdmin();

        $genreId = 1;

        $this->genreServiceMock->shouldReceive('deleteGenre')->once()->with($genreId);

        $response = $this->delete(route('admin.genres.destroy', $genreId));

        $response->assertRedirect(route('admin.genres.index'));
        $response->assertSessionHas('success', 'Жанр успешно удален');
    }
}
