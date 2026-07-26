@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex">

    {{-- LEFT --}}

    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 text-white flex-col justify-center px-20">

        <h1 class="text-5xl font-bold leading-tight">

            Group Shopping

        </h1>

        <p class="text-xl mt-6 text-slate-300">

            Collaborative Shopping Application

        </p>

        <p class="mt-8 text-slate-400 leading-8">

            Kelola daftar belanja bersama keluarga maupun teman,
            scan nota otomatis, lakukan split bill,
            dan pantau pembayaran dalam satu aplikasi.

        </p>

        <div class="mt-12 text-8xl">

            🛒

        </div>

    </div>

    {{-- RIGHT --}}

    <div class="flex-1 flex items-center justify-center bg-slate-100">

        <div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-md">

            <h2 class="text-3xl font-bold text-slate-800">

                Login

            </h2>

            <p class="text-slate-500 mt-2">

                Selamat datang kembali.

            </p>

            <x-auth-session-status
                class="mb-4 mt-6"
                :status="session('status')" />

            <form
                method="POST"
                action="{{ route('login') }}"
                class="mt-8 space-y-5">

                @csrf

                <div>

                    <label class="font-semibold">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                </div>

                <div>

                    <label class="font-semibold">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full mt-2 rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700">

                </div>

                <div class="flex items-center justify-between">

                    <label class="flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="remember">

                        Remember Me

                    </label>

                    @if(Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-slate-700 hover:underline text-sm">

                            Forgot Password?

                        </a>

                    @endif

                </div>

                <button
                    class="w-full bg-slate-800 hover:bg-slate-700 text-white py-3 rounded-xl font-semibold">

                    Login

                </button>

            </form>

            <div class="text-center mt-8">

                Belum punya akun?

                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-slate-800 hover:underline">

                    Register

                </a>

            </div>

        </div>

    </div>

</div>

@endsection