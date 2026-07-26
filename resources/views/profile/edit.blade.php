@extends('layouts.main')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        👤 My Profile
    </h1>

    <p class="text-slate-500 mt-2">
        Kelola informasi akun Anda.
    </p>

</div>

<div class="grid lg:grid-cols-3 gap-8">

    {{-- Profile Card --}}

    <div class="bg-white rounded-2xl shadow border border-slate-200 p-8 h-fit">

        <div class="flex flex-col items-center">

            <div class="w-28 h-28 rounded-full bg-slate-800 flex items-center justify-center text-white text-5xl">

                👤

            </div>

            <h2 class="mt-5 text-2xl font-bold text-slate-800">

                {{ auth()->user()->name }}

            </h2>

            <p class="text-slate-500 mt-1">

                {{ auth()->user()->email }}

            </p>

        </div>

        <div class="border-t mt-8 pt-6 space-y-4">

            <div>

                <p class="text-xs text-slate-400">

                    Bergabung Sejak

                </p>

                <p class="font-semibold text-slate-700">

                    {{ auth()->user()->created_at->format('d F Y') }}

                </p>

            </div>

            <div>

                <p class="text-xs text-slate-400">

                    Status

                </p>

                <span class="inline-block mt-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                    Active

                </span>

            </div>

        </div>

    </div>

    {{-- Form Section --}}

    <div class="lg:col-span-2 space-y-6">

        {{-- Update Profile --}}

        <div class="bg-white rounded-2xl shadow border border-slate-200 p-8">

            <h2 class="text-xl font-bold text-slate-800 mb-6">

                ✏️ Edit Profile

            </h2>

            @include('profile.partials.update-profile-information-form')

        </div>

        {{-- Password --}}

        <div class="bg-white rounded-2xl shadow border border-slate-200 p-8">

            <h2 class="text-xl font-bold text-slate-800 mb-6">

                🔒 Ubah Password

            </h2>

            @include('profile.partials.update-password-form')

        </div>

        {{-- Delete --}}

        <div class="bg-white rounded-2xl shadow border border-red-200 p-8">

            <h2 class="text-xl font-bold text-red-600 mb-6">

                ⚠ Danger Zone

            </h2>

            @include('profile.partials.delete-user-form')

        </div>

    </div>

</div>

@endsection