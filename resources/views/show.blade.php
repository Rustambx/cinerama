@extends('layouts.public')

@section('content')
    <div class="container movie-details">
        <h1 class="movie-title">
            {{ $movie->name }}
            <span class="genre">
                ({{ $movie->genres->pluck('name')->join(', ') }})
            </span>
        </h1>
        <p>Дата выхода: {{ $movie->release_date }}</p>
        <p class="description">
            Описание: {{ $movie->description }}
        </p>

        <div class="mt-4">
            @if($movie->trailer)
                <video id="player" playsinline controls>
                    <source src="{{ asset('storage/' . $movie->trailer) }}" />
                    Ваш браузер не поддерживает видео.
                </video>
            @else
                <h2 class="text-center">Нет трейлера</h2>
            @endif
        </div>
    </div>
@endsection
