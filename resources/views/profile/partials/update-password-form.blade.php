<section>
    <!-- Sembunyikan header bawaan Laravel -->
    <header class="hidden">
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-white/60">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-2 space-y-6">
        @csrf
        @method('put')

        <!-- Input Kata Sandi Saat Ini -->
        <div>
            <label for="current_password" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                {{ __('Kata Sandi Saat Ini') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="key" class="w-4 h-4"></i></span>
                <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                    class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
            </div>
            <!-- Pesan Error -->
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Input Kata Sandi Baru -->
        <div>
            <label for="password" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                {{ __('Kata Sandi Baru') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="lock" class="w-4 h-4"></i></span>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
            </div>
            <!-- Pesan Error -->
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Input Konfirmasi Kata Sandi -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                {{ __('Konfirmasi Kata Sandi') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="shield-check" class="w-4 h-4"></i></span>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                    class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
            </div>
            <!-- Pesan Error -->
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Tombol Simpan & Notifikasi -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white shadow-lg transition-all hover:scale-[1.02] hover:shadow-xl flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #FF7A00, #FF3B30);">
                {{ __('Perbarui Kata Sandi') }} <i data-lucide="save" class="w-4 h-4"></i>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-bold text-emerald-500 flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1.5 rounded-lg"
                >
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ __('Kata sandi diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>
