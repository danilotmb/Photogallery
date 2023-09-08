<div class="form-group">
    <label for="album_thumb">Thumbnail</label>
    <div style="height: 8px;"></div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="album_thumb" id="album_thumb">
    </div>
</div>

@if ($album->album_thumb)
<div class="mb-3">
    <img
        src="{{ asset($album->album_thumb) }}"
        alt="{{ $album->album_name }}"
        title="{{ $album->album_name }}"
        width="150"
        height="150"
        style="max-width: 100%; height: auto;"
    >
</div>
@endif

<!-- Spazio di 15px al di sotto del div -->
<div style="height: 15px;"></div>
