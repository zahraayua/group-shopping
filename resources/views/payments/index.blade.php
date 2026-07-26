@extends('layouts.main')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">
    {{ session('success') }}
</div>
@endif

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Daftar Tagihan
    </h1>

    <p class="text-slate-500">
        {{ $group->name }}
    </p>
</div>

{{-- ================= DASHBOARD MONITORING ================= --}}

<div class="grid grid-cols-2 lg:grid-cols-5 gap-5 mb-8">

    <div class="bg-white rounded-xl shadow border border-slate-200 p-5">
        <p class="text-sm text-slate-500">Total Tagihan</p>
        <h2 class="text-2xl font-bold text-slate-800 mt-2">
            Rp {{ number_format($totalBill) }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-5">
        <p class="text-sm text-slate-500">Sudah Dibayar</p>
        <h2 class="text-2xl font-bold text-green-600 mt-2">
            Rp {{ number_format($paidBill) }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-5">
        <p class="text-sm text-slate-500">Belum Dibayar</p>
        <h2 class="text-2xl font-bold text-yellow-500 mt-2">
            Rp {{ number_format($pendingBill) }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-5">
        <p class="text-sm text-slate-500">Sudah Bayar</p>
        <h2 class="text-2xl font-bold text-green-600 mt-2">
            {{ $paidCount }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-5">
        <p class="text-sm text-slate-500">Belum Bayar</p>
        <h2 class="text-2xl font-bold text-red-600 mt-2">
            {{ $pendingCount }}
        </h2>
    </div>

</div>

{{-- ================= TABEL PEMBAYARAN ================= --}}

<div class="bg-white rounded-xl shadow border border-slate-200">

<table class="w-full">

<thead class="bg-slate-800 text-white">

<tr>

<th class="px-5 py-3 text-left">
Member
</th>

<th class="px-5 py-3 text-right">
Tagihan
</th>

<th class="px-5 py-3 text-center">
Status
</th>

<th class="px-5 py-3 text-center">
Aksi
</th>

</tr>

</thead>

<tbody>

@foreach($payments as $payment)

<tr class="border-t">

<td class="px-5 py-4">

{{ $payment->user->name }}

</td>

<td class="px-5 py-4 text-right">

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

<td class="px-5 py-4 text-center">

@if($payment->status == 'pending')


    @if(
        $group->members()
        ->where('users.id', auth()->id())
        ->wherePivot('role','admin')
        ->exists()
    )

        <form action="{{ route('payments.pay',$payment->id) }}" method="POST">

            @csrf
            @method('PATCH')

            <button 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                Tandai Sudah Bayar

            </button>

        </form>


    @else

        <span class="text-yellow-600 font-semibold">
            Menunggu konfirmasi admin
        </span>

    @endif


@else

    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg">
        Sudah Bayar
    </span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="flex justify-between items-center mt-8">

    <a href="{{ route('groups.split-bill', $group->id) }}"
       class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl">

        ← Kembali

    </a>

    <a href="{{ route('payments.history') }}"
       class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl">

        Riwayat Transaksi

    </a>

</div>

@endsection