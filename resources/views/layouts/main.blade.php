<!DOCTYPE html>
<html>
<head>
    <title>Group Shopping</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 w-72 h-screen bg-slate-900 text-white flex flex-col overflow-y-auto">

        <!-- Logo -->
        <div class="p-8 border-b border-slate-700">

            <h1 class="text-2xl font-bold">
                Group Shopping
            </h1>

            <p class="text-slate-400 text-sm mt-2">
                Collaborative Shopping App
            </p>

        </div>

        <!-- Menu -->
<nav class="flex-1 mt-6">

    <a href="{{ route('dashboard') }}"
       class="block px-8 py-3 hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800 border-l-4 border-amber-400 font-semibold' : '' }}">
        🏠 Dashboard
    </a>

    <a href="{{ route('groups.index') }}"
       class="block px-8 py-3 hover:bg-slate-800 {{ request()->routeIs('groups.*') ? 'bg-slate-800 border-l-4 border-amber-400 font-semibold' : '' }}">
        👥 Groups
    </a>

    <a href="{{ route('profile.edit') }}"
       class="block px-8 py-3 hover:bg-slate-800 {{ request()->routeIs('profile.*') ? 'bg-slate-800 border-l-4 border-amber-400 font-semibold' : '' }}">
        ⚙️ Profile
    </a>

</nav>

        <!-- User Info -->
        <div class="p-6 border-t border-slate-700">

            <p class="font-semibold">
                {{ auth()->user()->name }}
            </p>

            <p class="text-slate-400 text-sm">
                {{ auth()->user()->email }}
            </p>

            <form method="POST"
                  action="{{ route('logout') }}"
                  class="mt-4">

                @csrf

                <button
                    type="submit"
                    class="w-full bg-red-600 py-2 rounded-lg">

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- Main Content -->

    <main class="flex-1 ml-72 p-10">

        @yield('content')

    </main>

</div>

</body>
</html>