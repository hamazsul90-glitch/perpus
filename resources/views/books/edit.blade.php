@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-white">Ubah Buku</h2>
        <p class="mt-2 text-slate-400">Perbarui informasi buku sesuai data terbaru.</p>
    </div>
    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PUT')
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Judul</label>
            <input type="text" name="title" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('title', $book->title) }}" required>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Pengarang</label>
            <input type="text" name="author" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('author', $book->author) }}" required>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Penerbit</label>
            <input type="text" name="publisher" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('publisher', $book->publisher) }}" required>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Tahun</label>
            <input type="number" name="year" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" min="1900" max="2100" value="{{ old('year', $book->year) }}" required>
        </div>
        <div class="space-y-2 lg:col-span-2">
            <label class="text-sm font-medium text-slate-200">Jumlah Salinan</label>
            <input type="number" name="copies_total" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" min="1" value="{{ old('copies_total', $book->copies_total) }}" required>
        </div>
        <div class="space-y-2 lg:col-span-2">
            <label class="text-sm font-medium text-slate-200">Sampul Buku (opsional)</label>
            @if($book->cover)
                <div class="mb-2 flex items-center gap-4">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Sampul" class="h-20 w-14 rounded-md object-cover" />
                    <div class="text-sm text-slate-300">Sampul saat ini. Upload file baru untuk mengganti.</div>
                </div>
            @endif
            <input type="file" name="cover" accept="image/*" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-2 text-slate-100 outline-none" />
        </div>
        <div class="flex flex-col gap-3 lg:col-span-2 lg:flex-row lg:justify-end">
            <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-700 bg-slate-900/90 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">Batal</a>
            <button class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Perbarui Buku</button>
        </div>
    </form>
</div>
@endsection
