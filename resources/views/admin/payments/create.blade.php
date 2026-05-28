@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Buat Pembayaran untuk Loan #{{ $loan->id }}</h1>

    <p>Member: {{ $loan->member->name }}</p>
    <p>Buku: {{ $loan->book->title }}</p>
    <p>Jumlah: Rp {{ number_format($loan->fee ?? 0) }}</p>

    @if($existing)
        <div class="mb-4">Existing payment: {{ $existing->status }}</div>
    @endif

    <form method="POST" action="{{ route('admin.payments.store', $loan) }}">
        @csrf
        <label class="block mb-2">Metode
            <select name="method" class="w-full p-2 border rounded">
                <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="qris" {{ request('method') === 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </label>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Buat Pembayaran</button>
    </form>

    @if(isset($existing) && $existing && $existing->method === 'qris')
        <div class="mt-6">
            <h3 class="font-bold mb-3">QRIS - Kode QR Standar Pembayaran Nasional</h3>
            <p class="mb-4">Scan QR ini untuk membayar:</p>
            @php
                $qrDataUri = \App\Services\QrCodeRenderer::generateDataUri($existing->qris_payload);
            @endphp
            @if($qrDataUri)
                <img src="{{ $qrDataUri }}" alt="qris" class="h-80 w-80 mx-auto" />
            @else
                <div class="h-80 w-80 mx-auto bg-slate-800 flex items-center justify-center text-slate-400">
                    QR Code tidak dapat dibuat
                </div>
            @endif
            <p class="mt-3 text-slate-300 break-all text-xs"><code>{{ $existing->qris_payload }}</code></p>
        </div>
    @elseif(request('method') === 'qris')
        <div class="mt-6 rounded-3xl border border-white/10 bg-slate-950/90 p-4 text-slate-300">
            Pilih tombol "Buat Pembayaran" untuk menghasilkan QRIS.
        </div>
    @endif
</div>
@endsection
