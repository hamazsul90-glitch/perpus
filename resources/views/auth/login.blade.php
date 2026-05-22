@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl rounded-[2rem] border border-white/10 bg-slate-900/90 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-white">Masuk ke PerpusMuda</h1>
        <p class="mt-2 text-slate-400">Gunakan akun admin atau anggota untuk mengakses fitur.</p>
    </div>
    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required autofocus>
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200">Kata Sandi</label>
            <input type="password" name="password" class="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
        </div>
        <div class="flex items-center justify-between gap-4">
            <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-600 bg-slate-800 text-cyan-500 focus:ring-cyan-400">
                Ingat saya
            </label>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-cyan-400 hover:text-cyan-200">Belum punya akun?</a>
        </div>
        <button class="glow-button w-full">Masuk</button>
        @if($errors->any())
            <div class="rounded-2xl bg-rose-500/10 p-4 text-sm text-rose-200">
                {{ $errors->first() }}
            </div>
        @endif
    </form>
</div>
@endsection
