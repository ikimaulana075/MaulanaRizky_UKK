
<?php
// Konfigurasi Database
$host     = "localhost";
$username = "root";
$password = "";
$database = "perpustakaan_digital";

// Membuat Koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek Koneksi (Tampilan Error yang Menarik)
if (!$conn) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Koneksi Gagal | E-Lib</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded-2xl shadow-2xl border-t-8 border-red-600 max-w-md text-center">
            <div class="text-red-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Koneksi Database Gagal!</h1>
            <p class="text-gray-600 mb-6">Sistem tidak dapat terhubung ke database. Pastikan MySQL di XAMPP sudah menyala dan nama database sudah benar.</p>
            <div class="bg-red-50 p-3 rounded-lg text-red-700 text-xs font-mono break-words">
                <?php echo mysqli_connect_error(); ?>
            </div>
            <button onclick="window.location.reload()" class="mt-6 bg-red-600 text-white px-6 py-2 rounded-full font-bold hover:bg-red-700 transition">
                Coba Lagi
            </button>
        </div>
    </body>
    </html>
    <?php
    die(); // Menghentikan seluruh proses jika koneksi gagal
}
?>