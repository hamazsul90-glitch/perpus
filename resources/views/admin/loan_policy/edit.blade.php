@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Kebijakan Pinjaman</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.loan_policy.update') }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')

        <label class="block mb-2">Periode pinjam (hari)
            <input type="number" name="loan_days" value="{{ old('loan_days', $policy->loan_days ?? 30) }}" class="w-full p-2 border rounded" />
        </label>

        <label class="block mb-2">Tarif pinjam (Rp)
            <input type="number" name="loan_fee" value="{{ old('loan_fee', $policy->loan_fee ?? 15000) }}" class="w-full p-2 border rounded" />
        </label>

        <label class="block mb-2">Denda per hari (Rp)
            <input type="number" name="late_fee_per_day" value="{{ old('late_fee_per_day', $policy->late_fee_per_day ?? 1000) }}" class="w-full p-2 border rounded" />
        </label>

        <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Simpan</button>
    </form>
</div>
@endsection
