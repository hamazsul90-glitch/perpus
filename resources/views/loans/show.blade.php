@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-white">Detail Peminjaman</h2>
        <p class="mt-2 text-slate-400">Informasi pinjaman dan instruksi pembayaran.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="space-y-4 rounded-3xl border border-white/10 bg-slate-950/90 p-6">
            <div>
                <div class="text-sm text-slate-400">Anggota</div>
                <div class="mt-1 text-lg font-semibold text-white">{{ $loan->member->name }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-400">Buku</div>
                <div class="mt-1 text-lg font-semibold text-white">{{ $loan->book->title }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-400">Tanggal Pinjam</div>
                <div class="mt-1 text-white">{{ $loan->borrowed_at->format('d M Y') }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-400">Tanggal Jatuh Tempo</div>
                <div class="mt-1 text-white">{{ $loan->due_at->format('d M Y') }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-400">Biaya Pinjam</div>
                <div class="mt-1 text-white">Rp {{ number_format($loan->fee ?? 0) }}</div>
            </div>
        </div>

        <div class="space-y-4 rounded-3xl border border-white/10 bg-slate-950/90 p-6">
            <div>
                <div class="text-sm text-slate-400">Metode Pembayaran</div>
                <div class="mt-1 text-lg font-semibold text-white">{{ strtoupper(optional($loan->payment)->method ?? '—') }}</div>
            </div>
            <div>
                <div class="text-sm text-slate-400">Status Pembayaran</div>
                <div class="mt-1 inline-flex rounded-full bg-amber-400/15 px-3 py-1 text-xs font-semibold text-amber-200">{{ ucfirst(optional($loan->payment)->status ?? 'pending') }}</div>
            </div>

            @if(optional($loan->payment)->method === 'qris')
                <div class="rounded-3xl border border-white/10 bg-slate-900 p-4 text-slate-300">
                    <div class="text-sm font-medium text-white">QRIS</div>
                    <p class="mt-2">Silakan scan QRIS berikut untuk menyelesaikan pembayaran.</p>
                    <div class="mt-4 flex items-center justify-center">
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ urlencode($loan->payment->qris_payload) }}" alt="QRIS" class="mx-auto rounded-3xl bg-white p-4" />
                    </div>
                    <p class="mt-4 break-words text-xs text-slate-400"><strong>Payload:</strong> {{ $loan->payment->qris_payload }}</p>
                </div>
            @elseif($loan->payment && $loan->payment->method === 'cash')
                <div class="rounded-3xl border border-white/10 bg-slate-900 p-4 text-slate-300">
                    <div class="text-sm font-medium text-white">Pembayaran Cash</div>
                    <p class="mt-2">Bayar langsung ke admin atau kasir. Setelah pembayaran, status akan diperbarui oleh admin.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ route('loans.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-700 bg-slate-900/90 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-800">Kembali ke Daftar</a>
        @if(Auth::user()->isAdmin() && $loan->payment)
            <a href="{{ route('admin.payments.create', $loan) }}" class="inline-flex items-center justify-center rounded-2xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">Kelola Pembayaran</a>
        @endif
    </div>
</div>
@endsection
