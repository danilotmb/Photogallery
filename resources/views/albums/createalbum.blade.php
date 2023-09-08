@extends('templates.default')
@section('content')
<style>
label {
    font-weight: bold !important;
}
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center display-4 fw-bold mb-4">Create New Album</h1>
            <div class="card">
                <div class="card-body">
                    @include('partials.inputerrors')

                    <form method="post" action="{{route('albums.store')}}" enctype="multipart/form-data"> 
                        @csrf
                        <div class="mb-3">
                            <label for="album_name" class="form-label">Album Name</label>
                            <input type="text" class="form-control" name="album_name" id="album_name" placeholder="Enter Album Name" value="{{ old('album_name') }}" style="border-radius: 6px;">
                        </div>
                        

                        @include('albums.partials.fileupload')

                        @include('albums.partials.catergory_combo')

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Album Description">{{old('description')}}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success " style="background-color: green">Create Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
