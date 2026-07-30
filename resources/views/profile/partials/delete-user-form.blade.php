<section class="space-y-6">
    <!-- Sembunyikan header bawaan Laravel -->
    <header class="hidden">
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-white/60">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Peringatan Visual Sebelum Menghapus -->
    <div class="bg-red-50 dark:bg-[#FF3B3015] border border-red-200 dark:border-[#FF3B3030] rounded-xl p-4 flex items-start gap-3">
        <i data-lucide="info" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
        <div class="text-sm font-medium text-red-800 dark:text-red-200">
            <p class="font-bold mb-1">Peringatan Tindakan Permanen</p>
            <p class="text-xs">Setelah akun Anda dihapus, semua sumber daya, tiket, dan data akan dihapus secara permanen. Pastikan Anda telah mengunduh informasi penting sebelum melanjutkan.</p>
        </div>
    </div>

    <!-- Tombol Pemicu Modal Hapus -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-xl text-sm font-bold text-white shadow-lg transition-all hover:scale-[1.02] hover:shadow-xl flex items-center justify-center gap-2"
        style="background: linear-gradient(135deg, #FF3B30, #dc2626);"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i> {{ __('Hapus Akun Saya') }}
    </button>

    <!-- Modal Konfirmasi Bawaan Laravel -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <!-- Konten di dalam Modal -->
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white dark:bg-[#041B4A] rounded-2xl relative overflow-hidden">
            @csrf
            @method('delete')

            <!-- Hiasan Garis Atas di Modal -->
            <div class="absolute top-0 left-0 w-full h-1.5" style="background: linear-gradient(90deg, #FF3B30, #FF7A00);"></div>

            <div class="flex items-center gap-3 mb-4">
                <div class="bg-red-50 dark:bg-[#FF3B3020] p-2 rounded-xl text-[#FF3B30]">
                    <i data-lucide="alert-octagon" class="w-6 h-6"></i>
                </div>
                <h2 class="text-xl font-black font-montserrat text-slate-900 dark:text-white">
                    {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                </h2>
            </div>

            <p class="text-sm font-medium text-slate-500 dark:text-white/60 mb-6">
                {{ __('Setelah akun dihapus, semua data akan hilang secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi tindakan ini.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                    {{ __('Kata Sandi Anda') }}
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#FF3B30] focus:ring-4 focus:ring-[#FF3B30]/10 transition-all"
                        placeholder="{{ __('Masukkan Kata Sandi') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs font-bold text-red-500" />
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-white/10 flex items-center justify-end gap-3">
                <!-- Tombol Batal -->
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:text-white/80 dark:hover:bg-white/20 rounded-xl transition-colors">
                    {{ __('Batal') }}
                </button>

                <!-- Tombol Hapus (Submit) -->
                <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white shadow-md transition-all hover:scale-[1.02] flex items-center gap-2" style="background: linear-gradient(135deg, #FF3B30, #dc2626);">
                    {{ __('Ya, Hapus Akun') }} <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </x-modal>
</section>
