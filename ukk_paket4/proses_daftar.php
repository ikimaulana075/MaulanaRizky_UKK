<?php
require_once 'koneksi.php';

// Inisialisasi variabel untuk tampilan
$status = "";
$pesan = "";

// 1. Cek apakah tombol daftar diklik
if (isset($_POST['daftar'])) {
    
    // 2. Ambil data dari form dan definisikan variabel di awal
    // Gunakan mysqli_real_escape_string untuk mencegah SQL Injection
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nis      = mysqli_real_escape_string($conn, $_POST['nis'] ?? '');
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');

    // 3. Validasi: Pastikan username belum digunakan
    $cek_user = mysqli_query($conn, "SELECT * FROM anggota WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $status = "error";
        $pesan  = "Username '$username' sudah terdaftar! Gunakan nama lain.";
    } else {
        // 4. Enkripsi password demi keamanan
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // 5. Masukkan data ke tabel anggota
        // Pastikan kolom 'nis' sudah ada di database Anda
        $query = "INSERT INTO anggota (nama_lengkap, username, password, nis, alamat) 
                  VALUES ('$nama', '$username', '$password_hashed', '$nis', '$alamat')";
        
        if (mysqli_query($conn, $query)) {
            $status = "success";
            $pesan  = "Akun atas nama $nama berhasil dibuat!";
        } else {
            $status = "error";
            $pesan  = "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran | E-Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .loader-bar {
            animation: loading 2s ease-in-out forwards;
        }
        @keyframes loading {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-sm w-full bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-indigo-100 text-center border border-slate-100">
        
        <?php if ($status == "success"): ?>
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shadow-lg shadow-emerald-100">
                    <i data-lucide="check-circle" class="w-10 h-10"></i>
                </div>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Berhasil!</h2>
            <p class="text-slate-500 text-sm mb-8"><?= $pesan ?></p>
            
            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mb-4">
                <div class="loader-bar bg-emerald-500 h-full"></div>
            </div>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Mengalihkan ke Login...</p>
            <meta http-equiv="refresh" content="2;url=login.php">

        <?php elseif ($status == "error"): ?>
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center shadow-lg shadow-rose-100">
                    <i data-lucide="alert-circle" class="w-10 h-10"></i>
                </div>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Pendaftaran Gagal</h2>
            <p class="text-slate-500 text-sm mb-8"><?= $pesan ?></p>
            <a href="javascript:history.back()" class="inline-block w-full py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-100">
                Kembali & Perbaiki
            </a>

        <?php else: ?>
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 border-4 border-slate-200 border-t-indigo-600 rounded-full animate-spin mb-6"></div>
                <h2 class="text-xl font-bold text-slate-800">Menunggu Data...</h2>
                <p class="text-slate-400 text-xs mt-2 uppercase tracking-widest font-black">Akses Tidak Sah</p>
            </div>
            <meta http-equiv="refresh" content="2;url=registrasi.php">
        <?php endif; ?>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>