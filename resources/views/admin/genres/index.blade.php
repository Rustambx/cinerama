@extends('layouts.admin')

@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    @include('includes.result-message')
                    <div class="card-body">
                        <a href="{{route('admin.genres.create')}}" class="btn btn-primary">Создать Жанр</a>
                    </div>
                    <div class="card-header">
                        <strong class="card-title">Список жанров</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Редактирование</th>
                                <th>Удаление</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($genres)
                                @foreach($genres as $genre)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.genres.edit', $genre->id) }}">{{ $genre->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn btn-success">Редактировать</a>
                                        </td>
                                        <td>
                                            <form method="post" action="{{ route('admin.genres.destroy', $genre->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p>Категории нет</p>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
@endsection
