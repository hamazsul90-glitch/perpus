<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerpusMuda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.18),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(168,85,247,0.18),_transparent_28%)]">
        <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight text-white">PerpusMuda</a>
                    <span class="inline-flex rounded-full bg-cyan-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Versi Kekinian</span>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <nav class="flex flex-wrap gap-3 text-sm text-slate-300">
                        <a href="{{ route('books.index') }}" class="transition hover:text-white">Buku</a>
                        <a href="{{ route('loans.index') }}" class="transition hover:text-white">Peminjaman</a>
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('members.index') }}" class="transition hover:text-white">Anggota</a>
                                <a href="{{ route('admin.loan_policy.edit') }}" class="transition hover:text-white">Kebijakan Pinjam</a>
                                <a href="{{ route('admin.cashier.index') }}" class="transition hover:text-white">Kasir</a>
                                <a href="{{ route('admin.payments.index') }}" class="transition hover:text-white">Pembayaran</a>
                            @endif
                        @endauth
                    </nav>
                    @auth
                        <span class="rounded-full border border-white/10 bg-slate-900/90 px-4 py-2 text-sm text-slate-200">{{ Auth::user()->name }} @if(Auth::user()->isAdmin()) (Admin) @else (Anggota) @endif</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" class="pill-button">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="pill-button">Masuk</a>
                        <a href="{{ route('register') }}" class="pill-button">Daftar</a>
                    @endauth
                    <button id="theme-toggle" type="button" class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-slate-900/90 px-4 py-2 text-sm text-slate-200 transition hover:border-cyan-400 hover:text-white">
                        <span id="theme-icon" class="text-cyan-300">🌙</span>
                        <span>Mode</span>
                    </button>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-10">
            @if(session('success'))
                <div class="mb-6 rounded-[2rem] border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-100 shadow-lg shadow-emerald-500/10">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-[2rem] border border-rose-500/20 bg-rose-500/10 p-4 text-rose-100 shadow-lg shadow-rose-500/10">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
