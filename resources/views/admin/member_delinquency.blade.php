@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8">
    <h2 class="text-2xl font-semibold text-white">Daftar Anggota Bermasalah</h2>
    <p class="mt-2 text-slate-400">Anggota diurutkan berdasarkan jumlah keterlambatan pengembalian.</p>

    <div class="mt-6 overflow-hidden rounded-lg border border-white/5 bg-slate-950/80">
        <table class="w-full text-sm">
            <thead class="text-slate-400">
                <tr class="text-left">
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telat (jumlah)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($members as $m)
                    <tr class="text-slate-200">
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->overdue_count }}</td>
                        <td><a href="{{ route('members.show', $m) }}" class="text-cyan-400">Lihat</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
