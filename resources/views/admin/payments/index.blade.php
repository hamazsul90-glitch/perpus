@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pembayaran</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto">
        <thead>
            <tr>
                <th class="border p-2">ID</th>
                <th class="border p-2">Loan</th>
                <th class="border p-2">Member</th>
                <th class="border p-2">Amount</th>
                <th class="border p-2">Method</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td class="border p-2">{{ $p->id }}</td>
                    <td class="border p-2">{{ $p->loan->id }} - {{ $p->loan->book->title }}</td>
                    <td class="border p-2">{{ $p->loan->member->name }}</td>
                    <td class="border p-2">Rp {{ number_format($p->amount) }}</td>
                    <td class="border p-2">{{ $p->method }}</td>
                    <td class="border p-2">{{ $p->status }} {{ $p->paid_at ? 'at '.$p->paid_at->format('Y-m-d H:i') : '' }}</td>
                    <td class="border p-2">
                        @if($p->status !== 'paid')
                            <form method="POST" action="{{ route('admin.payments.markPaid', $p) }}">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-1 rounded">Mark Paid</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
