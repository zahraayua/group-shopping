@extends('layouts.main')

@section('content')

<div class="flex justify-between items-center">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Shopping List
        </h1>

        <p class="text-slate-500 mt-1">
            Kelola daftar belanja grup
        </p>

    </div>

    <a href="{{ route('shopping-lists.create') }}"
       class="bg-slate-800 text-white px-5 py-2 rounded-lg">

        + Tambah Barang

    </a>

</div>

<div class="mt-8 space-y-4">

    @forelse($items as $item)

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">

        <div class="flex justify-between items-center">

            <div>

                <h3 class="font-semibold text-lg">

                    @if($item->is_checked)
                        ✅
                    @else
                        ⬜
                    @endif

                    {{ $item->item_name }}

                </h3>

                <p class="text-slate-500">

                    Qty:
                    {{ $item->quantity }}

                </p>

                <p class="text-slate-500">

                    Rp
                    {{ number_format($item->estimated_price) }}

                </p>

            </div>

            <div class="flex gap-2">

                <form action="{{ route(
                    'shopping-lists.check',
                    $item->id
                ) }}"
                method="POST">

                    @csrf
                    @method('PATCH')

                    <button
                        class="bg-green-600 text-white px-3 py-2 rounded-lg">

                        Check

                    </button>

                </form>

                <a href="{{ route(
                    'shopping-lists.edit',
                    $item->id
                ) }}"
                class="bg-amber-500 text-white px-3 py-2 rounded-lg">

                    Edit

                </a>

                <form action="{{ route(
                    'shopping-lists.destroy',
                    $item->id
                ) }}"
                method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        class="bg-red-500 text-white px-3 py-2 rounded-lg">

                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

    @empty

    <div class="bg-white rounded-xl border border-slate-200 p-10 text-center">

        <h3 class="text-xl font-semibold">
            Belum ada barang
        </h3>

        <p class="text-slate-500 mt-2">
            Tambahkan barang pertama ke daftar belanja.
        </p>

    </div>

    @endforelse

</div>

@endsection