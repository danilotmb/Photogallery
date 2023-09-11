@php
/**
 * @var $album App\Models\Album;
 */
@endphp

@extends('templates.default')
@section('content')
@php
/**
 * @var $album App.Models.Album;
 */
@endphp
<style>
    a.btn {
        width: 70px;
        height: 40px;
    }

    h2 {
        font-size: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    label 
    {
        font-weight: bold !important;
    }
</style>

<h2 class="text-center display-4 fw-bold mb-4">Editing album : {{ $album->album_name }}</h2>

@include('partials.inputerrors')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @include('partials.inputerrors')

                    <form method="POST" action="{{ route('albums.update', ['album' => $album->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="album_name" class="form-label">Album Name</label>
                            <input type="text" class="form-control" name="album_name" id="album_name" value="{{ $album->album_name }}" style="border-radius: 6px;">
                        </div>

                        @include('albums.partials.fileupload')

                        @include('albums.partials.catergory_combo')

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description">{{ $album->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Button group">
                                <button type="submit" class="btn btn-success m-1" style="background-color: green; width: 70px; height:40px "><i class="bi bi-check2-circle text-xl"></i></button>
                                <a href="{{ route('albums.index') }}" class="btn btn-secondary m-1"><i class="bi bi-skip-backward-fill text-xl"></i></a>
                                <a href="{{ route('albums.images', $album->id) }}" class="btn btn-primary m-1"><i class="bi bi-images text-xl"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
