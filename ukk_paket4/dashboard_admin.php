<?php
session_start();
require_once 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

// Ambil statistik sederhana
$count_buku = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM buku"));
$count_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM anggota"));
$count_pinjam = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE status='dipinjam'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | E-Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
        }
        
        .menu-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .stat-card {
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: scale(1.02);
        }

        /* Loading Screen Animation */
        .loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: white;
            display: flex; justify-content: center; align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
    </style>
</head>
<body class="min-h-screen text-slate-800">

    <nav class="bg-white/70 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/50" data-aos="fade-down">
        <div class="container mx-auto px-4 md:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-600 p-2.5 rounded-2xl shadow-xl shadow-indigo-200 animate-pulse">
                    <i data-lucide="layout-dashboard" class="text-white w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black tracking-tighter text-slate-800 uppercase hidden sm:block">Admin <span class="text-indigo-600">Central</span></h1>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-right hidden md:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Sistem Aktif</p>
                    <p class="text-sm font-bold text-slate-700">Hi, <?= $_SESSION['username'] ?></p>
                </div>
                <a href="logout.php" class="flex items-center gap-2 bg-rose-50 text-rose-600 px-5 py-2.5 rounded-2xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm group">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-8 py-10 md:py-16">
        
        <div class="mb-12 text-center md:text-left" data-aos="fade-right">
            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold tracking-widest uppercase">Dashboard Overview</span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight mt-4">Halo, Admin Utama! 👋</h2>
            <p class="text-slate-500 mt-3 text-lg">Kelola ekosistem perpustakaan digital Anda dalam satu layar.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <div class="stat-card bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-6 group" data-aos="zoom-in" data-aos-delay="100">
                <div class="bg-indigo-50 text-indigo-600 p-5 rounded-[1.5rem] group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                    <i data-lucide="book" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Koleksi</p>
                    <p class="text-3xl font-black text-slate-800"><?= $count_buku ?> <span class="text-sm font-medium text-slate-400">Judul</span></p>
                </div>
            </div>

            <div class="stat-card bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-6 group" data-aos="zoom-in" data-aos-delay="200">
                <div class="bg-emerald-50 text-emerald-600 p-5 rounded-[1.5rem] group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-inner">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Anggota</p>
                    <p class="text-3xl font-black text-slate-800"><?= $count_siswa ?> <span class="text-sm font-medium text-slate-400">Siswa</span></p>
                </div>
            </div>

            <div class="stat-card bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-6 group sm:col-span-2 lg:col-span-1" data-aos="zoom-in" data-aos-delay="300">
                <div class="bg-amber-50 text-amber-600 p-5 rounded-[1.5rem] group-hover:bg-amber-600 group-hover:text-white transition-all duration-500 shadow-inner">
                    <i data-lucide="repeat" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Pinjaman Aktif</p>
                    <p class="text-3xl font-black text-slate-800"><?= $count_pinjam ?> <span class="text-sm font-medium text-slate-400">Item</span></p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-8" data-aos="fade-up">
            <h3 class="text-xl font-black text-slate-800 tracking-tight uppercase">Kontrol Panel</h3>
            <div class="h-[2px] flex-1 bg-slate-100 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <a href="kelola_buku.php" class="menu-card bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-400 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 group-hover:rotate-6 shadow-sm">
                    <i data-lucide="library" class="w-10 h-10"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Katalog Buku</h4>
                <p class="text-sm text-slate-400 mt-3 leading-relaxed">Kelola inventaris, klasifikasi, dan ketersediaan stok buku.</p>
                <div class="mt-6 p-2 bg-indigo-50 rounded-full text-indigo-600 opacity-0 group-hover:opacity-100 transition-all">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </div>
            </a>

            <a href="kelola_anggota.php" class="menu-card bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-400 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 group-hover:-rotate-6 shadow-sm">
                    <i data-lucide="user-cog" class="w-10 h-10"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Data Anggota</h4>
                <p class="text-sm text-slate-400 mt-3 leading-relaxed">Atur hak akses, verifikasi pendaftaran, dan data siswa.</p>
                <div class="mt-6 p-2 bg-emerald-50 rounded-full text-emerald-600 opacity-0 group-hover:opacity-100 transition-all">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </div>
            </a>

            <a href="transaksi_admin.php" class="menu-card bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-400 mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all duration-500 group-hover:scale-110 shadow-sm">
                    <i data-lucide="clipboard-list" class="w-10 h-10"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Laporan Sirkulasi</h4>
                <p class="text-sm text-slate-400 mt-3 leading-relaxed">Pantau arus peminjaman, denda, dan riwayat transaksi.</p>
                <div class="mt-6 p-2 bg-amber-50 rounded-full text-amber-600 opacity-0 group-hover:opacity-100 transition-all">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </div>
            </a>
        </div>
    </main>

    <footer class="container mx-auto px-8 py-12 text-center">
        <div class="flex flex-col items-center gap-4">
            <div class="h-[1px] w-24 bg-slate-200"></div>
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.5em]">E-Library Dashboard System &bull; Version 4.0</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();
        
        // Inisialisasi AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>
</body>
</html>