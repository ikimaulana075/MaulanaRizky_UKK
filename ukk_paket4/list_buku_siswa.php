<?php
session_start();
require_once 'koneksi.php';

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("location:login.php");
    exit;
}

$id_anggota = $_SESSION['id_anggota'];

// LOGIKA PEMINJAMAN
if (isset($_GET['pinjam'])) {
    $id_buku = $_GET['pinjam'];
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days')); 

    $cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    $data_buku = mysqli_fetch_assoc($cek_stok);

    if ($data_buku['stok'] > 0) {
        $query_pinjam = "INSERT INTO transaksi (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) 
                         VALUES ('$id_anggota', '$id_buku', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')";
        
        if (mysqli_query($conn, $query_pinjam)) {
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");
            echo "<script>alert('Buku berhasil dipinjam! Segera ambil di perpustakaan.'); window.location='riwayat_pinjam.php';</script>";
        }
    } else {
        echo "<script>alert('Maaf, stok buku ini sedang habis.'); window.location='list_buku_siswa.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku | E-Lib Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .book-card:hover .book-image { transform: scale(1.1); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="dashboard_siswa.php" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-bold text-slate-800">Katalog Buku</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-800 leading-none"><?= $_SESSION['nama'] ?></p>
                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest mt-1 italic">Siswa</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">
                    <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-10">
        
        <div class="mb-12 text-center max-w-2xl mx-auto">
            <h2 class="text-4xl font-black text-slate-900 mb-4 tracking-tighter">Mau baca apa hari ini?</h2>
            <form action="" method="GET" class="relative group">
                <input type="text" name="cari" value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>" placeholder="Cari judul buku atau penulis..." 
                    class="w-full px-6 py-5 bg-white border border-slate-200 rounded-[2rem] shadow-xl shadow-slate-200/50 outline-none focus:ring-4 focus:ring-blue-100 transition-all pl-14">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors"></i>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php
            $cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
            // Pastikan kolom 'foto' ada di database Anda
            $query_buku = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%$cari%' OR penulis LIKE '%$cari%' ORDER BY id_buku DESC");

            if (mysqli_num_rows($query_buku) > 0) {
                while ($buku = mysqli_fetch_assoc($query_buku)) {
                    $stok = $buku['stok'];
                    // Logika pengecekan foto: jika kolom foto kosong, gunakan placeholder gambar
                    $gambar_buku = (!empty($buku['foto'])) ? 'img/' . $buku['foto'] : null;
            ?>
            <div class="book-card bg-white rounded-[2.5rem] p-5 shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group flex flex-col">
                
                <div class="w-full h-64 bg-slate-100 rounded-[2rem] mb-6 flex items-center justify-center relative overflow-hidden shadow-inner">
                    <?php if ($gambar_buku && file_exists($gambar_buku)) : ?>
                        <img src="<?= $gambar_buku ?>" alt="<?= $buku['judul'] ?>" class="book-image w-full h-full object-cover transition-transform duration-700">
                    <?php else : ?>
                        <div class="flex flex-col items-center text-slate-300">
                            <i data-lucide="book-open" class="w-16 h-16 mb-2"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">No Cover</span>
                        </div>
                    <?php endif; ?>

                    <?php if ($stok <= 0) : ?>
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] flex items-center justify-center">
                            <span class="bg-white text-slate-900 px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-xl">Out of Stock</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="px-2 flex-grow">
                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 block"><?= $buku['penerbit'] ?></span>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1 group-hover:text-blue-600 transition-colors line-clamp-2"><?= $buku['judul'] ?></h3>
                    <p class="text-xs text-slate-400 mb-4 font-medium italic">Penulis: <?= $buku['penulis'] ?></p>
                </div>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-50 px-2">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-300 uppercase">Tersedia</span>
                        <span class="text-sm font-black <?= ($stok > 0) ? 'text-slate-700' : 'text-rose-500' ?>"><?= $stok ?> Eks</span>
                    </div>

                    <?php if ($stok > 0) : ?>
                        <a href="?pinjam=<?= $buku['id_buku'] ?>" 
                            onclick="return confirm('Pinjam buku \'<?= $buku['judul'] ?>\' sekarang?')"
                            class="bg-blue-600 text-white flex items-center gap-2 px-5 py-3 rounded-2xl hover:bg-slate-900 shadow-lg shadow-blue-200 hover:shadow-slate-200 transition-all duration-300 active:scale-95 group/btn">
                            <span class="text-xs font-bold uppercase tracking-wider">Pinjam</span>
                            <i data-lucide="plus" class="w-4 h-4 group-hover/btn:rotate-90 transition-transform"></i>
                        </a>
                    <?php else : ?>
                        <div class="bg-slate-100 text-slate-300 px-5 py-3 rounded-2xl cursor-not-allowed flex items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wider">Kosong</span>
                            <i data-lucide="slash" class="w-4 h-4"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                } 
            } else {
            ?>
                <div class="col-span-full py-20 text-center">
                    <div class="bg-slate-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="frown" class="w-12 h-12 text-slate-300"></i>
                    </div>
                    <p class="text-xl font-bold text-slate-800">Buku tidak ditemukan</p>
                    <p class="text-slate-400 mt-2 font-medium">Coba gunakan kata kunci lain.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>