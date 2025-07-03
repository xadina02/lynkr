<!-- resources/views/brands/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lynkr</title>
    @vite(['resources/css/pages/brand-create.css', 'resources/js/brands/edit.js'])
</head>

<body class="body-div min-h-screen flex flex-col">
    <div class="form-container" data-brand-id="{{ $brandId }}">
        <h1 class="form-title">Update Brand</h1>

        <div id="form-error" class="form-error"></div>

        <form id="update-brand-form" class="brand-form">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <input type="number" id="rating" name="rating" min="1" max="5" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Upload New Image</label>
                <input type="file" id="image" name="image" class="form-input" accept="image/*">
            </div>

            <div class="form-group">
                <label for="countries" class="form-label">Attach Countries</label>
                <select id="countries" name="country_codes[]" class="form-input" multiple required>
                    <!-- Populated by JS -->
                </select>
            </div>

            <button type="submit" class="submit-button">Update Brand</button>
        </form>
    </div>
</body>
</html>
