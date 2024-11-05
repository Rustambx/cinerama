@extends('layouts.public')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @foreach($movies as $movie)
                <div class="col-md-3 mb-4">
                    <div class="card movie-card">
                        <a href="{{ route('show', $movie->id) }}" class="stretched-link">
                            <img src="{{ asset('storage/' . $movie->cover) }}" class="card-img-top" alt="{{ $movie->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="movie-title">{{ $movie->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $movies->links('pagination::bootstrap-4') }}
    </div>
@endsection
