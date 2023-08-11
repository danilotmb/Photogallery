@extends('templates.default')

@section('content')
    @php
        /**
         * @var $album App\Models\Photo;
         */
    @endphp

    <style>
        h2 {
            font-size: 30px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
        }

        .btn-primary {
            background-color: green;
            width: 120px;
        }
    </style>

    @include('partials.inputerrors')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if($photo->id)
                            <h2 class="text-center display-4 fw-bold mb-4">EDIT IMAGE: {{ $album->album_name }}</h2>
                        @else
                            <h2 class="text-center display-4 fw-bold mb-4">NEW IMAGE FOR: {{ $album->album_name }}</h2>
                        @endif

                        <form method="post" action="{{ $photo->id ? route('photos.update', $photo) : route('photos.store', $photo) }}" enctype="multipart/form-data">
                            @csrf
                            @if($photo->id)
                                @method('PATCH')
                            @endif

                            <div class="form-group">
                                <label for="album_id">Album</label>
                                <select name="album_id" id="album_id" class="form-control">
                                    <option value="">SELECT</option>
                                    @foreach ($albums as $item)
                                        <option {{ $item->id === $album->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->album_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" id="name" value="{{ $photo->name }}">
                            </div>

                            @include('images.partials.fileupload')

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description">{{ $photo->description }}</textarea>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary">DONE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
