<?php
session_start();
require_once 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

// Logika Hapus Anggota
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    $cek_transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_anggota = '$id' AND status = 'dipinjam'");
    
    if (mysqli_num_rows($cek_transaksi) > 0) {
        echo "<script>alert('Gagal! Anggota ini masih memiliki buku yang belum dikembalikan.'); window.location='kelola_anggota.php';</script>";
    } else {
        mysqli_query($conn, "DELETE FROM anggota WHERE id_anggota = '$id'");
        echo "<script>alert('Data anggota berhasil dihapus!'); window.location='kelola_anggota.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen text-slate-800">

    <nav class="glass border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="dashboard_admin.php" class="group flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-all font-bold text-sm">
                    <div class="p-2 bg-slate-100 group-hover:bg-indigo-600 group-hover:text-white rounded-xl transition-all">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </div>
                    Kembali
                </a>
                <div class="h-6 w-[1px] bg-slate-200"></div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Database <span class="text-indigo-600">Siswa</span></h1>
            </div>
            
            <div class="hidden md:flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-2xl border border-slate-200">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa..." class="bg-transparent border-none outline-none text-sm w-48 font-medium">
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-10">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 mb-12">
            <div data-aos="fade-right">
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Manajemen Anggota</h2>
                <p class="text-slate-500 mt-2 font-medium italic">Gunakan panel ini untuk memantau dan menghapus data anggota perpustakaan.</p>
            </div>

            <?php 
            $count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM anggota");
            $total_siswa = mysqli_fetch_assoc($count_res)['total'];
            ?>
            <div data-aos="fade-left" class="relative group cursor-default">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                <div class="relative bg-white px-10 py-6 rounded-[2rem] border border-slate-100 flex items-center gap-6">
                    <div class="bg-indigo-600 text-white p-4 rounded-2xl shadow-xl shadow-indigo-100">
                        <i data-lucide="users" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-black tracking-[0.2em] text-slate-400 mb-1">Populasi Anggota</p>
                        <p class="text-4xl font-black text-slate-800 tracking-tight"><?= $total_siswa ?> <span class="text-sm font-bold text-slate-400">Siswa</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left" id="memberTable">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                            <th class="px-10 py-8 font-bold">Biodata Lengkap</th>
                            <th class="px-10 py-8 font-bold">Akses Akun</th>
                            <th class="px-10 py-8 font-bold">Domisili</th>
                            <th class="px-10 py-8 font-bold text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY nama_lengkap ASC");
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr class="group hover:bg-indigo-50/30 transition-all duration-300">
                            <td class="px-10 py-7">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-gradient-to-tr from-indigo-600 to-indigo-400 rounded-[1.25rem] flex items-center justify-center text-white text-xl font-black shadow-lg shadow-indigo-100 transform group-hover:rotate-6 transition-transform">
                                        <?= strtoupper(substr($row['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors"><?= $row['nama_lengkap'] ?></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-md uppercase">Anggota Aktif</span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">#ID-<?= $row['id_anggota'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-7">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                    <span class="text-sm font-bold text-slate-600 italic">@<?= $row['username'] ?></span>
                                </div>
                            </td>
                            <td class="px-10 py-7">
                                <p class="text-sm text-slate-500 max-w-[200px] truncate leading-relaxed">
                                    <i data-lucide="map-pin" class="w-3 h-3 inline mr-1 opacity-50"></i>
                                    <?= $row['alamat'] ?>
                                </p>
                            </td>
                            <td class="px-10 py-7 text-center">
                                <a href="?hapus=<?= $row['id_anggota'] ?>" 
                                   onclick="return confirm('Hapus data siswa ini secara permanen?')"
                                   class="inline-flex items-center gap-2 bg-white text-red-500 border border-red-100 px-6 py-3 rounded-2xl text-xs font-black hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-200 transition-all active:scale-95">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> HAPUS DATA
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="p-32 text-center">
                                <div class="flex flex-col items-center gap-5">
                                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                        <i data-lucide="user-x" class="w-12 h-12"></i>
                                    </div>
                                    <div>
                                        <p class="text-xl font-black text-slate-300">Database Kosong</p>
                                        <p class="text-sm text-slate-400 font-medium">Belum ada siswa yang terdaftar di sistem.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-16 text-center">
            <div class="h-[1px] w-24 bg-slate-200 mx-auto mb-6"></div>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">E-Library Dashboard Control &bull; 2026</p>
        </footer>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Icon & Animasi
        lucide.createIcons();
        AOS.init({ duration: 800, once: true });

        // Fitur Pencarian Real-time
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#memberTable tbody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>