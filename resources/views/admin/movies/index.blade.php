@extends('layouts.admin')

@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    @include('includes.result-message')
                    <div class="card-body">
                        <a href="{{route('admin.movies.create')}}" class="btn btn-primary">Создать Фильм</a>
                    </div>
                    <div class="card-header">
                        <strong class="card-title">Список фильмов</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Дата выпуска</th>
                                <th>Жанры</th>
                                <th>Редактирование</th>
                                <th>Удаление</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($movies)
                                @foreach($movies as $movie)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.movies.edit', $movie->id) }}">{{ $movie->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.movies.edit', $movie->id) }}">{{ $movie->release_date }}</a>
                                        </td>
                                        <td>
                                            {{ $movie->genres->pluck('name')->join(', ') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-success">Редактировать</a>
                                        </td>
                                        <td>
                                            <form method="post" action="{{ route('admin.movies.destroy', $movie->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>Фильмов нет</p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
@endsection
