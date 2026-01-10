@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Add Book Form -->
        <div class="col-sm-12 col-xl-4">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Add New Book</h6>
                <form action="{{ route('library.books.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rack Number</label>
                        <input type="text" name="rack_number" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>

        <!-- Books List -->
        <div class="col-sm-12 col-xl-8">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Books List</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Qty (Avail)</th>
                                <th>Rack</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->quantity }} ({{ $book->available_quantity }})</td>
                                <td>{{ $book->rack_number }}</td>
                                <td>
                                    <!-- Edit/Delete could be added here -->
                                    <span class="badge bg-{{ $book->available_quantity > 0 ? 'success' : 'danger' }}">
                                        {{ $book->available_quantity > 0 ? 'Available' : 'Out of Stock' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
