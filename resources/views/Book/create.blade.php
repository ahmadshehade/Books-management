<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            margin-top: 50px;
        }
        h2 {
            margin-bottom: 25px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container mx-auto col-md-8">
        <h2>Add New Book</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>

            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name</label>
                <input type="text" class="form-control" name="author_name" id="author_name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Book Description</label>
                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price" required>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="isbn">
            </div>

            <div class="mb-3">
                <label for="published_at" class="form-label">Published Date</label>
                <input type="date" class="form-control" name="published_at" id="published_at">
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" name="stock" id="stock" required>
            </div>

            <div class="mb-3">
                <label for="language" class="form-label">Language</label>
                <input type="text" class="form-control" name="language" id="language" required>
            </div>

            <div class="mb-3">
                <label for="pages" class="form-label">Number of Pages</label>
                <input type="number" class="form-control" name="pages" id="pages">
            </div>

            <div class="mb-3">
                <label for="is_valid" class="form-label">Is Valid for Publishing?</label>
                <select class="form-select" name="is_valid" id="is_valid">
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" name="cover_image" id="cover_image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Save Book</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
