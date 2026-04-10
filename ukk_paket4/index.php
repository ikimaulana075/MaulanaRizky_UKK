<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-700 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold italic">E-LIBRARY</h1>
            <div>
                <a href="login.php" class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">Masuk Ke Sistem</a>
            </div>
        </div>
    </nav>

    <header class="py-20 text-center bg-blue-600 text-white">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang di Perpustakaan Digital</h2>
        [cite_start]<p class="text-lg opacity-90">Solusi digitalisasi peminjaman buku untuk warga sekolah.</p>
    </header>

    <main class="container mx-auto my-12 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6 bg-white rounded-xl shadow">
                <div class="text-4xl mb-4">📚</div>
                <h3 class="font-bold text-xl mb-2">Katalog Lengkap</h3>
                <p class="text-gray-600">Akses ribuan judul buku dari berbagai kategori dengan mudah.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="font-bold text-xl mb-2">Peminjaman Cepat</h3>
                [cite_start]<p class="text-gray-600">Proses peminjaman dan pengembalian dilakukan secara digital.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow">
                <div class="text-4xl mb-4">🏠</div>
                <h3 class="font-bold text-xl mb-2">Akses Lokal</h3>
                [cite_start]<p class="text-gray-600">Dapat diakses melalui jaringan lokal sekolah (Localhost).</p>
            </div>
        </div>
    </main>
</body>
</html>