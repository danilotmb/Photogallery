@php
    /**
     * @var $album App\Models\Album;
     * */
@endphp

@extends('templates.default')
@section('content')
    @php
        /**
         * @var $album App\Models\Photo; 
         */
    @endphp

   @include('partials.inputerrors')

    @if($photo->id)
   
        <h3>EDIT IMAGE : {{$album->album_name}}</h3>


        <form method="post" action="{{route('photos.update', $photo)}}" enctype="multipart/form-data">

    @method('PATCH')

    @else
            <h3>NEW IMAGE FOR ALBUM: {{$photo->name}}</h3>

            <form method="post" action="{{route('photos.store', $photo)}}" enctype="multipart/form-data">
    @endif

    @csrf

    <div class="form-group">
        <label for="album_id">Album</label>
        <select  name="album_id" id="album_id">

            <option value="">SELECT</option>

            @foreach ($albums as $item )

            <option {{$item->id === $album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
                
            @endforeach

        </select>
    </div> 



    <!--{{method_field('PATCH')}}
    <input type="hidden" name="_method" value="PATCH">
    -->
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" name="name" id="name" value="{{$photo -> name}}">
    </div>

    
    @include('images.partials.fileupload')

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description">{{$photo ->description}}</textarea>
    </div>

    <div class="form-group">

        <button class="btn btn-primary">DONE</button>

    </div>


</form>
@endsection