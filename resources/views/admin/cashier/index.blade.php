@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-white">Kasir Pembayaran</h1>
            <p class="text-slate-400">Kelola pembayaran pinjaman dengan QRIS atau cash.</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="rounded-2xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Daftar Pembayaran</a>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/20">
        <div class="grid grid-cols-7 gap-4 bg-slate-950/90 px-6 py-4 text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">
            <div>#</div>
            <div>Loan</div>
            <div>Buku</div>
            <div>Anggota</div>
            <div>Biaya</div>
            <div>Status</div>
            <div class="text-center">Aksi</div>
        </div>
        <div class="divide-y divide-white/5">
            @forelse($loans as $loan)
                <div class="grid grid-cols-7 gap-4 px-6 py-4 text-sm text-slate-200 hover:bg-slate-950/70">
                    <div class="font-medium text-cyan-300">{{ $loop->iteration }}</div>
                    <div>#{{ $loan->id }}</div>
                    <div>{{ $loan->book->title }}</div>
                    <div>{{ $loan->member->name }}</div>
                    <div>Rp {{ number_format($loan->fee) }}</div>
                    <div>
                        @if($loan->payment)
                            {{ ucfirst($loan->payment->status) }} ({{ $loan->payment->method }})
                        @else
                            Belum bayar
                        @endif
                    </div>
                    <div class="flex flex-wrap justify-center gap-2">
                        <a href="{{ route('admin.payments.create', $loan) }}" class="rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">Bayar</a>
                        <a href="{{ route('admin.payments.create', $loan) }}?method=qris" class="rounded-full bg-indigo-600 px-3 py-1 text-xs font-semibold text-white">QRIS</a>
                        <a href="{{ route('admin.payments.create', $loan) }}?method=cash" class="rounded-full bg-emerald-600 px-3 py-1 text-xs font-semibold text-white">Cash</a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-slate-400">Tidak ada pembayaran tunggakan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
