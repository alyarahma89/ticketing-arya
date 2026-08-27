@extends('layouts.main')

@section('title', 'Invoice ' . $transaction->event->name . ' | ARTIX ID')

<!-- ── MENYUNTIKKAN CSS KHUSUS HALAMAN INVOICE ── -->
@push('styles')
<style>
    /* Animasi Reveal */
    .reveal-up { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up.active { opacity: 1; transform: translateY(0); }
    .delay-100 { transition-delay: 100ms; }
    .delay-200 { transition-delay: 200ms; }
</style>
@endpush

@section('content')

    <!-- ── HEADER HALAMAN INVOICE ── -->
    <div class="pt-28 pb-6 bg-white dark:bg-transparent border-b border-slate-200 dark:border-white/10 transition-colors">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#0066FF] dark:text-white/60 dark:hover:text-white transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <h1 class="font-montserrat font-black text-2xl text-slate-900 dark:text-white">
                Invoice <span class="text-[#0066FF] dark:text-[#00C2FF]">Pembayaran</span>
            </h1>
            <div class="hidden md:block w-24"></div> <!-- Spacer Penyeimbang -->
        </div>
    </div>

    <!-- ── KONTEN UTAMA INVOICE ── -->
    <div class="py-12 flex-grow transition-colors bg-[#F8FAFC] dark:bg-[#020C1F]">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Pesan Sukses / Error -->
            @if (session('success'))
                <div class="reveal-up active flex items-center gap-3 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 p-4 rounded-2xl mb-8 shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="reveal-up active flex items-center gap-3 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 p-4 rounded-2xl mb-8 shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- KOLOM KIRI: Detail Event -->
                <div class="lg:col-span-8 reveal-up">

                    <!-- Gambar Event -->
                    <div class="w-full h-64 md:h-96 rounded-3xl overflow-hidden mb-8 border border-slate-200 dark:border-white/10 shadow-sm bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $transaction->event->image ? asset('storage/' . $transaction->event->image) : 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $transaction->event->name }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Informasi Event -->
                    <div class="bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-3xl p-6 md:p-8 shadow-sm">
                        <div class="inline-block bg-blue-50 dark:bg-[#0066FF20] text-[#0066FF] dark:text-[#00C2FF] font-bold text-xs px-4 py-1.5 rounded-full mb-4 font-montserrat tracking-wider uppercase">
                            🎫 {{ $transaction->event->category->name ?? 'Tiket Event' }}
                        </div>

                        <h2 class="font-montserrat font-black text-3xl md:text-4xl text-slate-900 dark:text-white mb-6 leading-tight">
                            {{ $transaction->event->name }}
                        </h2>

                        @php
                            $matchedPackage = null;
                            if ($transaction->ticketPackage) {
                                $matchedPackage = $transaction->ticketPackage;
                            } elseif ($transaction->event && $transaction->event->ticketPackages) {
                                $matchedPackage = $transaction->event->ticketPackages->where('name', $transaction->ticket_type)->first();
                            }
                            $isOnlineTicket = (strtolower($transaction->ticket_type) === 'online' || stripos($transaction->ticket_type, 'livestream') !== false || stripos($transaction->ticket_type, 'online') !== false);
                            $packageTitle = $matchedPackage ? $matchedPackage->name : ($isOnlineTicket ? 'Akses Virtual (Livestream)' : ($transaction->ticket_type ?: 'Reguler'));
                        @endphp

                        <!-- Box Detail Paket Tiket -->
                        <div class="bg-slate-50 dark:bg-[#020C1F] border border-blue-100 dark:border-blue-500/20 border-l-4 border-l-[#0066FF] rounded-2xl p-5 mb-6">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-white/40">Paket & Kategori Tiket</span>
                                    <h4 class="font-black text-lg text-[#0066FF] dark:text-[#00C2FF] font-montserrat uppercase mt-0.5">
                                        ⭐ {{ $packageTitle }}
                                    </h4>
                                </div>
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-[#0066FF] dark:bg-[#0066FF20] dark:text-[#00C2FF]">
                                    {{ $transaction->quantity }} Tiket
                                </span>
                            </div>
                            @if($matchedPackage && $matchedPackage->description)
                                <p class="text-xs font-semibold text-slate-600 dark:text-white/70 mt-2 flex items-center gap-1.5 pt-2 border-t border-slate-200 dark:border-white/10">
                                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500 shrink-0"></i>
                                    <span><strong>Fasilitas:</strong> {{ $matchedPackage->description }}</span>
                                </p>
                            @endif
                        </div>

                        <!-- Grid Info Waktu & Lokasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Box Waktu -->
                            <div class="flex items-center gap-4 bg-slate-50 dark:bg-[#020C1F] p-5 rounded-2xl border border-slate-100 dark:border-white/5">
                                <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-[#FF7A0020] text-[#FF7A00] flex items-center justify-center shrink-0">
                                    <i data-lucide="calendar" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500 dark:text-white/40 mb-1">Tanggal & Waktu</p>
                                    <p class="font-bold text-sm text-slate-900 dark:text-white">
                                        {{ date('d M Y - H:i', strtotime($transaction->event->event_date)) }} WIB
                                    </p>
                                </div>
                            </div>

                            <!-- Box Lokasi -->
                            <div class="flex items-center gap-4 bg-slate-50 dark:bg-[#020C1F] p-5 rounded-2xl border border-slate-100 dark:border-white/5">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-[#0066FF20] text-[#0066FF] flex items-center justify-center shrink-0">
                                    <i data-lucide="map-pin" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500 dark:text-white/40 mb-1">
                                        {{ $isOnlineTicket ? 'Format / Akses Acara' : 'Lokasi Acara' }}
                                    </p>
                                    <p class="font-bold text-sm text-slate-900 dark:text-white line-clamp-2">
                                        {{ $isOnlineTicket ? 'Online via YouTube Livestream' : $transaction->event->location }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: Ringkasan Invoice & Aksi (Sticky) -->
                <div class="lg:col-span-4">
                    <div class="sticky top-28 reveal-up delay-100 bg-white dark:bg-[#0A1A3A] border border-slate-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-xl">

                        <!-- Header Banner -->
                        <div class="bg-slate-900 dark:bg-[#020C1F] p-4 text-center border-b border-white/10">
                            <h3 class="font-montserrat font-bold text-white tracking-widest text-sm uppercase">
                                Ringkasan Tagihan
                            </h3>
                        </div>

                        <div class="p-6 md:p-8">
                            <!-- Status Transaksi -->
                            <div class="flex justify-between items-center bg-slate-50 dark:bg-white/5 p-4 rounded-2xl border border-slate-100 dark:border-white/5 mb-6">
                                <span class="text-sm font-bold text-slate-500 dark:text-white/50">Status:</span>

                                @if($transaction->payment_status == 'pending')
                                    <span class="bg-orange-100 text-orange-600 dark:bg-orange-500/20 dark:text-orange-400 font-bold text-xs px-3 py-1.5 rounded-full font-montserrat">MENUNGGU BAYAR</span>
                                @elseif(in_array($transaction->payment_status, ['paid', 'success', 'settlement']))
                                    <span class="bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 font-bold text-xs px-3 py-1.5 rounded-full font-montserrat">LUNAS</span>
                                @elseif($transaction->payment_status == 'refund_requested')
                                    <span class="bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 font-bold text-xs px-3 py-1.5 rounded-full font-montserrat">REFUND DIPROSES</span>
                                @elseif($transaction->payment_status == 'refunded')
                                    <span class="bg-slate-200 text-slate-600 dark:bg-white/10 dark:text-white/40 font-bold text-xs px-3 py-1.5 rounded-full font-montserrat">DIKEMBALIKAN</span>
                                @else
                                    <span class="bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400 font-bold text-xs px-3 py-1.5 rounded-full font-montserrat">GAGAL / BATAL</span>
                                @endif
                            </div>

                            <!-- Total Harga -->
                            <div class="border-t border-dashed border-slate-200 dark:border-white/20 pt-6 mb-8 text-center">
                                <p class="text-sm font-bold text-slate-500 dark:text-white/50 mb-2">Total Tagihan</p>
                                <p class="font-montserrat font-black text-3xl md:text-4xl text-gradient-blue">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Area Tombol Aksi -->
                            @if($transaction->payment_status == 'pending' && !empty($snapToken))
                                <button id="pay-button" class="w-full flex items-center justify-center gap-2 py-4 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md shadow-blue-500/30" style="background: linear-gradient(135deg, #0066FF, #00C2FF);">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i> Bayar Sekarang
                                </button>
                                <p class="text-center text-xs font-medium text-slate-400 dark:text-white/30 mt-4 flex items-center justify-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i> Transaksi aman oleh Midtrans
                                </p>

                            @elseif(in_array($transaction->payment_status, ['paid', 'success', 'settlement']))
                                <div class="flex flex-col gap-3">
                                    @if($isOnlineTicket && !empty($transaction->event->youtube_link))
                                        <!-- Tombol Tonton Livestream -->
                                        <a href="{{ $transaction->event->youtube_link }}" target="_blank" class="w-full flex items-center justify-center gap-2 py-4 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md bg-red-600 hover:bg-red-700 shadow-red-500/25">
                                            <i data-lucide="video" class="w-5 h-5"></i> Tonton Livestream (YouTube)
                                        </a>
                                    @endif

                                    <!-- Tombol Unduh -->
                                    <a href="{{ route('ticket.download', $transaction->id) }}" class="w-full flex items-center justify-center gap-2 py-4 font-bold text-white rounded-xl transition-all hover:scale-105 shadow-md bg-emerald-500 hover:bg-emerald-600">
                                        <i data-lucide="download" class="w-5 h-5"></i> Download Tiket (PDF)
                                    </a>

                                    <!-- Tombol Refund -->
                                    <form action="{{ route('transaction.refund', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tiket ini dan mengajukan refund?');">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 font-bold text-red-500 bg-red-50 hover:bg-red-100 dark:bg-red-500/10 dark:hover:bg-red-500/20 border border-red-200 dark:border-red-500/30 rounded-xl transition-all">
                                            <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Ajukan Refund
                                        </button>
                                    </form>
                                </div>
                                <p class="text-center text-xs font-medium text-slate-400 dark:text-white/30 mt-4">
                                    {{ $isOnlineTicket ? 'Gunakan link streaming di atas untuk menonton siaran langsung.' : 'Cetak atau tunjukkan PDF ini saat masuk area event.' }}
                                </p>

                            @elseif($transaction->payment_status == 'refund_requested')
                                <div class="w-full text-center py-4 font-bold text-amber-600 bg-amber-50 border border-amber-200 dark:bg-amber-500/10 dark:border-amber-500/30 rounded-xl flex items-center justify-center gap-2">
                                    <i data-lucide="clock" class="w-5 h-5"></i> Pengajuan Refund Diproses
                                </div>

                            @elseif($transaction->payment_status == 'refunded')
                                <div class="w-full text-center py-4 font-bold text-slate-500 bg-slate-100 border border-slate-200 dark:bg-white/5 dark:border-white/10 dark:text-white/40 rounded-xl flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i> Dana Telah Dikembalikan
                                </div>

                            @else
                                <div class="w-full text-center py-4 font-bold text-slate-500 bg-slate-100 dark:bg-white/5 dark:text-white/40 rounded-xl">
                                    <i data-lucide="lock" class="w-5 h-5 mx-auto mb-1"></i> Sesi Berakhir
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

<!-- ── MENYUNTIKKAN SCRIPT KHUSUS HALAMAN INVOICE ── -->
@push('scripts')
    <script>
        // ── Animasi Reveal ──
        document.addEventListener("DOMContentLoaded", function () {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, { root: null, rootMargin: "0px 0px -50px 0px", threshold: 0.1 });

            document.querySelectorAll('.reveal-up').forEach(el => revealObserver.observe(el));
        });
    </script>

    <!-- ── SCRIPT MIDTRANS ── -->
    @if($transaction->payment_status == 'pending' && !empty($snapToken))
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        window.location.href = "{{ url('/midtrans/finish') }}?order_id={{ $transaction->order_id }}";
                    },
                    onPending: function(result){
                        window.location.href = "{{ url('/midtrans/finish') }}?order_id={{ $transaction->order_id }}";
                    },
                    onError: function(result){
                        alert("Pembayaran gagal.");
                    },
                    onClose: function(){
                        alert('Kamu menutup jendela pembayaran sebelum menyelesaikannya.');
                    }
                });
            });
        </script>
    @endif
@endpush
