@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex">

    {{-- LEFT PANEL --}}

    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 text-white flex-col justify-center px-20">

        <h1 class="text-5xl font-bold leading-tight">

            Group Shopping

        </h1>

        <p class="text-xl mt-6 text-slate-300">

            Collaborative Shopping Application

        </p>

        <p class="mt-8 text-slate-400 leading-8">

            Buat akun dan mulai mengelola daftar belanja bersama,
            scan nota otomatis, split bill, serta pantau pembayaran
            dengan mudah.

        </p>

        <div class="mt-12 text-8xl">

            🛒

        </div>

    </div>

    {{-- RIGHT PANEL --}}

    <div class="flex-1 flex items-center justify-center bg-slate-100">

        <div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-md">

            <h2 class="text-3xl font-bold text-slate-800">

                Create Account

            </h2>

            <p class="text-slate-500 mt-2">

                Daftar untuk mulai menggunakan Group Shopping.

            </p>

            <form
                method="POST"
                action="{{ route('register') }}"
                class="mt-8 space-y-5">

                @csrf

                {{-- Nama --}}

                <div>

                    <label class="font-semibold">

                        Nama

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"/>

                </div>

                {{-- Email --}}

                <div>

                    <label class="font-semibold">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"/>

                </div>

                {{-- Password --}}

                <div>

                    <label class="font-semibold">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"/>

                </div>

                {{-- Konfirmasi Password --}}

                <div>

                    <label class="font-semibold">

                        Konfirmasi Password

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                </div>

                <button
                    type="submit"
                    class="w-full bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-xl font-semibold transition">

                    Create Account

                </button>

            </form>

            <div class="text-center mt-8">

                Sudah punya akun?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-slate-800 hover:underline">

                    Login

                </a>

            </div>

        </div>

    </div>

</div>

@endsection