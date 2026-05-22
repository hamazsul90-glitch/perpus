@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-white">Tambah Peminjaman</h2>
        <p class="mt-2 text-slate-400">Catat peminjaman buku dengan cepat dan modern.</p>
    </div>
    <form action="{{ route('loans.store') }}" method="POST" class="grid gap-6 lg:grid-cols-2">
        @csrf
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-200">Buku</label>
            <select name="book_id" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
                <option value="" class="text-slate-500">Pilih buku</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }} ({{ $book->copies_available }} tersedia)</option>
                @endforeach
            </select>
        </div>
        @auth
            @if(Auth::user()->isAdmin())
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">Anggota</label>
                    <select name="member_id" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" required>
                        <option value="" class="text-slate-500">Pilih anggota</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="member_id" value="{{ $members->first()?->id }}">
                <div class="rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100">
                    <div class="text-sm text-slate-400">Peminjaman untuk</div>
                    <div class="mt-1 text-lg font-semibold text-white">{{ $members->first()?->name ?? 'Anggota' }}</div>
                </div>
            @endif
        @endauth
        <div class="space-y-2 lg:col-span-2">
            <label class="text-sm font-medium text-slate-200">Tanggal Pinjam</label>
            <input id="borrowed_at" type="date" name="borrowed_at" class="w-full rounded-3xl border border-white/10 bg-slate-950/90 px-4 py-3 text-slate-100 outline-none transition focus:border-cyan-500" value="{{ old('borrowed_at', now()->toDateString()) }}" required>
        </div>

        <div class="space-y-3 lg:col-span-2">
            <div class="rounded-3xl border border-white/10 bg-slate-950/90 p-5">
                <div class="text-sm font-medium text-slate-200">Metode Pembayaran</div>
                <label class="mt-3 flex cursor-pointer items-center gap-3 rounded-3xl border border-white/10 bg-slate-900 px-4 py-3 transition hover:border-cyan-500">
                    <input type="radio" name="payment_method" value="qris" {{ old('payment_method', 'qris') === 'qris' ? 'checked' : '' }} class="h-4 w-4 text-cyan-500" required>
                    <span class="text-slate-200">QRIS - bayar langsung dengan pemindaian</span>
                </label>
                <label class="flex cursor-pointer items-center gap-3 rounded-3xl border border-white/10 bg-slate-900 px-4 py-3 transition hover:border-cyan-500">
                    <input type="radio" name="payment_method" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }} class="h-4 w-4 text-cyan-500">
                    <span class="text-slate-200">Cash - bayar langsung ke admin / kasir</span>
                </label>
                @error('payment_method')
                    <p class="text-sm text-rose-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="rounded-lg border border-white/5 bg-slate-800/60 p-4">
                <div class="text-sm text-slate-400">Kebijakan pinjam saat ini</div>
                <div class="mt-1 flex items-center justify-between">
                    <div>
                        <div class="text-white font-semibold">Periode: {{ $policy?->loan_days ?? config('loans.loan_days') }} hari</div>
                        <div class="text-slate-300">Tarif pinjam: Rp {{ number_format($policy?->loan_fee ?? 0) }}</div>
                        <div class="text-slate-300">Denda keterlambatan: Rp {{ number_format($policy?->late_fee_per_day ?? config('loans.late_fee_per_day')) }} / hari</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-slate-400">Tanggal Kembali (perkiraan)</div>
                        <div id="due_at_display" class="text-white font-semibold">-</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-3 lg:col-span-2 lg:flex-row lg:justify-end">
            <a href="{{ route('loans.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-700 bg-slate-900/90 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">Batal</a>
            <button class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Simpan Peminjaman</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const borrowed = document.getElementById('borrowed_at');
    const dueDisplay = document.getElementById('due_at_display');
    const loanDays = parseInt('{{ $policy?->loan_days ?? config('loans.loan_days') }}');

    function updateDue(){
        const d = new Date(borrowed.value);
        if (!isNaN(d)){
            d.setDate(d.getDate() + loanDays);
            dueDisplay.textContent = d.toISOString().slice(0,10);
        } else {
            dueDisplay.textContent = '-';
        }
    }

    borrowed.addEventListener('change', updateDue);
    updateDue();
});
</script>
@endsection
