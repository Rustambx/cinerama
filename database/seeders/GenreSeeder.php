<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Фэнтези', 'Боевик', 'Драма', 'Триллер', 'Приключения',
            'Фантастика', 'Комедия', 'Романтика', 'Криминал', 'Детектив'
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
