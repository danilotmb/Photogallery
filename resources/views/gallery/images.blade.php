@extends('templates.default')
@section('content')
    <div class="row">
        @foreach($images as $image)
            <div class="col-sm-5 col-md-4 col-lg-3">
                <div class="card m-2" >
                    <a href="{{asset($image->img_path)}}" data-lightbox="{{$album->album_name}}">
                        <img src="{{asset($image->img_path)}}" class="card-img-top img-fluid rounded"
                            alt="{{$image->name}}" title="{{$image->name}}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{$image->name}}</h5>          
                    </div>
                </div>
            </div>

        @endforeach
        
    </div>

    <div class="row d-flex flex-row-reverse">
        <div>
            {{$images->links('vendor.pagination.bootstrap-5')}}
        </div>
    </div>
@endsection