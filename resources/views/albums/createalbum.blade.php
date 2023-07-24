@extends('templates.default')
@section('content')

<h3>CREATE NEW ALBUM</h3>

@include('partials.inputerrors')

<form method="post" action="{{route('albums.store')}}" enctype="multipart/form-data"> 
      @csrf
    <div class="form-group mb-3">
        <label for="album_name">Name</label>
        <input  class="form-control" name="album_name"id="album_name" placeholder="Album Name" value="{{old('album_name')}}">
    </div>

    @include('albums.partials.fileupload')

    <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" placeholder="Album Description">{{old('description')}}</textarea>

    </div>

    <div class="form-group mb-3">

        <button class="btn btn-primary">DONE</button>

    </div>


</form>
@endsection