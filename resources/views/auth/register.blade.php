@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl rounded-[2rem] border border-white/10 bg-slate-900/90 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-white">Daftar Akun Anggota</h1>
        <p class="mt-2 text-slate-400">Buat akun anggota untuk mulai meminjam buku.</p>
    </div>
    <form action="{{ route('register') }}" method="POST" class="grid gap-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required autofocus>
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Alamat</label>
            <input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Kata Sandi</label>
            <input type="password" name="password" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
        </div>
        <button class="glow-button w-full">Daftar</button>
        @if($errors->any())
            <div class="rounded-2xl bg-rose-500/10 p-4 text-sm text-rose-200">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
