<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminExportController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);
    }

    public function exportBooks()
    {
        $this->ensureAdmin();

        $books = Book::orderBy('title')->get();

        $response = new StreamedResponse(function () use ($books) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Author', 'Publisher', 'Year', 'Copies Total', 'Copies Available']);
            foreach ($books as $b) {
                fputcsv($handle, [$b->id, $b->title, $b->author, $b->publisher, $b->year, $b->copies_total, $b->copies_available]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="books.csv"');

        return $response;
    }

    public function exportLoans()
    {
        $this->ensureAdmin();

        $loans = Loan::with('book', 'member')->orderByDesc('borrowed_at')->get();

        $response = new StreamedResponse(function () use ($loans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Book', 'Member', 'Borrowed At', 'Due At', 'Returned At', 'Is Overdue', 'Fee']);
            foreach ($loans as $l) {
                fputcsv($handle, [$l->id, $l->book->title ?? '', $l->member->name ?? '', $l->borrowed_at, $l->due_at, $l->returned_at, $l->is_overdue ? 'yes' : 'no', $l->fee]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="loans.csv"');

        return $response;
    }
}
