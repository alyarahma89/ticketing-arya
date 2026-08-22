<!-- Memanggil File Induk (Master Layout) -->
@extends('layouts.admin')

<!-- Mengisi Judul Tab Browser -->
@section('title', 'Tambah Pengguna Baru')

<!-- Memasukkan Isi Konten ke Tengah Halaman -->
@section('content')

    <!-- ── HERO SECTION (Kini Menyatu dengan Background Terang) ── -->
    <div class="pt-10 pb-6 px-8 relative">
        <div class="max-w-4xl w-full mx-auto relative z-10">
            <!-- Tombol Kembali Minimalis -->
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] transition-colors group mb-6 w-max">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Daftar Pengguna
            </a>

            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <span class="text-[#0066FF] font-bold text-xs uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100 inline-block mb-3">Manajemen Akses</span>
                    <h1 class="text-3xl font-black tracking-tight font-montserrat text-slate-900 mb-2">Tambah Pengguna Baru</h1>
                    <p class="text-[14px] text-slate-500 font-medium max-w-xl">Daftarkan akun pengguna baru, tetapkan kredensial login, dan tentukan hak akses sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── MAIN FORM AREA ── -->
    <div class="flex-1 max-w-4xl w-full mx-auto pb-10 px-6 relative z-20">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- ALERT ERROR -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-5 rounded-2xl mb-6 text-sm flex gap-3 items-start shadow-sm font-medium">
                    <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5 text-red-500"></i>
                    <div>
                        <span class="font-bold block mb-1 text-red-700">Gagal menambahkan pengguna:</span>
                        <ul class="list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- CARD FORM -->
            <div class="bg-white border border-slate-200 rounded-[24px] shadow-sm p-8 space-y-6 relative overflow-hidden mt-4">
                <!-- Hiasan Garis Atas (Gradasi Orange ke Red) -->
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-[#FF7A00] to-[#FF3B30]"></div>

                <h2 class="text-lg font-black text-slate-800 font-montserrat border-b border-slate-100 pb-4 flex items-center gap-2.5">
                    <div class="p-1.5 bg-orange-50 text-[#FF7A00] rounded-lg"><i data-lucide="contact" class="w-5 h-5"></i></div>
                    Data Kredensial Pengguna
                </h2>

                <div class="space-y-6">
                    <!-- Field: Nama Lengkap -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="user" class="w-5 h-5"></i></span>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                                class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Field: Email -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="mail" class="w-5 h-5"></i></span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="budi@example.com"
                                    class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- Field: Role -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Hak Akses (Role)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="shield" class="w-5 h-5"></i></span>
                                <select name="role" id="role" required class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran Pengguna --</option>
                                    <option value="panitia" {{ old('role') == 'panitia' ? 'selected' : '' }}>Panitia (Scan Tiket)</option>
                                    <option value="eo" {{ old('role') == 'eo' ? 'selected' : '' }}>Event Organizer (EO)</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Platform)</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pelanggan Biasa</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400"><i data-lucide="chevron-down" class="w-4 h-4"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field: Password -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 mb-2 uppercase tracking-widest">Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i data-lucide="lock" class="w-5 h-5"></i></span>
                            <input type="password" name="password" id="password" required placeholder="Contoh: ArT1x_@2026!"
                                class="w-full bg-slate-50 focus:bg-white border border-slate-200 text-slate-900 text-sm font-bold rounded-[12px] pl-11 pr-12 py-3.5 focus:outline-none focus:border-[#0066FF] focus:ring-4 focus:ring-[#0066FF]/10 transition-all duration-200 placeholder:font-medium placeholder:text-slate-400">

                            <!-- Ikon Mata -->
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 hover:text-[#0066FF] transition-colors focus:outline-none">
                                <i data-lucide="eye" id="eyeIcon" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <span class="text-[11px] text-slate-500 font-medium mt-2 flex items-start gap-1.5 leading-relaxed">
                            <i data-lucide="info" class="w-4 h-4 text-[#0066FF] shrink-0 mt-0.5"></i>
                            Minimal 8 karakter, wajib mengandung huruf (Besar & kecil), angka, dan simbol (@, #, $, dll).
                        </span>
                    </div>
                </div>
            </div>

            <!-- ACTION BAR BAWAH -->
            <div class="mt-8 bg-white border border-slate-200 rounded-[24px] p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-40">
                <span class="text-[13px] text-slate-500 font-medium flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i> Pastikan untuk memberikan role yang sesuai dengan wewenang.
                </span>
                <div class="flex items-center gap-4 w-full sm:w-auto shrink-0">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-500 hover:text-slate-800 font-bold px-6 py-3.5 transition-colors rounded-[12px] hover:bg-slate-100 border border-transparent w-full sm:w-auto text-center">Batal</a>
                    <button type="submit" class="bg-gradient-to-r from-[#0066FF] to-[#00C2FF] hover:opacity-90 text-white px-8 py-3.5 rounded-[12px] text-sm font-bold font-montserrat transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 active:translate-y-0 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                        Simpan Pengguna <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

<!-- ── MEMASUKKAN SCRIPT KHUSUS HALAMAN INI ── -->
@push('scripts')
<script>
    const togglePasswordBtn = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePasswordBtn.addEventListener('click', function () {
        // Cek apakah tipenya 'password' atau 'text'
        const isPassword = passwordInput.getAttribute('type') === 'password';

        // Ubah tipe input
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        // Ubah atribut data-lucide (eye menjadi eye-off)
        if (isPassword) {
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            eyeIcon.setAttribute('data-lucide', 'eye');
        }

        // Re-render Ikon Lucide spesifik
        lucide.createIcons();
    });
</script>
@endpush
