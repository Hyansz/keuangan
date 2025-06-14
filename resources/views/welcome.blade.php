<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>NimBank</title>
    <link rel="icon" href="{{ asset('balance.svg') }}" type="image/svg" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    />

    {{-- Google Font --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"
    />

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />

    {{-- Tailwind --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <!-- Animate.css -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>

<body class="bg-white text-gray-800 animate__animated animate__fadeIn">
    <div class="h-screen bg-blue-600 bg-gradient-to-br from-blue-700 to-blue-400 relative overflow-hidden flex flex-col">
        {{-- Topbar --}}
        <div class="bg-blue-600 bg-gradient-to-tr from-blue-700 to-blue-400">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-3">
                    {{-- Logo + Nama --}}
                    <a href="#" class="flex items-center gap-3 text-white">
                        <i class="fa-solid fa-scale-balanced text-3xl" style="transform: rotate(-15deg);"></i>
                        <div class="text-2xl font-bold leading-tight">NimBank <sup class="text-sm font-normal">1.0</sup></div>
                    </a>

                    {{-- Tombol --}}
                    @if (Route::has('login'))
                        <div>
                            <nav class="flex items-center gap-3">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                                        Dashboard
                                    </a>
                                @else
                                    {{-- Mobile: hanya Masuk --}}
                                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition block md:hidden">
                                        Masuk
                                    </a>

                                    {{-- Desktop: Login dan Register --}}
                                    <div class="hidden md:flex gap-3">
                                        <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                                            Login
                                        </a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition">
                                                Register
                                            </a>
                                        @endif
                                    </div>
                                @endauth
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
        @endif

        <!-- Hero Section -->
<section
    class="flex items-center justify-center flex-grow px-6 py-12"
    style="min-height: 400px;"
>
    <div
        class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-white"
    >
        <!-- Teks -->
        <div class="text-center md:text-left px-2 md:px-0">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
                Kelola Keuangan Pribadi Jadi Lebih Mudah
            </h1>
            <p class="text-base sm:text-lg md:text-xl mb-8">
                Nimbank membantu kamu mencatat pemasukan dan pengeluaran
                harian dengan mudah dan rapi.
            </p>
            <a
                href="#fitur"
                class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold shadow-lg hover:bg-gray-100 transition inline-block"
            >
                Lihat Fitur
            </a>
        </div>

        <!-- Gambar -->
        <div class="flex justify-center md:justify-end px-2 md:px-0">
            <img
                src="{{ asset('assets/aplikasi-keuangan.png') }}"
                alt="Ilustrasi Keuangan"
                class="w-full max-w-xs sm:max-w-sm md:max-w-xl rounded-lg shadow-lg"
                style="max-height: 360px; object-fit: contain;"
            />
        </div>
    </div>
</section>


        <!-- Optional: Animasi gelembung atau shape di background -->
        <div
            class="absolute bottom-0 right-0 w-64 h-64 bg-blue-400 rounded-full opacity-30 blur-3xl animate-pulse"
        ></div>
        <div
            class="absolute top-10 left-10 w-40 h-40 bg-blue-300 rounded-full opacity-20 blur-2xl"
        ></div>
    </div>

    <!-- Screenshot Section -->
    <section class="py-16 bg-gray-50" data-aos="zoom-in">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-semibold mb-6">
                Tampilan Antarmuka Simpel & Menarik
            </h2>
            <img
                src="{{ asset('assets/aplikasi-keuangan.png') }}"
                alt="Tampilan Aplikasi Nimbank"
                class="rounded-xl shadow-lg mx-auto max-w-full h-auto"
            />
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="py-20" data-aos="fade-up">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12">Fitur Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-6 bg-white rounded-lg shadow"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <h3 class="text-xl font-semibold mb-2">
                        Catat Pemasukan & Pengeluaran
                    </h3>
                    <p class="text-gray-600">
                        Kelola setiap transaksi keuangan dengan cepat dan
                        praktis.
                    </p>
                </div>
                <div
                    class="p-6 bg-white rounded-lg shadow"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <h3 class="text-xl font-semibold mb-2">
                        Laporan Keuangan Lengkap
                    </h3>
                    <p class="text-gray-600">
                        Lihat ringkasan mingguan, bulanan, dan tahunan langsung
                        dari dashboard.
                    </p>
                </div>
                <div
                    class="p-6 bg-white rounded-lg shadow"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <h3 class="text-xl font-semibold mb-2">Tampilan Responsive</h3>
                    <p class="text-gray-600">
                        Akses aplikasi dari perangkat apa pun, baik desktop maupun
                        mobile.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-500 text-white py-16" data-aos="zoom-in">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-4">
                Siap Mengelola Keuangan dengan Lebih Baik?
            </h2>
            <p class="mb-6">
                Mulai gunakan Nimbank secara gratis dan rasakan manfaatnya sekarang
                juga.
            </p>
            <a
                href="#"
                class="bg-white text-blue-500 px-6 py-2 rounded-full font-semibold hover:bg-gray-100"
                >Coba Sekarang</a
            >
        </div>
    </section>

    <footer
        class="bg-gray-100 text-center py-6 text-sm text-gray-500"
    >
        &copy; 2025 firhan. All rights reserved.
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
</body>
</html>
