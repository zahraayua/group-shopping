<section>

    <header>

        <h3 class="text-xl font-bold text-red-600 mb-2">
            Hapus Akun
        </h3>

        <p class="text-slate-500">
            Menghapus akun bersifat permanen. Semua data grup, daftar belanja, dan riwayat transaksi yang terkait dengan akun ini akan ikut terhapus.
        </p>

    </header>

    <div class="mt-6">

        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition">

            Hapus Akun

        </button>

    </div>

    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable>

        <form
            method="POST"
            action="{{ route('profile.destroy') }}"
            class="p-8">

            @csrf
            @method('DELETE')

            <h2 class="text-2xl font-bold text-red-600 mb-3">

                Konfirmasi Hapus Akun

            </h2>

            <p class="text-slate-500 mb-6">

                Tindakan ini tidak dapat dibatalkan.
                Masukkan password untuk mengonfirmasi penghapusan akun.

            </p>

            <div>

                <label class="block font-semibold mb-2">

                    Password

                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                    placeholder="Masukkan password">

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="mt-2"/>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2 rounded-xl">

                    Batal

                </button>

                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl">

                    Ya, Hapus Akun

                </button>

            </div>

        </form>

    </x-modal>

</section>