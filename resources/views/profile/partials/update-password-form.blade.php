<section>

    <header>

        <h3 class="text-xl font-bold text-slate-800">
            Ubah Password
        </h3>

        <p class="mt-2 text-slate-500">
            Gunakan password yang kuat agar akun Anda tetap aman.
        </p>

    </header>

    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="mt-8 space-y-6">

        @csrf
        @method('PUT')

        {{-- Password Lama --}}

        <div>

            <x-input-label
                for="update_password_current_password"
                :value="__('Password Lama')" />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700" />

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2" />

        </div>

        {{-- Password Baru --}}

        <div>

            <x-input-label
                for="update_password_password"
                :value="__('Password Baru')" />

            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700" />

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2" />

        </div>

        {{-- Konfirmasi Password --}}

        <div>

            <x-input-label
                for="update_password_password_confirmation"
                :value="__('Konfirmasi Password')" />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="block mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700" />

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2" />

        </div>

        {{-- Tombol --}}

        <div class="flex items-center gap-4">

            <x-primary-button
                class="bg-slate-800 hover:bg-slate-700 rounded-xl px-6 py-3">

                Update Password

            </x-primary-button>

            @if (session('status') === 'password-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-green-600 font-medium">

                    ✔ Password berhasil diperbarui

                </p>

            @endif

        </div>

    </form>

</section>