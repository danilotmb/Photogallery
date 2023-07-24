@extends('templates.default')
@section('content')
    <div class="row">
        @foreach($albums as $album)
            <div class="col-sm-5 col-md-4 col-lg-3">
                <div class="card m-2" >
                    <a href="{{route('gallery.albums.images', $album->id)}}">
                        <img src="{{asset($album->album_thumb)}}" class="card-img-top img-fluid rounded"
                            alt="{{$album->album_name}}" title="{{$album->album_name}}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><a
                                href="{{route('gallery.albums.images', $album->id)}}">{{$album->album_name}}</a></h5>
                        <p class="card-text">{{$album->album_description}}</p>
                        <p class="card-text">{{$album->created_at->diffForHumans()}}</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
@endsection