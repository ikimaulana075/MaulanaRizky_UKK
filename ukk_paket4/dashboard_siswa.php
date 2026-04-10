<?php
session_start();
require_once 'koneksi.php';

// Proteksi Halaman
if (!isset($_SESSION['status']) || $_SESSION['role'] != "siswa") {
    header("location:login.php?pesan=belum_login");
    exit;
}

$nama_siswa = $_SESSION['nama'] ?? 'Siswa';
$id_anggota = $_SESSION['id_anggota'];

$query_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE id_anggota = '$id_anggota' AND status = 'dipinjam'");
$total_pinjam = mysqli_fetch_assoc($query_pinjam)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | E-Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Animasi Background Gradient */
        .bg-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.05) 0px, transparent 50%);
        }

        /* Hover Effect khusus untuk Card */
        .hover-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-card:hover {
            transform: translateY(-12px) scale(1.02);
        }
    </style>
</head>
<body class="bg-mesh min-h-screen">

    <nav class="bg-white/70 backdrop-blur-lg sticky top-0 z-50 border-b border-slate-200/60" data-aos="fade-down">
        <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 p-2 rounded-xl shadow-lg shadow-blue-200">
                    <i data-lucide="book-open" class="text-white w-5 h-5 md:w-6 md:h-6"></i>
                </div>
                <span class="text-lg md:text-xl font-black text-slate-800 tracking-tighter uppercase">E-Lib <span class="text-blue-600">Siswa</span></span>
            </div>
            
            <div class="flex items-center gap-3 md:gap-6">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Status: Siswa</p>
                    <p class="text-sm font-bold text-slate-800"><?= $nama_siswa ?></p>
                </div>
                <a href="logout.php" class="flex items-center gap-2 bg-rose-50 text-rose-600 px-4 py-2.5 rounded-xl font-bold hover:bg-rose-600 hover:text-white transition-all duration-300 group">
                    <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    <span class="text-xs md:text-sm">Keluar</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-6 py-8 md:py-12">
        
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-[2rem] md:rounded-[3rem] p-8 md:p-16 text-white shadow-2xl shadow-blue-200 relative overflow-hidden mb-12" 
             data-aos="zoom-in-up" data-aos-duration="1000">
            
            <div class="relative z-10">
                <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase mb-6">
                    ✨ Selamat Datang Kembali
                </span>
                <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight">
                    Mau baca apa hari ini, <br class="md:hidden"> 
                    <span class="text-blue-200 italic"><?= explode(' ', $nama_siswa)[0] ?>?</span>
                </h1>
                <p class="text-blue-100 max-w-lg opacity-80 mb-10 font-medium text-sm md:text-lg leading-relaxed">
                    Jelajahi ribuan koleksi buku digital. Pinjam secepat kilat, baca sepuas hati tanpa batas ruang dan waktu.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white/10 border border-white/20 backdrop-blur-xl px-6 py-4 rounded-2xl flex items-center gap-4 group hover:bg-white/20 transition-all">
                        <div class="p-3 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                            <i data-lucide="book-marked" class="text-white"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-blue-200 uppercase font-black tracking-widest leading-none mb-1">Buku Aktif</p>
                            <p class="text-2xl font-black tracking-tight"><?= $total_pinjam ?> <span class="text-sm font-normal opacity-60 uppercase">Buku</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-400/20 rounded-full blur-[100px]"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-indigo-400/10 rounded-full blur-[80px]"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            <a href="list_buku_siswa.php" class="hover-card group relative bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-blue-200/50" 
               data-aos="fade-up" data-aos-delay="100">
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 transition-all duration-500 shadow-inner">
                    <i data-lucide="search" class="text-blue-600 group-hover:text-white w-8 h-8 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-3 tracking-tight">Cari Koleksi</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-8 font-medium">Temukan referensi belajar, jurnal terbaru, hingga novel *best-seller* di sini.</p>
                <div class="flex items-center text-blue-600 font-black text-xs gap-2 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                    Buka Katalog <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </a>

            <a href="riwayat_pinjam.php" class="hover-card group relative bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-indigo-200/50"
               data-aos="fade-up" data-aos-delay="200">
                <div class="bg-indigo-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 transition-all duration-500 shadow-inner">
                    <i data-lucide="clock" class="text-indigo-600 group-hover:text-white w-8 h-8 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-800 mb-3 tracking-tight">Riwayat Pinjam</h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-8 font-medium">Pantau jatuh tempo pengembalian dan cek riwayat buku yang sudah dibaca.</p>
                <div class="flex items-center text-indigo-600 font-black text-xs gap-2 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                    Lihat List <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </a>

            <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="300">
                <div>
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pusat Informasi</span>
                    </div>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Jam Operasional</p>
                                <p class="text-sm font-bold text-slate-700">Senin - Jumat (07:00 - 15:00)</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Lokasi Fisik</p>
                                <p class="text-sm font-bold text-slate-700">Lantai 2, Gedung Perpustakaan</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mt-10 pt-6 border-t border-slate-50 text-center sm:text-left">
                    <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">E-Library System v2.0</p>
                </div>
            </div>

        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi Transisi
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-back'
        });
        
        lucide.createIcons();
    </script>
</body>
</html>