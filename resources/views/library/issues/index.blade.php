@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Issue Book Form -->
        <div class="col-sm-12 col-xl-4">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Issue Book</h6>
                <form action="{{ route('library.issues.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Student</label>
                        <select name="student_id" class="form-select select2" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ optional($student->class)->class_name ?? 'N/A' }} {{ optional($student->class)->section }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Book</label>
                        <select name="book_id" class="form-select select2" required>
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_quantity }} left)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Issue Date</label>
                        <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Issue Book</button>
                </form>
            </div>
        </div>

        <!-- Issues List -->
        <div class="col-sm-12 col-xl-8">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Issued Books History</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Book</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($issues as $issue)
                            <tr>
                                <td>{{ $issue->student->name }}</td>
                                <td>{{ $issue->book->title }}</td>
                                <td>{{ $issue->issue_date->format('d M Y') }}</td>
                                <td>{{ $issue->due_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $issue->status === 'Issued' ? 'warning' : ($issue->status === 'Returned' ? 'success' : 'danger') }}">
                                        {{ $issue->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($issue->status === 'Issued')
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#returnModal{{ $issue->id }}">
                                            Return
                                        </button>

                                        <!-- Return Modal -->
                                        <div class="modal fade" id="returnModal{{ $issue->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('library.issues.return', $issue->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Return Book: {{ $issue->book->title }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Return Date</label>
                                                                <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Fine Amount (if any)</label>
                                                                <input type="number" name="fine_amount" class="form-control" value="0" min="0" step="0.01">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="Returned">Returned</option>
                                                                    <option value="Lost">Lost</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Process Return</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $issues->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
