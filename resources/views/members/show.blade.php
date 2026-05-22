@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-white">Profil Anggota</h2>
            <p class="mt-1 text-sm text-slate-400">{{ $member->name }} — {{ $member->email }}</p>
        </div>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('members.edit', $member) }}" class="rounded-2xl bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950">Edit Anggota</a>
            @endif
        @endauth
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="space-y-2 md:col-span-2">
            <div class="rounded-lg border border-white/5 bg-slate-950/80 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Riwayat Peminjaman</h3>
                        <p class="text-sm text-slate-400">Daftar peminjaman terbaru untuk anggota ini.</p>
                    </div>
                    <div class="text-sm text-slate-400">Total: <strong class="text-slate-200">{{ $member->loans()->count() }}</strong></div>
                </div>

                <div class="mt-4">
                    <div class="divide-y divide-white/5">
                        @forelse($loans as $loan)
                            <div class="flex items-center justify-between gap-4 px-4 py-3 text-sm text-slate-200">
                                <div>
                                    <div class="font-medium">{{ $loan->book->title }}</div>
                                    <div class="text-xs text-slate-400">Dipinjam: {{ $loan->borrowed_at->format('Y-m-d') }} • Dikembalikan: {{ $loan->returned_at ? $loan->returned_at->format('Y-m-d') : 'Belum kembali' }}</div>
                                </div>
                                <div class="text-right">
                                    @if(!$loan->returned_at && $loan->borrowed_at->lt(now()->subDays(14)))
                                        <span class="inline-flex items-center rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white">Terlambat</span>
                                    @elseif(!$loan->returned_at)
                                        <span class="inline-flex items-center rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold text-slate-900">Dipinjam</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-slate-900">Kembali</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-sm text-slate-400">Belum ada riwayat peminjaman.</div>
                        @endforelse
                    </div>

                    <div class="mt-4">{{ $loans->links() }}</div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-lg border border-white/5 bg-slate-950/80 p-4">
                <h4 class="text-sm font-semibold text-white">Info Anggota</h4>
                <div class="mt-2 text-sm text-slate-300">
                    <div>Nama: {{ $member->name }}</div>
                    <div>Email: {{ $member->email }}</div>
                    <div>Telepon: {{ $member->phone ?? '-' }}</div>
                    <div>Alamat: {{ $member->address ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
