@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col gap-6 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/20 md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-3xl font-semibold text-white">Daftar Peminjaman</h2>
        <p class="mt-2 text-slate-400">Pantau buku yang sedang dipinjam dan tandai kembali dengan mudah.</p>
    </div>
    @auth
        <a href="{{ route('loans.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Tambah Peminjaman</a>
    @else
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Masuk untuk Peminjaman</a>
    @endauth
</div>
<div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/20">
    <div class="grid grid-cols-8 gap-4 bg-slate-950/90 px-6 py-4 text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">
        <div>#</div>
        <div>Buku</div>
        <div>Anggota</div>
        <div>Tanggal Pinjam</div>
        <div>Tanggal Kembali</div>
        <div>Biaya</div>
        <div>Status</div>
        <div class="text-center">Aksi</div>
    </div>
    <div class="divide-y divide-white/5">
        @forelse($loans as $loan)
            <div class="grid grid-cols-8 gap-4 px-6 py-4 text-sm text-slate-200 hover:bg-slate-950/70">
                <div class="font-medium text-cyan-300">{{ $loop->iteration }}</div>
                <div>{{ $loan->book->title }}</div>
                <div>{{ $loan->member->name }}</div>
                <div>{{ $loan->borrowed_at->format('d M Y') }}</div>
                <div>{{ $loan->returned_at ? $loan->returned_at->format('d M Y') : '—' }}</div>
                <div>Rp {{ number_format($loan->fee ?? 0) }}</div>
                <div>
                    @if($loan->payment)
                        <div class="text-sm text-slate-300">{{ strtoupper($loan->payment->method) }}</div>
                        <div class="mt-1 inline-flex rounded-full {{ $loan->payment->status === 'paid' ? 'bg-emerald-500/15 text-emerald-200' : 'bg-amber-400/15 text-amber-200' }} px-3 py-1 text-xs font-semibold">
                            {{ ucfirst($loan->payment->status) }}
                        </div>
                    @else
                        <span class="text-slate-400">Belum bayar</span>
                    @endif
                </div>
                <div class="flex items-center justify-center gap-2">
                    <a href="{{ route('loans.show', $loan) }}" class="rounded-full bg-slate-700 px-3 py-1 text-xs font-semibold text-white transition hover:bg-slate-600">Detail</a>
                    @if(!$loan->returned_at)
                        <form action="{{ route('loans.return', $loan) }}" method="POST">
                            @csrf
                            <button class="rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-slate-950 transition hover:bg-emerald-400">Kembali</button>
                        </form>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.payments.create', $loan) }}" class="ml-2 rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">Bayar/Atur</a>
                        @endif
                    @else
                        <span class="text-slate-400">Selesai</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-6 py-10 text-center text-slate-400">Belum ada catatan peminjaman.</div>
        @endforelse
    </div>
</div>
@endsection
