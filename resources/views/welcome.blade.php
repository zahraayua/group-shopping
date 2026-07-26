<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Shopping</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center px-6">

    <div class="max-w-5xl w-full">

        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            <div class="grid md:grid-cols-2">

                <!-- LEFT -->

                <div class="bg-slate-800 text-white p-12 flex flex-col justify-center">

                    <h1 class="text-5xl font-bold">
                        Group Shopping
                    </h1>

                    <p class="mt-5 text-slate-300 text-lg">
                        Collaborative Shopping Management System
                    </p>

                    <div class="mt-10 space-y-4">

                        <div>🛒 Shopping List Bersama</div>

                        <div>👥 Kelola Member Group</div>

                        <div>💬 Chat Antar Anggota</div>

                        <div>📊 Shopping Summary</div>

                    </div>

                </div>

                <!-- RIGHT -->

                <div class="p-12 flex flex-col justify-center">

                    <h2 class="text-3xl font-bold text-slate-800">

                        Selamat Datang

                    </h2>

                    <p class="text-slate-500 mt-4">

                        Kelola belanja bersama menjadi lebih mudah,
                        cepat, dan terorganisir.

                    </p>

                    <div class="mt-10 space-y-4">

                        @if (Route::has('login'))

                            @auth

                                <a href="{{ route('dashboard') }}"
                                   class="block w-full text-center bg-slate-800 text-white py-3 rounded-xl hover:bg-slate-700">

                                    Dashboard

                                </a>

                            @else

                                <a href="{{ route('login') }}"
                                   class="block w-full text-center bg-slate-800 text-white py-3 rounded-xl hover:bg-slate-700">

                                    Login

                                </a>

                                @if (Route::has('register'))

                                    <a href="{{ route('register') }}"
                                       class="block w-full text-center border border-slate-300 py-3 rounded-xl hover:bg-slate-100">

                                        Register

                                    </a>

                                @endif

                            @endauth

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>