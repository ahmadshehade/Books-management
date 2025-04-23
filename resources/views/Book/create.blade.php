<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef1f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
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

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 25px;
            font-weight: 600;
        }

        .btn-primary i {
            margin-right: 6px;
        }

        .alert {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container mx-auto col-md-8">
        <h2><i class="fas fa-plus-circle me-2"></i>Add New Book</h2>

        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}</div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>

            <input type="hidden" name="author_id" value="{{ auth('web')->user()->id }}">

            <!-- Visible field for author name (readonly) -->
            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="author_name" value="{{ auth('web')->user()->name }}"
                       readonly>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Book Description</label>
                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" class="form-control" name="price" id="price" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="published_at" class="form-label">Published Date</label>
                    <input type="date" class="form-control" name="published_at" id="published_at">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" name="stock" id="stock" required>
                </div>
            </div>

            <div class="row">
                <div class=" col mb-3">
                    <label for="language_id" class="form-label">Language</label>
                    <select class="form-select" name="language_id" id="language_id" required>
                        <option value="">-- Select Language --</option>
                        @foreach($languages as $language)
                            <option
                                value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col mb-3">
                    <label for="language_id" class="form-label">Book Type</label>
                    <select class="form-select" name="type_id" id="type_id" required>
                        <option value="">-- Select Book Type --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pages" class="form-label">Number of Pages</label>
                    <input type="number" class="form-control" name="pages" id="pages">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="is_valid" class="form-label">Is Valid for Publishing?</label>
                    <select class="form-select" name="is_valid" id="is_valid">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" name="cover_image" id="cover_image" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="book_pdf" class="form-label">Book PDF</label>
                <input type="file" class="form-control" name="pdf" id="book_pdf" accept="application/pdf">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Book
            </button>
        </form>
    </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
