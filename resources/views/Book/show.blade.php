<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cover-img {
            width: 200px;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-detail {
            margin-top: 20px;
        }
        .book-detail h3 {
            margin-bottom: 15px;
        }
        .badge-valid {
            font-size: 1rem;
            padding: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">📚 Books</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white">
                👤 {{ auth()->user()->name ?? 'Guest' }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="m-0">Book Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- عرض صورة الكتاب -->
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="cover-img">
                                @else
                                    <div class="text-muted">No cover image available</div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <!-- تفاصيل الكتاب -->
                                <h3>{{ $book->title }}</h3>
                                <p><strong>Author:</strong> {{ $book->author_name }}</p>
                                <p><strong>Language:</strong> {{ strtoupper($book->language) }}</p>
                                <p><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
                                <p><strong>ISBN:</strong> {{ $book->isbn ?? 'N/A' }}</p>
                                <p><strong>Pages:</strong> {{ $book->pages ?? 'N/A' }}</p>
                                <p><strong>Stock:</strong> {{ $book->stock }}</p>
                                <p><strong>Published At:</strong> {{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : 'N/A' }}</p>
                                <p><strong>Description:</strong></p>
                                <p>{{ $book->description }}</p>

                                <span class="badge bg-{{ $book->is_valid ? 'success' : 'danger' }} badge-valid">
                                    {{ $book->is_valid ? 'Valid' : 'Invalid' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit Book</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
