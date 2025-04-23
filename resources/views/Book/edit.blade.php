<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            margin-top: 60px;
        }

        h2 {
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary, .btn-secondary {
            border-radius: 25px;
            font-weight: 600;
        }

        .btn i {
            margin-right: 6px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">📚 BookShelf</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-white"><i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name ?? 'Guest' }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
        </form>
    </div>
</nav>

<div class="container">
    <div class="form-container mx-auto col-md-8">
        <h2><i class="fas fa-edit me-2"></i>Edit Book</h2>
        @if($book->cover_image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Book Cover"
                     class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle me-1"></i>{{ session('error') }}
            </div>
        @endif

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input value="{{ old('title', $book->title) }}" type="text" name="title" id="title" class="form-control"
                       required>
            </div>

            <input type="hidden" name="author_id" value="{{ auth('web')->user()->id }}">

            <!-- Visible field for author name (readonly) -->
            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="author_name" value="{{ auth('web')->user()->name }}"
                       readonly>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control">{{ old('description', $book->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input value="{{ old('price', $book->price) }}" type="number" step="0.01" name="price" id="price"
                           class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input value="{{ old('isbn', $book->isbn) }}" type="text" name="isbn" id="isbn"
                           class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="published_at" class="form-label">Published Date</label>
                    <input
                        value="{{ old('published_at', $book->published_at ? date('Y-m-d', strtotime($book->published_at)) : '') }}"
                        type="date" name="published_at" id="published_at" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input value="{{ old('stock', $book->stock) }}" type="number" name="stock" id="stock"
                           class="form-control" required>
                </div>
            </div>
            <div class='row'>
                <div class=" col mb-3">
                    <label for="language_id" class="form-label">Language</label>
                    <select class="form-select" name="language_id" id="language_id" required>
                        @foreach($languages as $language)
                            <option
                                value="{{ $language->id }}" {{ $book->language->id == $language->id ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class=" col mb-3">
                    <label for="language_id" class="form-label">Book Type</label>
                    <select class="form-select" name="type_id" id="type_id" required>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ $book->type->id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                </dev>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pages" class="form-label">Pages</label>
                        <input value="{{ old('pages', $book->pages) }}" type="number" name="pages" id="pages"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3 form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="is_valid" id="is_valid"
                               value="1" {{ $book->is_valid ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_valid">Valid for Publishing</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cover_image" class="form-label">Cover Image</label>

                    <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="book_pdf" class="form-label">PDF File</label>
                    @if($book->pdf_copy)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $book->pdf_copy) }}" target="_blank"><i
                                    class="fas fa-file-pdf me-1"></i>View Current PDF</a>
                        </div>
                    @endif
                    <input type="file" name="pdf" id="book_pdf" class="form-control" accept="application/pdf">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
