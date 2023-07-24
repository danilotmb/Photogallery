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
    </style>
<h3>EDIT ALBUM : {{$album->album_name}}</h3>

@include('partials.inputerrors')

<form method="post" action="{{route('albums.update', ['album' => $album -> id])}}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!--{{method_field('PATCH')}}
    <input type="hidden" name="_method" value="PATCH">
    -->
      
    <div class="form-group">
        <label for="album_name">Name</label>
        <input class="form-control" name="album_name"id="album_name" value="{{$album -> album_name}}">
    </div>

    
    @include('albums.partials.fileupload')

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description">{{$album ->description}}</textarea>
    </div>

    <div class="d-flex justify-content-end">

        <a title="Done" class="btn btn-success m-1"><i class="bi bi-check2-circle text-xl"></i></a>
        <a title="Back" href="{{route('albums.index')}}" class="btn btn-secondary m-1"><i class="bi bi-skip-backward-fill text-xl"></i></a>
        <a title="Images" href="{{route('albums.images', $album->id)}}" class="btn btn-primary m-1"><i class="bi bi-images text-xl"></i></a>

    </div>


</form>
@endsection