<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .cover-img {
            width: 100%;
            max-width: 250px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .badge-valid {
            font-size: 1rem;
            padding: 0.6rem 1rem;
            border-radius: 20px;
        }

        .card-footer .btn {
            border-radius: 20px;
            font-weight: 500;
        }

        .card-body h3 {
            font-weight: 700;
            color: #0d6efd;
        }

        .info-label {
            font-weight: 600;
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="m-0"><i class="fas fa-book-open me-2"></i>Book Details</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="cover-img">
                            @else
                                <p class="text-muted">No cover image available</p>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <h3>{{ $book->title }}</h3>
                            <p><span class="info-label">👤 Author:</span> {{ $book->author_name }}</p>
                            <p><span class="info-label">🈯 Language:</span> {{ strtoupper($book->language->name) }}</p>
                            <p><span class="info-label">💲 Price:</span> ${{ number_format($book->price, 2) }}</p>
                            <p><span class="info-label">🔢 ISBN:</span> {{ $book->isbn ?? 'N/A' }}</p>
                            <p><span class="info-label">📄 Pages:</span> {{ $book->pages ?? 'N/A' }}</p>
                            <p><span class="info-label">📦 Stock:</span> {{ $book->stock }}</p>
                            <p><span class="info-label">📅 Published At:</span>
                                {{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : 'N/A' }}</p>
                            <p><span class="info-label">📝 Description:</span></p>
                            <p>{{ $book->description }}</p>

                            <span class="badge bg-{{ $book->is_valid ? 'success' : 'danger' }} badge-valid">
                                <i class="fas {{ $book->is_valid ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                {{ $book->is_valid ? 'Valid' : 'Invalid' }}
                            </span>

                            @if($book->pdf_copy)
                                <div class="mt-3">
                                    <a href="{{ asset('storage/' . $book->pdf_copy) }}" class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-file-pdf me-1"></i> Show PDF
                                    </a>
                                </div>
                            @else
                                <div class="mt-3 text-muted"><i class="fas fa-ban me-1"></i> No PDF available</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary me-2"><i class="fas fa-arrow-left me-1"></i> Back</a>
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary"><i class="fas fa-pen me-1"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
