<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ $shopProfile->name ?? 'CUPOS' }}</title>

    @if ($shopProfile?->logo)
        <link rel="icon" type="image/png" href="{{ Storage::url($shopProfile->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    @include('partials.theme-style')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="cupos-page-bg min-h-svh flex items-center justify-center p-4 sm:p-6">

    <div
        class="w-full max-w-[1100px] max-h-[calc(100svh-2rem)] sm:max-h-[calc(100svh-3rem)] rounded-[28px] overflow-y-auto shadow-2xl grid grid-cols-1 md:grid-cols-2 bg-white">

        {{-- PANEL KIRI --}}
        <div class="cupos-left-panel relative hidden md:flex flex-col justify-between p-10 text-white">

            <div class="flex items-center gap-2">
            </div>

            <div class="flex flex-col items-center text-center gap-5 pb-4">
                <div class="cupos-logo-mark w-16 h-16 rounded-2xl flex items-center justify-center overflow-hidden">
                    @if ($shopProfile?->logo)
                        <img src="{{ Storage::url($shopProfile->logo) }}" alt="{{ $shopProfile->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="cupos-logo-pie w-8 h-8 rounded-full"></span>
                    @endif
                </div>

                <h1 class="font-display text-3xl font-extrabold leading-tight max-w-[450px]">
                    Satu Aplikasi untuk Semua Transaksi Kasir Anda
                </h1>

                <p class="text-xs text-white/40 max-w-[450px] leading-relaxed">
                    Catat penjualan, kelola stok, dan pantau laporan toko Anda secara
                    real-time, semua dari satu dashboard yang simpel.
                </p>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="flex flex-col p-8 sm:p-12">

            <div class="flex items-center justify-between">
                <div class="cupos-logo-mark w-9 h-9 rounded-xl flex items-center justify-center overflow-hidden md:hidden">
                    @if ($shopProfile?->logo)
                        <img src="{{ Storage::url($shopProfile->logo) }}" alt="{{ $shopProfile->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="cupos-logo-pie w-4 h-4 rounded-full"></span>
                    @endif
                </div>
                <span class="hidden md:block"></span>
            </div>

            <div class="flex-1 flex flex-col justify-center max-w-sm mx-auto w-full">

                <div class="text-center mb-8">
                    <h2 class="font-display text-2xl font-bold text-gray-900">
                        Selamat Datang Kembali di <br> {{ $shopProfile->name ?? 'CUPOS' }}!
                    </h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Coffee Unified POS
                    </p>

                    <p class="text-xs text-gray-400 mt-1 italic leading-relaxed">
                        Smart Point of Sale System for Modern Coffee Shops
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" id="email" required autofocus
                            placeholder="johndoe@mail.com"
                            class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none transition">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                placeholder="minimal 8 karakter"
                                class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-11 text-sm text-gray-900 placeholder-gray-400 outline-none transition">
                            <button type="button" id="cupos-toggle-password"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="cupos-eye-icon" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="cupos-btn-primary w-full text-white font-semibold text-sm rounded-xl py-3 mt-1 flex items-center justify-center gap-2 transition">
                        Masuk
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </button>

                    <a href="#" id="cupos-open-forgot" class="text-center text-sm text-gray-700 underline font-medium">
                        Lupa password?
                    </a>
                </form>
            </div>

            <div class="flex flex-col items-center gap-2 text-xs text-gray-400 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <span>&copy; {{ date('Y') }} {{ $shopProfile->name ?? 'CUPOS' }}</span>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-600">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-gray-600">Bantuan</a>
                </div>
                <span class="text-gray-300">Powered by CUPOS</span>
            </div>
        </div>
    </div>

