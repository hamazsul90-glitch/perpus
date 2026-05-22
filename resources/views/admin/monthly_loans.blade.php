@extends('layouts.app')

@section('content')
<div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8">
    <h2 class="text-2xl font-semibold text-white">Laporan Bulanan Peminjaman - {{ $year }}</h2>

    <table class="mt-6 w-full table-auto text-sm">
        <thead>
            <tr class="text-left text-slate-400">
                <th>Bulan</th>
                <th>Total Peminjaman</th>
                <th>Kas Masuk (fee)</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($rows as $r)
                <tr class="text-slate-200">
                    <td>{{ DateTime::createFromFormat('!m', str_pad($r->month,2,'0',STR_PAD_LEFT))->format('F') }}</td>
                    <td>{{ $r->total_loans }}</td>
                    <td>{{ number_format($r->total_income, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
