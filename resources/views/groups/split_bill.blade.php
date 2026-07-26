@extends('layouts.main')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Rincian Pembagian
    </h1>

@if(session('success'))

<div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">

    {{ session('success') }}

</div>

@endif

    <p class="text-slate-500 mt-1">
        {{ $group->name }}
    </p>
</div>

@if(count($summary)==0)

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
    Belum ada data pembagian.
</div>

@else

@foreach($summary as $person)

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">

    <div class="flex justify-between items-center mb-5">

        <h2 class="text-xl font-bold text-slate-800">
            👤 {{ $person['user']->name }}
        </h2>

        <span class="bg-slate-800 text-white px-4 py-2 rounded-lg font-semibold">
            Rp {{ number_format($person['total']) }}
        </span>

    </div>

    @if(count($person['items'])==0)

        <div class="text-slate-400">
            Tidak memiliki barang.
        </div>

    @else

    <table class="w-full border border-slate-200 rounded-lg overflow-hidden">

        <thead>

            <tr class="bg-slate-800 text-white">

                <th class="text-left px-4 py-3">
                    Barang
                </th>

                <th class="text-center px-4 py-3">
                    Qty
                </th>

                <th class="text-right px-4 py-3">
                    Harga
                </th>

                <th class="text-right px-4 py-3">
                    Subtotal
                </th>

            </tr>

        </thead>

        <tbody>

        @foreach($person['items'] as $item)

            <tr class="border-t">

                <td class="px-4 py-3">

                    {{ $item['nama'] }}

                </td>

                <td class="text-center">

                    {{ $item['qty'] }}

                </td>

                <td class="text-right px-4">

                    Rp {{ number_format($item['harga']) }}

                </td>

                <td class="text-right px-4 font-semibold">

                    Rp {{ number_format($item['subtotal']) }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    @endif

</div>

@endforeach

@endif


<div class="flex justify-between mt-8">

    <a href="{{ route('groups.show',$group->id) }}"
       class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-xl font-semibold transition">

        ← Kembali

    </a>

    <div class="flex gap-3">

        <form action="{{ route('bills.generate',$group->id) }}" method="POST">
            @csrf

            <button
                type="submit"
                class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-xl font-semibold transition">

                📄 Generate Tagihan

            </button>

        </form>

        <a href="{{ route('payments.index',$group->id) }}"
           class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center">

            💳 Dashboard Pembayaran

        </a>

    </div>

</div>

@endsection