{{-- MODAL LUPA PASSWORD --}}
    <div id="cupos-forgot-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl p-6 relative">
            <button type="button" id="cupos-close-forgot" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>

            {{-- STEP 1: EMAIL --}}
            <div id="cupos-step-email">
                <h3 class="font-display text-lg font-bold text-gray-900 mb-1">Lupa Password</h3>
                <p class="text-xs text-gray-500 mb-4">Masukkan email Anda, kami akan mengirimkan kode OTP.</p>
                <input type="email" id="cupos-forgot-email" placeholder="johndoe@mail.com"
                    class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none mb-2">
                <p id="cupos-error-email" class="text-xs text-red-500 mb-2 hidden"></p>
                <button type="button" id="cupos-send-otp"
                    class="cupos-btn-primary w-full text-white font-semibold text-sm rounded-xl py-3">
                    Kirim OTP
                </button>
            </div>

            {{-- STEP 2: OTP + PASSWORD BARU --}}
            <div id="cupos-step-otp" class="hidden">
                <h3 class="font-display text-lg font-bold text-gray-900 mb-1">Verifikasi OTP</h3>
                <p class="text-xs text-gray-500 mb-4">Masukkan kode OTP yang dikirim ke email Anda dan password baru.</p>
                <input type="text" id="cupos-otp-input" placeholder="6 digit OTP" maxlength="6"
                    class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none mb-2">
                <input type="password" id="cupos-new-password" autocomplete="new-password" placeholder="Password baru"
                    class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none mb-2">
                <input type="password" id="cupos-new-password-confirm" autocomplete="new-password" placeholder="Konfirmasi password baru"
                    class="cupos-input w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none mb-2">
                <p id="cupos-error-otp" class="text-xs text-red-500 mb-2 hidden"></p>
                <button type="button" id="cupos-reset-password"
                    class="cupos-btn-primary w-full text-white font-semibold text-sm rounded-xl py-3">
                    Reset Password
                </button>
            </div>

            {{-- STEP 3: SUKSES --}}
            <div id="cupos-step-success" class="hidden text-center">
                <h3 class="font-display text-lg font-bold text-gray-900 mb-1">Berhasil!</h3>
                <p class="text-xs text-gray-500 mb-4">Password Anda telah diubah. Silakan login kembali.</p>
                <button type="button" id="cupos-close-success"
                    class="cupos-btn-primary w-full text-white font-semibold text-sm rounded-xl py-3">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content
                ?? '{{ csrf_token() }}';

            const modal = document.getElementById('cupos-forgot-modal');
            const openBtn = document.getElementById('cupos-open-forgot');
            const closeBtn = document.getElementById('cupos-close-forgot');
            const closeSuccessBtn = document.getElementById('cupos-close-success');

            const stepEmail = document.getElementById('cupos-step-email');
            const stepOtp = document.getElementById('cupos-step-otp');
            const stepSuccess = document.getElementById('cupos-step-success');

            const emailInput = document.getElementById('cupos-forgot-email');
            const errorEmail = document.getElementById('cupos-error-email');
            const sendOtpBtn = document.getElementById('cupos-send-otp');

            const otpInput = document.getElementById('cupos-otp-input');
            const newPasswordInput = document.getElementById('cupos-new-password');
            const newPasswordConfirmInput = document.getElementById('cupos-new-password-confirm');
            const errorOtp = document.getElementById('cupos-error-otp');
            const resetBtn = document.getElementById('cupos-reset-password');

            function resetModal() {
                stepEmail.classList.remove('hidden');
                stepOtp.classList.add('hidden');
                stepSuccess.classList.add('hidden');
                errorEmail.classList.add('hidden');
                errorOtp.classList.add('hidden');
                emailInput.value = '';
                otpInput.value = '';
                newPasswordInput.value = '';
                newPasswordConfirmInput.value = '';
            }

            openBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                resetModal();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            closeBtn?.addEventListener('click', closeModal);
            closeSuccessBtn?.addEventListener('click', closeModal);

            sendOtpBtn?.addEventListener('click', async () => {
                errorEmail.classList.add('hidden');
                sendOtpBtn.disabled = true;
                sendOtpBtn.textContent = 'Mengirim...';

                try {
                    const res = await fetch('{{ route('password.send-otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ email: emailInput.value }),
                    });

                    const rawText = await res.text();
                    let data;
                    try {
                        data = JSON.parse(rawText);
                    } catch {
                        console.error('Respons bukan JSON. Status:', res.status, 'Body:', rawText);
                        errorEmail.textContent = `Server error (status ${res.status}). Cek console untuk detail.`;
                        errorEmail.classList.remove('hidden');
                        return;
                    }

                    if (!res.ok) {
                        const msg = data.errors?.email?.[0] ?? data.message ?? 'Terjadi kesalahan.';
                        errorEmail.textContent = msg;
                        errorEmail.classList.remove('hidden');
                        return;
                    }

                    stepEmail.classList.add('hidden');
                    stepOtp.classList.remove('hidden');
                } catch (err) {
                    console.error('Fetch error:', err);
                    errorEmail.textContent = 'Gagal menghubungi server: ' + err.message;
                    errorEmail.classList.remove('hidden');
                } finally {
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.textContent = 'Kirim OTP';
                }
            });

            resetBtn?.addEventListener('click', async () => {
                errorOtp.classList.add('hidden');
                resetBtn.disabled = true;
                resetBtn.textContent = 'Memproses...';

                try {
                    const res = await fetch('{{ route('password.reset') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            email: emailInput.value,
                            otp: otpInput.value,
                            password: newPasswordInput.value,
                            password_confirmation: newPasswordConfirmInput.value,
                        }),
                    });

                    const rawText = await res.text();
                    let data;
                    try {
                        data = JSON.parse(rawText);
                    } catch {
                        console.error('Respons bukan JSON. Status:', res.status, 'Body:', rawText);
                        errorOtp.textContent = `Server error (status ${res.status}). Cek console untuk detail.`;
                        errorOtp.classList.remove('hidden');
                        return;
                    }

                    if (!res.ok) {
                        const msg = data.errors?.otp?.[0]
                            ?? data.errors?.password?.[0]
                            ?? data.message
                            ?? 'Terjadi kesalahan.';
                        errorOtp.textContent = msg;
                        errorOtp.classList.remove('hidden');
                        return;
                    }

                    stepOtp.classList.add('hidden');
                    stepSuccess.classList.remove('hidden');
                } catch (err) {
                    console.error('Fetch error:', err);
                    errorOtp.textContent = 'Gagal menghubungi server: ' + err.message;
                    errorOtp.classList.remove('hidden');
                } finally {
                    resetBtn.disabled = false;
                    resetBtn.textContent = 'Reset Password';
                }
            });
        })();
    </script>

</body>

</html>
