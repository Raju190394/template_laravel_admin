<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class LibraryService
{
    public function getBooks($paginate = 20)
    {
        return Book::latest()->paginate($paginate);
    }

    public function createBook(array $data)
    {
        $data['available_quantity'] = $data['quantity'];
        return Book::create($data);
    }

    public function getBooksForForm()
    {
        return Book::latest()->get();
    }

    public function getIssuesFormData()
    {
        return [
            'books' => Book::where('available_quantity', '>', 0)->get(),
            'students' => \App\Models\Student::active()->get(),
        ];
    }

    public function getIssues($paginate = 20)
    {
        return BookIssue::with(['book', 'student'])->latest()->paginate($paginate);
    }

    public function issueBook(array $data)
    {
        $book = Book::findOrFail($data['book_id']);
        
        if ($book->available_quantity <= 0) {
            throw new \Exception('Book is not available for issue.');
        }

        $exists = BookIssue::where('student_id', $data['student_id'])
            ->where('book_id', $data['book_id'])
            ->where('status', 'Issued')
            ->exists();

        if ($exists) {
            throw new \Exception('Student already has an active issue of this book.');
        }

        $issue = BookIssue::create($data);
        $book->decrement('available_quantity');
        
        return $issue;
    }

    public function returnBook(BookIssue $issue, array $data)
    {
        if ($issue->status !== 'Issued') {
            throw new \Exception('Book is already returned or lost.');
        }

        $issue->update([
            'return_date' => $data['return_date'],
            'fine_amount' => $data['fine_amount'] ?? 0,
            'status' => $data['status'],
        ]);

        if ($data['status'] === 'Returned') {
            $issue->book->increment('available_quantity');
        }

        return $issue;
    }
}
