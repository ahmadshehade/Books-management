<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cover-img {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
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
        <h2 class="mb-4 text-center">📚 Book Collection</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
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
                            <td>{{ $book->author_name }}</td>
                            <td>{{ strtoupper($book->language) }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td>{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : 'nill' }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                @if($book->is_valid)
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">Invalid</span>
                                @endif
                            </td>
                            <td>{{ $book->isbn ?? '-' }}</td>
                            <td>
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info text-white">Show</a>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning text-white">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $book->id }}">
                                    Delete 
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for Deleting Book -->
                        @include('Book.delete', ['book' => $book])
                     

                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('books.create') }}" class="btn btn-primary w-100 mt-3">Add Book</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
