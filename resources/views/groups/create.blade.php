@extends('layouts.main')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        <h1 class="text-3xl font-bold text-slate-800">
            Create Group
        </h1>

        <p class="text-slate-500 mt-2">
            Buat grup belanja baru untuk berkolaborasi dengan anggota lainnya.
        </p>

        <form action="{{ route('groups.store') }}"
              method="POST"
              class="mt-8">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 font-medium text-slate-700">
                    Nama Group
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Contoh: Belanja Bulanan"
                    required
                >

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium text-slate-700">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-slate-300 rounded-lg p-3"
                    placeholder="Masukkan deskripsi group"
                ></textarea>

            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-slate-800 text-white px-6 py-3 rounded-lg hover:bg-slate-700">

                    Simpan Group

                </button>

                <a href="{{ route('groups.index') }}"
                   class="px-6 py-3 border border-slate-300 rounded-lg">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection