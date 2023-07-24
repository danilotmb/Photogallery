<div class="form-group">
    <label for="album_thumb">Thumbnail</label>
    <input  type="file" class="form-control" name="album_thumb" id="album_thumb" value="{{$album ->album_thumb}}">
</div>

@if($album ->album_thumb)
    <div class="mb-3">

        <img width="150" height="150" src="{{asset($album->album_thumb)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}">

    </div>
@endif