@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-white">Tambah Anggota</h2>
        <p class="mt-2 text-slate-400">Tambahkan anggota baru dengan cepat dan rapi.</p>
    </div>
    <form action="{{ route('members.store') }}" method="POST" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Nama</label>
            <input type="text" name="name" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('name') }}" required>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Email</label>
            <input type="email" name="email" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('email') }}" required>
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Telepon</label>
            <input type="text" name="phone" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('phone') }}">
        </div>
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Alamat</label>
            <input type="text" name="address" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('address') }}">
        </div>
        <div class="flex flex-col gap-3 lg:col-span-2 lg:flex-row lg:justify-end">
            <a href="{{ route('members.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-700 bg-slate-900/90 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">Batal</a>
            <button class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Simpan Anggota</button>
        </div>
    </form>
</div>
@endsection
