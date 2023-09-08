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

    .selected-category-button {
        display: inline-block;
        margin-top: 10px;
        margin-right: 5px;
        padding: 5px 10px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="form-group">
    <label for="categories">Categories (press cntr/cmd for multiple selection)</label>
    <div style="height: 8px;"></div>
    <input type="hidden" name="selectedCategories" id="selectedCategories" value="@json($selectedCategories)" style="border-radius: 6px;">
    
    <input type="text" id="categorySearch" class="form-control" placeholder="Search categories" style="border-radius: 6px;">
        
    <select multiple class="form-select" aria-label="Default select example" id="categories" style="border-radius: 6px;">
        @foreach($categories as $cat)
            <option
                {{ in_array($cat->id, $selectedCategories, true) ? 'selected' : '' }}
                value="{{ $cat->id }}"
            >
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>
    
    
    <div id="selectedCategoriesContainer">
        <!-- Qui compariranno i pulsanti delle categorie selezionate -->
    </div>
    <div style="height: 15px;"></div>
</div>

<script>
    function updateSelectedCount(selectElement) {
        const selectedCountElement = document.getElementById("selectedCount");
        const selectedCount = selectElement.selectedOptions.length;
        selectedCountElement.textContent = `Selected categories: ${selectedCount}`;
    }

    document.getElementById("categorySearch").addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase();
        const selectElement = document.getElementById("categories");
        
        Array.from(selectElement.options).forEach(option => {
            const categoryName = option.textContent.toLowerCase();
            const shouldShow = categoryName.includes(searchTerm);
            
            if (shouldShow) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    });

    const selectedCategoriesContainer = document.getElementById("selectedCategoriesContainer");
    const selectedCategoriesInput = document.getElementById("selectedCategories");

    document.getElementById("categories").addEventListener("change", function() {
        // Quando si verifica una modifica nella selezione delle categorie
        selectedCategoriesContainer.innerHTML = ""; // Cancella le categorie precedenti
        
        // Ottieni le opzioni selezionate
        const selectedOptions = Array.from(this.selectedOptions);
        
        // Aggiungi le categorie selezionate al contenitore
        selectedOptions.forEach(option => {
            const categoryId = option.value;
            const categoryName = option.textContent;
            addSelectedCategory(categoryId, categoryName);
        });
    });

    function addSelectedCategory(categoryId, categoryName) {
        // Crea un pulsante per la categoria selezionata
        const button = document.createElement("button");
        button.className = "selected-category-button";
        button.textContent = categoryName;
        button.setAttribute("data-category-id", categoryId);

        // Aggiungi un gestore per rimuovere la categoria quando si fa clic sulla "x"
        button.addEventListener("click", function() {
            const categoryIdToRemove = button.getAttribute("data-category-id");
            removeSelectedCategory(categoryIdToRemove);
        });

        // Aggiungi il pulsante al contenitore delle categorie selezionate
        selectedCategoriesContainer.appendChild(button);

        // Aggiungi l'ID della categoria all'input nascosto
        const selectedCategories = JSON.parse(selectedCategoriesInput.value || "[]");
        selectedCategories.push(categoryId);
        selectedCategoriesInput.value = JSON.stringify(selectedCategories);
    }

    function removeSelectedCategory(categoryId) {
        // Rimuovi il pulsante dalla vista
        const buttonToRemove = selectedCategoriesContainer.querySelector(`[data-category-id="${categoryId}"]`);
        if (buttonToRemove) {
            selectedCategoriesContainer.removeChild(buttonToRemove);
        }

        // Rimuovi l'ID della categoria dall'input nascosto
        const selectedCategories = JSON.parse(selectedCategoriesInput.value || "[]");
        const index = selectedCategories.indexOf(categoryId);
        if (index !== -1) {
            selectedCategories.splice(index, 1);
            selectedCategoriesInput.value = JSON.stringify(selectedCategories);
        }
    }

    // Carica le categorie selezionate inizialmente
    const selectedOptions = Array.from(document.getElementById("categories").selectedOptions);
    selectedOptions.forEach(option => {
        const categoryId = option.value;
        const categoryName = option.textContent;
        addSelectedCategory(categoryId, categoryName);
    });
</script>
