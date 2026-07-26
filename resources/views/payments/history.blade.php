@extends('layouts.main')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Riwayat Transaksi
        </h1>

        <p class="text-slate-500 mt-1">
            Semua transaksi pembayaran
        </p>
    </div>

    <a href="{{ url()->previous() }}"
       class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl">

        ← Kembali

    </a>

</div>

<div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">

<table class="w-full">

<thead class="bg-slate-800 text-white">

<tr>

<th class="px-5 py-3 text-left">
Tanggal
</th>

<th class="px-5 py-3 text-left">
Group
</th>

<th class="px-5 py-3 text-left">
Member
</th>

<th class="px-5 py-3 text-right">
Total
</th>

<th class="px-5 py-3 text-center">
Status
</th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr class="border-t hover:bg-slate-50">

<td class="px-5 py-4">

{{ $payment->created_at->format('d M Y H:i') }}

</td>

<td class="px-5 py-4">

{{ $payment->group->name }}

</td>

<td class="px-5 py-4">

{{ $payment->user->name }}

</td>

<td class="px-5 py-4 text-right font-semibold">

Rp {{ number_format($payment->amount) }}

</td>

<td class="px-5 py-4 text-center">

@if($payment->status=='paid')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

Paid

</span>

@else

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

Pending

</span>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center py-10 text-slate-400">

Belum ada riwayat transaksi.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection