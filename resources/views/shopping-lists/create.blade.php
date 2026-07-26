@extends('layouts.main')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        <h1 class="text-3xl font-bold text-slate-800">
            Tambah Barang
        </h1>

        <p class="text-slate-500 mt-2">
            Tambahkan barang ke daftar belanja grup
        </p>

        <form action="{{ route('shopping-lists.store') }}"
              method="POST"
              class="mt-8">

            @csrf

            <input
                type="hidden"
                name="group_id"
                value="{{ $groupId }}"
            >

            <div class="mb-5">

                <label class="block mb-2 font-medium text-slate-700">
                    Nama Barang
                </label>

                <input
                    type="text"
                    name="item_name"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Contoh: Beras"
                    required
                >

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium text-slate-700">
                    Jumlah
                </label>

                <input
                    type="number"
                    name="quantity"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Masukkan jumlah"
                    required
                >

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-medium text-slate-700">
                    Estimasi Harga
                </label>

                <input
                    type="number"
                    name="estimated_price"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Contoh: 50000"
                    required
                >

            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-slate-800 text-white px-6 py-3 rounded-lg hover:bg-slate-700">

                    Simpan Barang

                </button>

                <a href="{{ url()->previous() }}"
                   class="px-6 py-3 border border-slate-300 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection