<?php
session_start();
include 'koneksi.php';
if($_SESSION['role'] != 'siswa') header("location:login.php");

$id_anggota = $_SESSION['id_anggota'];

// Logika Pengembalian Buku
if(isset($_GET['kembali'])) {
    $id_transaksi = $_GET['kembali'];
    $id_buku = $_GET['id_buku'];

    // Update status transaksi dan tambah stok buku kembali
    mysqli_query($conn, "UPDATE transaksi SET status='kembali' WHERE id_transaksi='$id_transaksi'");
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE id_buku='$id_buku'");
    
    echo "<script>alert('Buku berhasil dikembalikan!'); window.location='riwayat_pinjam.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pinjam - E-Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-700">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-emerald-600 p-2 rounded-xl shadow-lg shadow-emerald-200">
                    <i data-lucide="history" class="text-white w-5 h-5"></i>
                </div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Riwayat <span class="text-emerald-600">Pinjam</span></h1>
            </div>
            <a href="dashboard_siswa.php" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-emerald-600 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-emerald-600 rounded-[2rem] p-8 text-white shadow-2xl shadow-emerald-200 relative overflow-hidden" data-aos="fade-right">
                <div class="relative z-10">
                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-widest mb-2">Informasi Penting</p>
                    <h2 class="text-2xl font-bold mb-2">Segera Kembalikan Buku</h2>
                    <p class="text-emerald-50 opacity-80 text-sm leading-relaxed">Pastikan mengembalikan buku tepat waktu untuk menghindari denda dan memberi kesempatan teman lain membaca.</p>
                </div>
                <i data-lucide="info" class="absolute -right-4 -bottom-4 w-32 h-32 opacity-10 rotate-12"></i>
            </div>
            
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm flex items-center justify-between" data-aos="fade-left">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Buku Sedang Dipinjam</p>
                    <?php 
                        $count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE id_anggota='$id_anggota' AND status='dipinjam'");
                        $count = mysqli_fetch_assoc($count_q)['total'];
                    ?>
                    <h2 class="text-4xl font-black text-slate-800"><?= $count ?> <span class="text-sm font-medium text-slate-400 italic">Buku Aktif</span></h2>
                </div>
                <div class="bg-orange-50 p-5 rounded-2xl">
                    <i data-lucide="book-open" class="text-orange-500 w-8 h-8"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden" data-aos="fade-up">
            <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Daftar Pinjaman Aktif</h3>
                    <p class="text-sm text-slate-400">Kelola buku yang sedang kamu bawa saat ini.</p>
                </div>
                <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black uppercase tracking-widest">
                    Status: Dipinjam
                </span>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Detail Buku</th>
                            <th class="px-8 py-5">Tanggal Pinjam</th>
                            <th class="px-8 py-5">Batas Kembali</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $query = mysqli_query($conn, "SELECT t.*, b.judul, b.penulis FROM transaksi t JOIN buku b ON t.id_buku = b.id_buku WHERE t.id_anggota='$id_anggota' AND t.status='dipinjam' ORDER BY t.tanggal_pinjam DESC");
                        
                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                        <i data-lucide="book" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 mb-0.5"><?= $row['judul'] ?></p>
                                        <p class="text-xs text-slate-400 font-medium">ID Transaksi: #TRX-<?= $row['id_transaksi'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-semibold text-slate-600"><?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold uppercase tracking-tight">
                                    <?= date('d M Y', strtotime($row['tanggal_kembali'])) ?>
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <a href="?kembali=<?= $row['id_transaksi'] ?>&id_buku=<?= $row['id_buku'] ?>" 
                                   onclick="return confirm('Apakah kamu yakin ingin mengembalikan buku ini?')"
                                   class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-200 transition-all active:scale-95 group">
                                   <i data-lucide="corner-up-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                                   Kembalikan
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="bg-slate-100 p-4 rounded-full">
                                        <i data-lucide="box" class="w-8 h-8 text-slate-300"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium italic">Wah, kamu tidak memiliki pinjaman aktif.</p>
                                    <a href="list_buku_siswa.php" class="text-emerald-600 font-bold text-sm underline underline-offset-4">Ayo pinjam buku sekarang!</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <p class="text-center mt-10 text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em]">Sistem Perpustakaan Digital © 2026</p>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        lucide.createIcons();
    </script>
</body>
</html>