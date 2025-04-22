<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">✏️ Edit Book</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input value="{{ old('title', $book->title) }}" type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="author_name" class="form-label">Author Name</label>
            <input value="{{ old('author_name', $book->author_name) }}" type="text" name="author_name" id="author_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $book->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input value="{{ old('price', $book->price) }}" type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            @if($book->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover" style="width: 100px; height: 130px; object-fit: cover; border-radius: 5px;">
                </div>
            @endif
            <input type="file" name="cover_image" id="cover_image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input value="{{ old('isbn', $book->isbn) }}" type="text" name="isbn" id="isbn" class="form-control">
        </div>

        <div class="mb-3">
            <label for="published_at" class="form-label">Published At</label>
            <input value="{{ old('published_at', $book->published_at ? date('Y-m-d', strtotime($book->published_at)) : '') }}" type="date" name="published_at" id="published_at" class="form-control">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input value="{{ old('stock', $book->stock) }}" type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="language" class="form-label">Language</label>
            <input value="{{ old('language', $book->language) }}" type="text" name="language" id="language" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="pages" class="form-label">Pages</label>
            <input value="{{ old('pages', $book->pages) }}" type="number" name="pages" id="pages" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="is_valid" id="is_valid" value="1" {{ $book->is_valid ? 'checked' : '' }}>
            <label class="form-check-label" for="is_valid">Is Valid</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Book</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary w-100 mt-2">Back</a>
    </form>
</div>

</body>
</html>
