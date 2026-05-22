@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col gap-6 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/20 md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-3xl font-semibold text-white">Daftar Buku</h2>
        <p class="mt-2 text-slate-400">Kelola koleksi buku dengan tampilan modern dan mudah.</p>
    </div>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Tambah Buku</a>
        @endif
    @endauth
</div>

<div class="mb-6 flex items-center justify-between gap-4">
    <form action="{{ route('books.index') }}" method="GET" class="flex w-full max-w-xl items-center gap-2">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul, pengarang, penerbit..." class="w-full rounded-2xl border border-white/10 bg-slate-900/80 px-4 py-2 text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none" />
        <button class="rounded-2xl bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950">Cari</button>
    </form>
    @if(request('q'))
        <div class="text-sm text-slate-400">Hasil pencarian untuk: <strong class="text-slate-200">{{ request('q') }}</strong></div>
    @endif
</div>

<div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/20">
    <div class="grid grid-cols-7 gap-4 bg-slate-950/90 px-6 py-4 text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">
        <div>#</div>
        <div class="col-span-2">Judul</div>
        <div>Pengarang</div>
        <div>Penerbit</div>
        <div>Tahun</div>
        <div>Stok</div>
        <div class="text-center">Aksi</div>
    </div>
    <div class="divide-y divide-white/5">
        @forelse($books as $book)
            <div class="grid grid-cols-7 gap-4 px-6 py-4 text-sm text-slate-200 hover:bg-slate-950/70">
            <div class="font-medium text-cyan-300">{{ $books->firstItem() + $loop->index }}</div>
                <div class="col-span-2 flex items-center gap-3">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Sampul" class="h-12 w-10 rounded-sm object-cover" />
                    @else
                        <div class="h-12 w-10 rounded-sm bg-slate-800"></div>
                    @endif
                    <div>{{ $book->title }}</div>
                </div>
                <div>{{ $book->author }}</div>
                <div>{{ $book->publisher }}</div>
                <div>{{ $book->year }}</div>
                <div>{{ $book->copies_available }} / {{ $book->copies_total }}</div>
                @auth
                    @if(Auth::user()->isAdmin())
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('books.edit', $book) }}" class="rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold text-slate-100 transition hover:bg-slate-700">Ubah</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-rose-400">Hapus</button>
                            </form>
                        </div>
                    @else
                        <span class="text-slate-400">Hanya admin</span>
                    @endif
                @else
                    <span class="text-slate-400">Login untuk kelola</span>
                @endauth
            </div>
        @empty
            <div class="px-6 py-10 text-center text-slate-400">Belum ada buku.</div>
        @endforelse
    </div>
</div>
<div class="mt-4 flex items-center justify-between">
    <div class="text-sm text-slate-400">Menampilkan {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }} buku</div>
    <div>{{ $books->links() }}</div>
</div>
@endsection
