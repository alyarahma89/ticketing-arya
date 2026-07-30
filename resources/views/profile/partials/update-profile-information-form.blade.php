<section>
    <!-- Header bawaan Laravel kita sembunyikan karena kita sudah punya header kartu di edit.blade.php -->
    <header class="hidden">
        <h2 class="text-lg font-medium text-slate-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-white/60">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-2 space-y-6">
        @csrf
        @method('patch')

        <!-- Input Nama Lengkap -->
        <div>
            <label for="name" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                {{ __('Nama Lengkap') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="user" class="w-4 h-4"></i></span>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                    class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
            </div>
            <x-input-error class="mt-2 text-xs font-bold text-red-500" :messages="$errors->get('name')" />
        </div>

        <!-- Input Email Resmi -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wide">
                {{ __('Email Resmi') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none"><i data-lucide="mail" class="w-4 h-4"></i></span>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                    class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-[#020C1F] border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm font-medium rounded-xl focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all">
            </div>
            <x-input-error class="mt-2 text-xs font-bold text-red-500" :messages="$errors->get('email')" />

            <!-- Peringatan Email Belum Terverifikasi -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-amber-50 dark:bg-[#FFB00015] border border-amber-200 dark:border-[#FFB00030] rounded-lg">
                    <p class="text-xs font-medium text-amber-800 dark:text-amber-400">
                        <i data-lucide="alert-circle" class="w-3 h-3 inline pb-0.5"></i> {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline font-bold hover:text-amber-900 dark:hover:text-amber-300 rounded-md focus:outline-none transition-colors">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600 dark:text-emerald-400">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tombol Simpan & Notifikasi -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-3 rounded-xl text-sm font-bold text-white shadow-lg transition-all hover:scale-[1.02] hover:shadow-xl flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                {{ __('Simpan Perubahan') }} <i data-lucide="save" class="w-4 h-4"></i>
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-bold text-emerald-500 flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1.5 rounded-lg"
                >
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
