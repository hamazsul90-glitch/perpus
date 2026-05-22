<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
        }

        $books = $query->orderBy('title')->paginate(15)->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('books.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'copies_total' => 'required|integer|min:1',
            'cover' => 'nullable|image|max:2048',
        ]);

        $data['copies_available'] = $data['copies_total'];

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $this->ensureAdmin();

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'copies_total' => 'required|integer|min:1',
            'cover' => 'nullable|image|max:2048',
        ]);

        $diff = $data['copies_total'] - $book->copies_total;
        if ($diff !== 0) {
            $book->copies_available = max(0, $book->copies_available + $diff);
            $book->copies_available = min($book->copies_available, $data['copies_total']);
        }

        if ($request->hasFile('cover')) {
            // remove old cover if exists
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        $book->fill($data);
        $book->save();

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $this->ensureAdmin();

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);
    }
}
