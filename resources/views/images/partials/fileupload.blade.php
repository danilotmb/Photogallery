<div class="form-group">
    <label for="img_path">Image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="img_path" id="img_path">
    </div>
</div>

@if ($image->img_path)
<div class="mb-3">
    <img
        src="{{ asset($image->img_path) }}"
        alt="{{ $image->name }}"
        title="{{ $image->name }}"
        width="150"
        height="150"
        style="max-width: 100%; height: 150px;"
    >
</div>
@endif
