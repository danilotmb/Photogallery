@extends('templates.default')
@section('content')

    @if(session()->has('message'))
        <x-alert-info>{{session()->get('message')}}</x-alert-info>
    @endif
    
   

        <table class="table table-hover albums" style="width: 100%">
            <thead>
            <tr class="align-middle">
                <th scope="col">#</th>
                <th scope="col">Album name</th>
                <th scope="col">Thumb</th>
                <th scope="col">Author</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>

            @foreach($albums as $album)
            <tr id="tr{{$album->id}}" class="align-middle">
                <td>{{$album->id}}</td>
                <td> {{$album->album_name}}</td>
                <td>
                    @if($album -> album_thumb)
                            
                            <img width="150" height="150" src="{{asset($album->album_thumb)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}">

                     @endif
                </td>

                
                <td>{{$album->user->name}}</td>
                <td>{{$album->created_at->diffForHumans()}}</td>

                    <td>

                        <div class="row g-0" >
                            <div class="col-md-3" >
                                <a title="Add new image" href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-primary ">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                            </div>

                            <div class="col-md-3" >
                                @if($album->photos_count)          
                                    <a title="View all images" href="{{route('albums.images', $album)}}" class="btn btn-primary">
                                        <i class="bi bi-image"></i> {{$album->photos_count}}
                                    </a>
                                @else          
                                    <a class="btn btn-primary" onclick="showAlert()"><i class="bi-image"></i></a>          
                                @endif
                            </div>

                            <div class="col-md-3" >
                                <a title="Edit image" href="{{route('albums.edit', $album)}}" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>

                            <div class="col-md-3" >
                                <form id="form{{$album->id}}" method="POST" action="{{route('albums.destroy', $album)}}">
                                    @csrf
                                    @method('DELETE')
                                        <button id="{{$album->id}}" title="Delete Album" class="btn btn-danger ">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                        
                                </form>

                            </div>
                        </div>
                        <div id="myAlertContainer"></div>
                    </td>

            </tr>
            @endforeach
            <tr>
                <td colspan="5">
                    <div class="row">
                        <div

                            class="col-md-8 offset-md-2 d-flex justify-content-center">
                            {{$albums->links('vendor.pagination.bootstrap-4')}}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            $('div.alert-info').fadeOut(5000);
            $('table').on('click', 'a.btn-danger', function (evt) {
                evt.preventDefault();

                var id = evt.target.id;
                var f = $('#form' + id);
                var urlAlbum = f.attr('action');
                var tr = $('#tr'+id);
                $.ajax(
                    urlAlbum,
                    {
                        method: 'DELETE',
                        data: {
                            '_token' : {{csrf_token()}}
                        },
                        complete: function (resp) {
                            console.log(resp);
                            if (resp.responseText == 1) {

                                tr.remove();
                                
                            } else {
                                alert('Problem contacting server');
                            }
                        }
                    }
                )
            });
        });
    </script>

<script>
    function showAlert() {
      var alertContainer = document.getElementById('myAlertContainer');
      var alertHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Non ci sono ancora foto in questo album. <a href="#" class="alert-link">Aggiungi foto</a> per visualizzarle.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      alertContainer.innerHTML = alertHTML;
    
     
      setTimeout(function() {
        alertContainer.querySelector('.alert').classList.remove('show'); 
        setTimeout(function() {
          alertContainer.innerHTML = ''; 
        }, 500);
      }, 4000);
    }
    </script>
    
    
    
@endsection