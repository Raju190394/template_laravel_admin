<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use Carbon\Carbon;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookIssueStoreRequest;
use App\Services\LibraryService;

class LibraryController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function booksIndex()
    {
        $books = $this->libraryService->getBooks();
        return view('library.books.index', compact('books'));
    }

    public function booksStore(BookStoreRequest $request)
    {
        $this->libraryService->createBook($request->validated());
        return back()->with('success', 'Book added successfully.');
    }

    public function issuesIndex()
    {
        $issues = $this->libraryService->getIssues();
        $formData = $this->libraryService->getIssuesFormData();
        return view('library.issues.index', array_merge(compact('issues'), $formData));
    }

    public function issuesStore(BookIssueStoreRequest $request)
    {
        try {
            $this->libraryService->issueBook($request->validated());
            return back()->with('success', 'Book issued successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function returnBook(Request $request, BookIssue $issue)
    {
        $validated = $request->validate([
            'return_date' => 'required|date',
            'fine_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:Returned,Lost',
        ]);

        try {
            $this->libraryService->returnBook($issue, $validated);
            return back()->with('success', 'Book marked as ' . $request->status . '.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
