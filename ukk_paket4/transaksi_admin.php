<?php
session_start();
require_once 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

// Ambil Statistik Cepat
$total_trx = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));
$total_pinjam = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE status='dipinjam'"));
$total_kembali = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi WHERE status='kembali'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi | Admin E-Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        
        /* Gaya saat Print */
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .print-container { padding: 0 !important; margin: 0 !important; }
            .card-shadow { border: 1px solid #e2e8f0 !important; box-shadow: none !important; }
        }

        .filter-btn.active {
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>
<body class="min-h-screen text-slate-800">

    <nav class="bg-white/70 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 no-print">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200">
                    <i data-lucide="file-text" class="text-white w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black text-slate-800 leading-none tracking-tight">E-REPORT</h1>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">Sirkulasi Perpustakaan</p>
                </div>
            </div>
            <a href="dashboard_admin.php" class="group flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-indigo-600 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> 
                <span>Dashboard</span>
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-10 print-container">
        
        <div class="mb-10 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6">
            <div data-aos="fade-right">
                <span class="px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black tracking-widest uppercase no-print">Laporan Real-time</span>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter mt-3">Log Transaksi Buku</h2>
                <p class="text-slate-500 mt-2 max-w-xl font-medium">Monitor aktivitas peminjaman dan pengembalian koleksi secara mendalam untuk manajemen inventaris yang lebih baik.</p>
            </div>
            
            <div class="flex gap-3 no-print" data-aos="fade-left">
                <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-4 rounded-[1.5rem] font-bold hover:bg-slate-800 transition flex items-center gap-2 shadow-xl shadow-slate-200 active:scale-95">
                    <i data-lucide="printer" class="w-5 h-5"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 no-print">
            <div data-aos="zoom-in" data-aos-delay="100" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="bg-blue-50 text-blue-600 p-4 rounded-2xl"><i data-lucide="layers" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Aktivitas</p>
                    <p class="text-2xl font-black"><?= $total_trx ?></p>
                </div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="200" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="bg-amber-50 text-amber-600 p-4 rounded-2xl"><i data-lucide="clock" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sedang Dipinjam</p>
                    <p class="text-2xl font-black"><?= $total_pinjam ?></p>
                </div>
            </div>
            <div data-aos="zoom-in" data-aos-delay="300" class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl"><i data-lucide="check-circle" class="w-6 h-6"></i></div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sudah Kembali</p>
                    <p class="text-2xl font-black"><?= $total_kembali ?></p>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden card-shadow">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-wrap gap-4 items-center justify-between no-print">
                <div class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl">
                    <button onclick="filterTable('all')" class="filter-btn active px-5 py-2 rounded-xl text-xs font-bold transition-all" id="btn-all">Semua</button>
                    <button onclick="filterTable('dipinjam')" class="filter-btn px-5 py-2 rounded-xl text-xs font-bold transition-all" id="btn-dipinjam">Dipinjam</button>
                    <button onclick="filterTable('kembali')" class="filter-btn px-5 py-2 rounded-xl text-xs font-bold transition-all" id="btn-kembali">Kembali</button>
                </div>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="trxSearch" placeholder="Cari peminjam atau buku..." class="pl-11 pr-6 py-3 bg-slate-50 border-none rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 w-64 font-medium">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="trxTable">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                            <th class="px-8 py-7">Entitas Peminjam</th>
                            <th class="px-8 py-7">Informasi Buku</th>
                            <th class="px-8 py-7">Timeline</th>
                            <th class="px-8 py-7 text-center">Status Aktif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $query = mysqli_query($conn, "SELECT t.*, a.nama_lengkap, b.judul 
                                                      FROM transaksi t 
                                                      JOIN anggota a ON t.id_anggota = a.id_anggota 
                                                      JOIN buku b ON t.id_buku = b.id_buku 
                                                      ORDER BY t.id_transaksi DESC");
                        
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $status = $row['status'];
                        ?>
                        <tr class="hover:bg-slate-50/80 transition-all group" data-status="<?= $status ?>">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-sm">
                                        <?= strtoupper(substr($row['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                    <span class="font-bold text-slate-800 tracking-tight"><?= $row['nama_lengkap'] ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-600 transition-colors"><?= $row['judul'] ?></span>
                                    <span class="text-[10px] text-slate-400 font-black mt-1">CODE: #TRX-<?= $row['id_transaksi'] ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-500">
                                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full"></div>
                                        <span>OUT: <?= date('d M Y', strtotime($row['tanggal_pinjam'])) ?></span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-500">
                                        <div class="w-1.5 h-1.5 bg-rose-400 rounded-full"></div>
                                        <span>IN: <?= date('d M Y', strtotime($row['tanggal_kembali'])) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <?php if ($status == 'dipinjam') : ?>
                                    <span class="bg-amber-50 text-amber-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-100 inline-flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        DIPINJAM
                                    </span>
                                <?php else : ?>
                                    <span class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 inline-flex items-center gap-2">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i>
                                        DIKEMBALIKAN
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='4' class='p-20 text-center text-slate-300 font-bold'>DATA TRANSAKSI TIDAK DITEMUKAN</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.5em]">Laporan Resmi Digital Library &bull; <?= date('Y') ?></p>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        lucide.createIcons();
        AOS.init({ duration: 800, once: true });

        // Fungsi Filter Tabel
        function filterTable(status) {
            const rows = document.querySelectorAll('#trxTable tbody tr');
            const btns = document.querySelectorAll('.filter-btn');
            
            // Ubah tampilan tombol
            btns.forEach(btn => btn.classList.remove('active'));
            document.getElementById('btn-' + status).classList.add('active');

            // Saring baris
            rows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Live Search
        document.getElementById('trxSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#trxTable tbody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>