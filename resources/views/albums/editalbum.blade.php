@php
    /**
     * @var $album App\Models\Album;
     * */
@endphp

@extends('templates.default')
@section('content')
    @php
        /**
         * @var $album App\Models\Album; 
         */
    @endphp
    <style>
        a.btn {
            width: 70px;
            height: 40px;     
        }

        h2{
            font-size: 30px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

<h2>Editing album : {{$album->album_name}}</h2>

@include('partials.inputerrors')

<form method="POST" action="{{route('albums.update', ['album' => $album->id])}}" enctype="multipart/form-data">


    @csrf
    @method('PATCH')

      
    <div class="form-group">
        <label for="album_name">Name</label>
        <input class="form-control" name="album_name"id="album_name" value="{{$album -> album_name}}">
    </div>

    
    @include('albums.partials.fileupload')

    @include('albums.partials.catergory_combo')

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description">{{$album ->description}}</textarea>
    </div>

    

    <div class="d-flex justify-content-end">

        <button type="submit" class="btn btn-success m-1"><i class="bi bi-check2-circle text-xl"></i></button>
        <a href="{{route('albums.index')}}" class="btn btn-secondary m-1"><i class="bi bi-skip-backward-fill text-xl"></i></a>
        <a href="{{route('albums.images', $album->id)}}" class="btn btn-primary m-1"><i class="bi bi-images text-xl"></i></a>

    </div>


    


</form>
@endsection