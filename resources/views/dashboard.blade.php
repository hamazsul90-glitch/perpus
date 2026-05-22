@extends('layouts.app')

@section('content')
<div class="grid gap-8">
    <section class="soft-card bg-gradient-to-br from-slate-900/95 via-slate-950 to-slate-900/80 p-8 shadow-2xl shadow-slate-950/40">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <span class="inline-flex rounded-full bg-cyan-500/15 px-4 py-1 text-sm font-medium text-cyan-200">PerpusMuda</span>
                <h1 class="mt-5 text-4xl font-semibold tracking-tight text-white md:text-5xl">Perpustakaan Kekinian untuk Anak Muda</h1>
                <p class="mt-4 text-slate-300">Kelola koleksi, anggota, dan peminjaman dengan tampilan modern, cepat, dan menyenangkan.</p>
            </div>
            <div class="soft-card bg-slate-950/80 p-6 shadow-xl shadow-cyan-500/10">
                <div class="text-sm uppercase tracking-[0.24em] text-slate-500">Fiturnya</div>
                <div class="mt-4 text-4xl font-semibold text-white">Fresh & Friendly</div>
                <p class="mt-2 text-slate-400">Desain yang cocok untuk generasi muda dan komunitas sekolah.</p>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-lg shadow-slate-950/20">
            <div class="text-sm uppercase tracking-[0.24em] text-slate-500">Total Buku</div>
            <div class="mt-5 text-5xl font-semibold text-white">{{ $booksCount }}</div>
        </div>
        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-lg shadow-slate-950/20">
            <div class="text-sm uppercase tracking-[0.24em] text-slate-500">Total Anggota</div>
            <div class="mt-5 text-5xl font-semibold text-white">{{ $membersCount }}</div>
        </div>
        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-lg shadow-slate-950/20">
            <div class="text-sm uppercase tracking-[0.24em] text-slate-500">Peminjaman Aktif</div>
            <div class="mt-5 text-5xl font-semibold text-white">{{ $activeLoansCount }}</div>
        </div>
    </section>
</div>
@endsection
