@extends('layouts.main')

@section('content')

<!-- Header -->

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Dashboard
    </h1>

    <p class="text-slate-500 mt-2">
        Welcome back,
        <span class="font-semibold">
            {{ auth()->user()->name }}
        </span>
        👋
    </p>

</div>

<!-- Statistik -->

<div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

    <div class="text-4xl mb-3">
        👥
    </div>

    <p class="text-slate-500">
        Groups
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
        Shopping Items
    </p>

    <h2 class="text-3xl font-bold mt-2">
        {{ $totalItems }}
    </h2>

</div>

    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">

    <div class="text-4xl mb-3">
        💰
    </div>

    <p class="text-slate-500">
        Estimated Cost
    </p>

    <h2 class="text-2xl font-bold mt-2">
        Rp {{ number_format($totalCost) }}
    </h2>

</div>

<div class="bg-white rounded-xl shadow border border-slate-200 p-6">

    <div class="text-4xl mb-3">
        📈
    </div>

    <p class="text-slate-500">
        Progress
    </p>

    <h2 class="text-3xl font-bold mt-2">
        {{ $progress }}%
    </h2>

</div>

</div>

<!-- Shopping Progress -->

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-8">

    <div class="flex justify-between">

        <h2 class="text-xl font-semibold text-slate-800">

            Shopping Progress

        </h2>

        <span class="font-bold text-slate-700">

            {{ $progress }}%

        </span>

    </div>

    <!-- Progress Bar -->

    <div class="w-full bg-slate-200 rounded-full h-3 mt-5">

        <div
            class="bg-green-600 h-3 rounded-full"
            style="width: {{ $progress }}%;">

        </div>

    </div>

    <div class="grid md:grid-cols-2 gap-4 mt-6">

        <div class="bg-green-50 rounded-lg p-4">

            <p class="text-green-700 font-semibold">

                ✅ Completed

            </p>

            <h3 class="text-3xl font-bold mt-2">

                {{ $checkedItems }}

            </h3>

            <p class="text-slate-500">

                Barang sudah dibeli

            </p>

        </div>

        <div class="bg-red-50 rounded-lg p-4">

            <p class="text-red-600 font-semibold">

                🛒 Remaining

            </p>

            <h3 class="text-3xl font-bold mt-2">

                {{ $uncheckedItems }}

            </h3>

            <p class="text-slate-500">

                Barang belum dibeli

            </p>

        </div>

    </div>

</div>

<!-- Recent Groups -->

<div class="mt-10">

    <div class="flex justify-between items-center">

        <h2 class="text-2xl font-semibold text-slate-800">

            Recent Groups

        </h2>

        <a href="{{ route('groups.index') }}"
           class="text-blue-600 hover:underline">

            View All →

        </a>

    </div>

    <div class="grid md:grid-cols-2 gap-6 mt-6">

        @forelse($groups as $group)

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-xl font-semibold">

                {{ $group->name }}

            </h3>

            <p class="text-slate-500 mt-2">

                {{ $group->description }}

            </p>

            <div class="flex gap-6 mt-5 text-sm text-slate-600">

                <span>

                    👥 {{ $group->members->count() }} Members

                </span>

                <span>

                    🛍 {{ $group->shoppingLists->count() }} Items

                </span>

            </div>

            <a href="{{ route('groups.show', $group->id) }}"
               class="inline-block mt-5 bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700">

                Open Group

            </a>

        </div>

        @empty

        <div class="col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">

            <h3 class="text-xl font-semibold">

                Belum ada group

            </h3>

            <p class="text-slate-500 mt-2">

                Silakan buat group pertama Anda.

            </p>

        </div>

        @endforelse

    </div>

</div>

<div class="mt-10">

    <h2 class="text-2xl font-bold text-slate-800 mb-6">

        Quick Access

    </h2>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

        <a href="{{ route('groups.index') }}"
        class="bg-slate-800 text-white rounded-xl p-6 hover:bg-slate-700 transition">

            <div class="text-4xl mb-3">
                👥
            </div>

            <div class="font-semibold">
                My Groups
            </div>

        </a>

        <a href="{{ route('payments.history') }}"
        class="bg-white rounded-xl shadow border border-slate-200 p-6 hover:shadow-lg transition">

            <div class="text-4xl mb-3">
                📜
            </div>

            <div class="font-semibold text-slate-700">
                Riwayat
            </div>

        </a>

        <a href="{{ route('profile.edit') }}"
        class="bg-white rounded-xl shadow border border-slate-200 p-6 hover:shadow-lg transition">

            <div class="text-4xl mb-3">
                👤
            </div>

            <div class="font-semibold text-slate-700">
                Profile
            </div>

        </a>

        <a href="{{ route('groups.create') }}"
        class="bg-emerald-500 text-white rounded-xl p-6 hover:bg-emerald-600 transition">

            <div class="text-4xl mb-3">
                ➕
            </div>

            <div class="font-semibold">
                New Group
            </div>

        </a>

    </div>

</div>

@endsection