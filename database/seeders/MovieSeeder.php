<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Определение путей к оригинальным файлам обложки и трейлера
        $sourceCoverPath = storage_path('app/public/covers/original-cover.jpg');
        $sourceTrailerPath = storage_path('app/public/trailers/original-trailer.mp4');

        // Проверка существования оригинального файла обложки
        if (!file_exists($sourceCoverPath)) {
            $this->command->error('Исходное изображение обложки не найдено ' . $sourceCoverPath);
            return;
        }

        // Проверка существования оригинального файла трейлера
        if (!file_exists($sourceTrailerPath)) {
            $this->command->error('Исходный трейлер видео не найден ' . $sourceTrailerPath);
            return;
        }

        // Определение директорий назначения для обложек и трейлеров
        $destinationCoverDir = storage_path('app/public/covers');
        $destinationTrailerDir = storage_path('app/public/trailers');

        // Создание директории для обложек, если её нет
        if (!file_exists($destinationCoverDir)) {
            mkdir($destinationCoverDir, 0755, true);
        }

        // Создание директории для трейлеров, если её нет
        if (!file_exists($destinationTrailerDir)) {
            mkdir($destinationTrailerDir, 0755, true);
        }

        // Получение всех жанров из базы данных
        $genres = Genre::all();

        // Проверка наличия жанров
        if ($genres->isEmpty()) {
            $this->command->error('Жанры не найдены. Сначала запустите GenreSeeder.');
            return;
        }

        // Цикл для создания 10 фильмов
        for ($i = 1; $i <= 10; $i++) {
            // Генерация уникальных имен для файлов обложек и трейлеров
            $newCoverName = 'cover_' . $i . '.jpg';
            $newTrailerName = 'trailer_' . $i . '.mp4';
            $newCoverPath = $destinationCoverDir . '/' . $newCoverName;
            $newTrailerPath = $destinationTrailerDir . '/' . $newTrailerName;

            // Копирование оригиналных файлов с новыми именами в директорию
            copy($sourceCoverPath, $newCoverPath);
            copy($sourceTrailerPath, $newTrailerPath);

            // Создание записи фильма в базе данных
            $movie = Movie::create([
                'name' => 'Movie ' . $i,
                'description' => 'Description for movie ' . $i,
                'release_date' => now()->subDays($i),
                'cover' => 'covers/' . $newCoverName, // Сохранение пути к обложке
                'trailer' => 'trailers/' . $newTrailerName, // Сохранение пути к трейлеру
            ]);

            // Привязка случайных жанров к фильму (от 1 до 3)
            $randomGenres = $genres->random(rand(1, 3))->pluck('id');
            $movie->genres()->attach($randomGenres);
        }

        $this->command->info('Фильмы успешно добавлены.');
    }
}
