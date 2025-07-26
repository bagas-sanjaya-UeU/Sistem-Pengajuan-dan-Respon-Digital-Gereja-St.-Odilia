<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengajuan - Gereja St. Odilia</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom gradient untuk hero section */
        .hero-gradient {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.8), rgba(59, 130, 246, 0.8));
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="ph-bold ph-church text-3xl text-blue-600"></i>
                <span class="text-xl font-bold text-gray-800">Gereja St. Odilia</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#hero" class="text-gray-600 hover:text-blue-600 transition-colors">Beranda</a>
                <a href="#alur" class="text-gray-600 hover:text-blue-600 transition-colors">Alur Pengajuan</a>
                <a href="#tentang" class="text-gray-600 hover:text-blue-600 transition-colors">Tentang</a>
                <a href="#kontak" class="text-gray-600 hover:text-blue-600 transition-colors">Kontak</a>
            </div>
            <a href="{{ route('login') }}"
                class="hidden md:block bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105">
                Login
            </a>
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-2xl">
                <i class="ph ph-list"></i>
            </button>
        </nav>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-4 space-y-2">
            <a href="#hero" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Beranda</a>
            <a href="#alur" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Alur Pengajuan</a>
            <a href="#tentang" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Tentang</a>
            <a href="#kontak" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Kontak</a>
            <a href="{{ route('login') }}"
                class="block bg-blue-600 text-white text-center px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105 mt-2">
                Login
            </a>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero"
            class="relative min-h-[80vh] flex items-center justify-center text-white text-center px-6 py-20"
            style="background-image: url('https://parokicitraraya.org/wp-content/uploads/2022/09/gereja-exterior-1-scaled-wpp1684747738463.jpg'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-gray-900/60"></div>
            <div class="relative z-10 max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Sistem Pengajuan dan Respon Digital
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-200 drop-shadow-md">Mempermudah proses administrasi dan
                    komunikasi di lingkungan Gereja St. Odilia, Citra Raya.</p>
                <a href="{{ route('login') }}"
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition-transform transform hover:scale-105 shadow-xl">
                    Mulai Pengajuan
                </a>
            </div>
        </section>

        <!-- Alur Pengajuan Section -->
        <section id="alur" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Alur Pengajuan yang Mudah</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Hanya dengan tiga langkah sederhana,
                        pengajuan Anda akan diproses secara efisien dan transparan.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <!-- Step 1 -->
                    <div
                        class="p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="bg-blue-100 text-blue-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ph-bold ph-sign-in text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">1. Login & Isi Formulir</h3>
                        <p class="text-gray-600">Masuk ke sistem menggunakan akun Anda, lalu isi formulir pengajuan yang
                            tersedia dengan lengkap dan jelas.</p>
                    </div>
                    <!-- Step 2 -->
                    <div
                        class="p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="bg-blue-100 text-blue-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ph-bold ph-clock-countdown text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">2. Tunggu Respon</h3>
                        <p class="text-gray-600">Setelah pengajuan dikirim, admin akan meninjau dan memberikan
                            tanggapan. Anda dapat memantau statusnya di dasbor.</p>
                    </div>
                    <!-- Step 3 -->
                    <div
                        class="p-8 bg-gray-50 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div
                            class="bg-blue-100 text-blue-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ph-bold ph-check-circle text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">3. Selesai & Tindak Lanjut</h3>
                        <p class="text-gray-600">Anda akan menerima hasil akhir (Diterima, Ditolak, atau Revisi) beserta
                            catatan untuk tindak lanjut jika diperlukan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang Sistem Section -->
        <section id="tentang" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2">
                        <img src="https://placehold.co/600x400/3b82f6/ffffff?text=Ilustrasi+Sistem"
                            alt="Ilustrasi Sistem Digital" class="rounded-xl shadow-2xl w-full">
                    </div>
                    <div class="md:w-1/2">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Transformasi Digital untuk
                            Pelayanan yang Lebih Baik</h2>
                        <p class="text-lg text-gray-600 mb-4">Sistem ini dirancang untuk meningkatkan efisiensi dan
                            transparansi dalam proses administrasi gereja. Dengan platform digital, semua pengajuan
                            dapat dilacak dan direspon dengan lebih cepat dan terstruktur.</p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="ph-bold ph-check-circle text-green-500 text-2xl mr-3 mt-1"></i>
                                <span><strong class="text-gray-900">Efisien:</strong> Mengurangi penggunaan kertas dan
                                    mempercepat alur kerja.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ph-bold ph-check-circle text-green-500 text-2xl mr-3 mt-1"></i>
                                <span><strong class="text-gray-900">Transparan:</strong> Semua pihak dapat memantau
                                    status pengajuan secara real-time.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="ph-bold ph-check-circle text-green-500 text-2xl mr-3 mt-1"></i>
                                <span><strong class="text-gray-900">Aksesibel:</strong> Dapat diakses kapan saja dan di
                                    mana saja melalui perangkat Anda.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kontak Section -->
        <section id="kontak" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Hubungi Sekretariat</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Jika Anda memiliki pertanyaan atau
                        membutuhkan bantuan, jangan ragu untuk menghubungi kami.</p>
                </div>
                <div class="max-w-4xl mx-auto bg-gray-50 p-8 rounded-xl shadow-lg">
                    <div class="grid md:grid-cols-3 gap-8 text-center">
                        <div>
                            <i class="ph-bold ph-map-pin text-4xl text-blue-600 mb-3"></i>
                            <h4 class="font-bold text-lg">Alamat</h4>
                            <p class="text-gray-600">Jl. Citra Raya Boulevard, Cikupa, Tangerang, Banten 15710</p>
                        </div>
                        <div>
                            <i class="ph-bold ph-phone text-4xl text-blue-600 mb-3"></i>
                            <h4 class="font-bold text-lg">Telepon</h4>
                            <p class="text-gray-600">(021) 5961571</p>
                        </div>
                        <div>
                            <i class="ph-bold ph-envelope-simple text-4xl text-blue-600 mb-3"></i>
                            <h4 class="font-bold text-lg">Email</h4>
                            <p class="text-gray-600">sekretariat@gerejastodilia.org</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; <span id="year"></span> Gereja St. Odilia, Citra Raya. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <script>
        // Script untuk toggle menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Script untuk menampilkan tahun saat ini di footer
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>
