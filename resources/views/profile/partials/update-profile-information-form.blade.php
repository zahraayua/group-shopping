<section>

    <header>

        <h3 class="text-xl font-bold text-slate-800">
            Informasi Akun
        </h3>

        <p class="mt-2 text-slate-500">
            Perbarui nama dan alamat email akun Anda.
        </p>

    </header>

    <form
        id="send-verification"
        method="POST"
        action="{{ route('verification.send') }}">

        @csrf

    </form>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="mt-8 space-y-6">

        @csrf
        @method('PATCH')

        {{-- Nama --}}

        <div>

            <x-input-label
                for="name"
                :value="__('Nama')" />

            <x-text-input
                id="name"
                name="name"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700"/>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')" />

        </div>

        {{-- Email --}}

        <div>

            <x-input-label
                for="email"
                :value="__('Email')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700"/>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

                <div class="mt-4">

                    <p class="text-sm text-amber-600">

                        Email Anda belum diverifikasi.

                    </p>

                    <button
                        form="send-verification"
                        class="mt-2 text-sm font-medium text-slate-800 hover:text-slate-600 underline">

                        Kirim Ulang Email Verifikasi

                    </button>

                    @if (session('status') === 'verification-link-sent')

                        <p class="mt-3 text-sm text-green-600 font-medium">

                            Link verifikasi berhasil dikirim.

                        </p>

                    @endif

                </div>

            @endif

        </div>

        {{-- Tombol --}}

        <div class="flex items-center gap-4">

            <x-primary-button
                class="bg-slate-800 hover:bg-slate-700 rounded-xl px-6 py-3">

                Simpan Perubahan

            </x-primary-button>

            @if (session('status') === 'profile-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-green-600 font-medium">

                    ✔ Berhasil disimpan

                </p>

            @endif

        </div>

    </form>

</section>