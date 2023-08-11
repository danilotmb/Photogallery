<style>
    .form-group {
        position: relative;
    }

    #categories {
        width: 100%;
    }

    #selectedCount {
        position: absolute;
        right: 20px;
        bottom: 0;
        margin: 0;
        font-size: 12px;
        color: #535353;
    }
</style>

<div class="form-group">
    <label for="categories">Categories</label>
    <input type="hidden" name="selectedCategories" value="@json($selectedCategories)">
    
    <select multiple class="form-select" aria-label="Default select example">
        @foreach($categories as $cat)
            <option
                {{ in_array($cat->id, $selectedCategories, true) ? 'selected' : '' }}
                value="{{ $cat->id }}"
            >
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>

    <p id="selectedCount">Selected categories: {{ count($selectedCategories) }}</p>
    
</div>


<script>
    function updateSelectedCount(selectElement) {
        const selectedCountElement = document.getElementById("selectedCount");
        const selectedCount = selectElement.selectedOptions.length;
        selectedCountElement.textContent = `Selected categories: ${selectedCount}`;
    }
</script>
