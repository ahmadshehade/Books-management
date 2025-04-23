<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          integrity="sha512-uF+8WJYkN7Hl+/zJj8OIF6DLCXQBdWz8sVLKZgr1wAec6+DCYr8IzXZDWJ6qK6Q6XGmjUsqsy3wNifFZs5vURg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        body {
            background-color: #f9f9fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cover-img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .cover-img:hover {
            transform: scale(1.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .table th, .table td {
            vertical-align: middle !important;
        }

        .btn {
            border-radius: 25px;
        }

        .btn i {
            margin-right: 4px;
        }

        .btn-info, .btn-warning, .btn-danger {
            color: #fff !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 shadow">
    <a class="navbar-brand" href="#"><i class="fas fa-book-reader me-2"></i>Books</a>

    <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name ?? 'Guest' }}
            </span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary"><i class="fas fa-book"></i> Book Collection</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>Language</th>
                <th>Price</th>
                <th>Published</th>
                <th>Stock</th>
                <th>Status</th>
                <th>ISBN</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="cover-img">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ strtoupper($book->language->abbreviation) }}</td>
                    <td>${{ number_format($book->price, 2) }}</td>
                    <td>{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $book->stock }}</td>
                    <td>
                                <span class="badge bg-{{ $book->is_valid ? 'success' : 'danger' }}">
                                    {{ $book->is_valid ? 'Valid' : 'Invalid' }}
                                </span>
                    </td>
                    <td>{{ $book->isbn ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                    id="actionsDropdown{{ $book->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bars"></i> Actions
                            </button>
                            <ul class="dropdown-menu text-center" aria-labelledby="actionsDropdown{{ $book->id }}">
                                <li>
                                    <a class="dropdown-item text-info" href="{{ route('books.show', $book->id) }}"
                                       title="Show">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </li>

                                @if ($book->author_id==auth('web')->user()->id)

                                    <li>
                                        <a class="dropdown-item text-warning"
                                           href="{{ route('books.edit', $book->id) }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $book->id }}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </li>
                                @endif
                            </ul>

                        </div>
                    </td>

                </tr>

                @include('Book.delete', ['book' => $book])

            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">No books found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
        <a href="{{ route('books.create') }}" class="btn btn-primary w-100 mt-3">
            <i class="fas fa-plus-circle"></i> Add New Book
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
