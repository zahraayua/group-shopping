@extends('layouts.main')

@section('content')

<div class="mb-8">

<h1 class="text-3xl font-bold text-slate-800">

Dashboard Monitoring

</h1>

<p class="text-slate-500">

Monitoring seluruh transaksi Group Shopping

</p>

</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-5 mb-8">

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">Total Group</p>

<h2 class="text-3xl font-bold mt-2">

{{ $totalGroups }}

</h2>

</div>

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">Total Member</p>

<h2 class="text-3xl font-bold mt-2">

{{ $totalUsers }}

</h2>

</div>

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">Total Barang</p>

<h2 class="text-3xl font-bold mt-2">

{{ $totalItems }}

</h2>

</div>

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">Total Tagihan</p>

<h2 class="text-2xl font-bold text-slate-800 mt-2">

Rp {{ number_format($totalBill) }}

</h2>

</div>

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">

Sudah Dibayar

</p>

<h2 class="text-2xl font-bold text-green-600 mt-2">

Rp {{ number_format($paidBill) }}

</h2>

</div>

<div class="bg-white rounded-xl shadow border p-5">

<p class="text-slate-500">

Belum Dibayar

</p>

<h2 class="text-2xl font-bold text-red-600 mt-2">

Rp {{ number_format($pendingBill) }}

</h2>

</div>

</div>

<div class="bg-white rounded-xl shadow border border-slate-200">

<div class="px-6 py-4 border-b">

<h2 class="text-xl font-bold">

Transaksi Terbaru

</h2>

</div>

<table class="w-full">

<thead class="bg-slate-800 text-white">

<tr>

<th class="px-5 py-3 text-left">

Member

</th>

<th class="text-center">

Status

</th>

<th class="text-right px-5">

Nominal

</th>

</tr>

</thead>

<tbody>

@foreach($payments as $payment)

<tr class="border-t">

<td class="px-5 py-4">

{{ $payment->user->name }}

</td>

<td class="text-center">

@if($payment->status=='paid')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Paid

</span>

@else

<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Pending

</span>

@endif

</td>

<td class="text-right px-5">

Rp {{ number_format($payment->amount) }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection