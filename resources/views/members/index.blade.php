@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col gap-6 rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/20 md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-3xl font-semibold text-white">Daftar Anggota</h2>
        <p class="mt-2 text-slate-400">Kelola anggota perpustakaan dengan tampilan yang fresh.</p>
    </div>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Tambah Anggota</a>
        @endif
    @endauth
</div>
<div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/20">
    <div class="grid grid-cols-6 gap-4 bg-slate-950/90 px-6 py-4 text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">
        <div>#</div>
        <div class="col-span-2">Nama</div>
        <div>Email</div>
        <div>Telepon</div>
        <div class="text-center">Aksi</div>
    </div>
    <div class="divide-y divide-white/5">
        @forelse($members as $member)
            <div class="grid grid-cols-6 gap-4 px-6 py-4 text-sm text-slate-200 hover:bg-slate-950/70">
                <div class="font-medium text-cyan-300">{{ $loop->iteration }}</div>
                <div class="col-span-2">{{ $member->name }}</div>
                <div>{{ $member->email }}</div>
                <div>{{ $member->phone ?? '—' }}</div>
                @auth
                    @if(Auth::user()->isAdmin())
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('members.edit', $member) }}" class="rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold text-slate-100 transition hover:bg-slate-700">Ubah</a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?');">
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
            <div class="px-6 py-10 text-center text-slate-400">Belum ada anggota.</div>
        @endforelse
    </div>
</div>
@endsection
