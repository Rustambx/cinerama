@extends('layouts.admin')

@section('content')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Фильм</strong>
                    </div>
                    <div class="card-body card-block">
                        @include('includes.error-message')
                        <form action="{{ route('admin.movies.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Название</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Описание</label></div>
                                <div class="col-12 col-md-9">
                                    <textarea name="description" id="description" rows="9" class="form-control html-editor"></textarea>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="file-input" class=" form-control-label">Дата выпуска</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="date" id="release_date" name="release_date" class="form-control-file">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Жанры</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="genres[]" multiple id="selectLg" class="form-control-lg form-control">
                                        @if($genres->count() == 0)
                                            <option value="0">Жанров нет</option>
                                        @else
                                            <option value="0">Выберите жанр</option>
                                            @foreach($genres as $genre)
                                                <option value="{{$genre->id}}">
                                                    {{$genre->name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="file-input" class=" form-control-label">Обложка</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="cover" name="cover" class="form-control-file">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="file-input" class=" form-control-label">Трейлер</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="trailer" name="trailer" class="form-control-file">
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="submit" value="Сохранить" class="btn btn-primary btn-sm">
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
