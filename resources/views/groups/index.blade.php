@extends('layouts.main')

@section('content')

{{-- Header --}}

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            👥 My Groups
        </h1>

        <p class="text-slate-500 mt-2">
            Kelola seluruh grup belanja bersama teman maupun keluarga.
        </p>

    </div>

    <a href="{{ route('groups.create') }}"
       class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition">

        + Create Group

    </a>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

        <div class="text-4xl mb-3">
            👥
        </div>

        <p class="text-slate-500">
            Total Groups
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $totalGroups }}
        </h2>

    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

        <div class="text-4xl mb-3">
            🛒
        </div>

        <p class="text-slate-500">
            Total Shopping Items
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $totalItems }}
        </h2>

    </div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

        <div class="text-4xl mb-3">
            👨‍👩‍👧
        </div>

        <p class="text-slate-500">
            Total Members
        </p>

        <h2 class="text-3xl font-bold mt-2">
            {{ $totalMembers }}
        </h2>

    </div>

</div>

{{-- Card Group --}}

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-7">

@forelse($groups as $group)

<div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">

    {{-- Header Card --}}

    <div class="bg-slate-800 text-white p-5">

        <h2 class="text-xl font-bold">

            🛍 {{ $group->name }}

        </h2>

    </div>

    {{-- Body --}}

    <div class="p-5">

        <p class="text-slate-600 min-h-[50px]">

            {{ $group->description }}

        </p>

        <div class="flex justify-between mt-6 text-sm">

            <div class="text-slate-600">

                👥
                <strong>{{ $group->members->count() }}</strong>
                Member

            </div>

            <div class="text-slate-600">

                🛒
                <strong>{{ $group->shoppingLists->count() }}</strong>
                Barang

            </div>

        </div>

        <div class="mt-6">

            <a href="{{ route('groups.show',$group->id) }}"
               class="block w-full text-center bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-xl font-semibold transition">

                Detail Group

            </a>

            <div class="grid grid-cols-2 gap-3 mt-3">

                <a href="{{ route('groups.edit',$group->id) }}"
                   class="bg-orange-400 hover:bg-amber-600 text-white text-center py-2 rounded-xl font-medium transition">

                    Edit

                </a>

                <form
                    action="{{ route('groups.destroy',$group->id) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Hapus group ini?')"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-xl font-medium transition">

                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@empty

<div class="col-span-full">

<div class="bg-white rounded-2xl shadow border border-slate-200 p-16 text-center">

<div class="text-7xl mb-5">

📦

</div>

<h2 class="text-2xl font-bold text-slate-700">

Belum Ada Group

</h2>

<p class="text-slate-500 mt-3">

Mulailah membuat group pertama untuk berbelanja bersama.

</p>

<a href="{{ route('groups.create') }}"
class="inline-block mt-8 bg-slate-800 hover:bg-slate-700 text-white px-8 py-3 rounded-xl font-semibold">

+ Create Group

</a>

</div>

</div>

@endforelse

</div>

@endsection