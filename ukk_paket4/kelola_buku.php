<?php
session_start();
require_once 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}

// 1. Logika Tambah Buku dengan Upload Foto
if (isset($_POST['tambah'])) {
    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $stok     = mysqli_real_escape_string($conn, $_POST['stok']);
    
    // Logika Upload Gambar
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    
    // Rename foto agar unik (mencegah nama file sama tertimpa)
    $fotobaru = date('dmYHis').$foto;
    $path = "img/".$fotobaru;

    // Cek folder img ada atau tidak
    if (!is_dir("img")) {
        mkdir("img");
    }

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO buku (judul, penulis, penerbit, stok, foto) VALUES ('$judul', '$penulis', '$penerbit', '$stok', '$fotobaru')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Buku berhasil ditambahkan!'); window.location='kelola_buku.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mengunggah gambar!');</script>";
    }
}

// 2. Logika Hapus Buku (Sekaligus menghapus file gambar di folder)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Ambil nama file foto sebelum dihapus dari DB
    $data = mysqli_query($conn, "SELECT foto FROM buku WHERE id_buku = '$id'");
    $buku = mysqli_fetch_assoc($data);
    
    if (file_exists("img/".$buku['foto'])) {
        unlink("img/".$buku['foto']); // Hapus file dari folder
    }

    mysqli_query($conn, "DELETE FROM buku WHERE id_buku = '$id'");
    header("location:kelola_buku.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog Buku | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <div class="flex flex-col lg:flex-row">
        
        <aside class="w-full lg:w-1/4 bg-white border-b lg:border-r lg:border-b-0 border-slate-200 p-6 md:p-8 lg:h-screen lg:sticky lg:top-0 z-10" data-aos="fade-right">
            <div class="flex items-center gap-3 mb-8">
                <a href="dashboard_admin.php" class="p-2 bg-slate-100 rounded-lg hover:bg-indigo-600 hover:text-white transition-all duration-300">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-bold tracking-tight text-indigo-900">Input Koleksi</h1>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Cover Buku</label>
                    <div class="relative w-full h-32 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center gap-2 hover:border-indigo-400 transition-colors group cursor-pointer overflow-hidden">
                        <i data-lucide="image-plus" class="text-slate-400 group-hover:text-indigo-500"></i>
                        <span class="text-[10px] font-bold text-slate-400 group-hover:text-indigo-500">Pilih File Foto</span>
                        <input type="file" name="foto" required class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Judul Buku</label>
                    <input type="text" name="judul" required placeholder="Judul buku..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="group">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Penulis</label>
                        <input type="text" name="penulis" required placeholder="Penulis" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Stok</label>
                        <input type="number" name="stok" required min="1" placeholder="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="group">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Penerbit</label>
                    <input type="text" name="penerbit" required placeholder="Penerbit" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <button type="submit" name="tambah" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i> Simpan Buku
                </button>
            </form>
        </aside>

        <main class="flex-1 p-5 md:p-8 lg:p-12 overflow-hidden" data-aos="fade-up">
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Buku</h2>
                    <p class="text-slate-500">Daftar koleksi buku yang tersedia di sistem.</p>
                </div>
            </header>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-400 text-xs uppercase tracking-[0.2em]">
                                <th class="px-8 py-5 font-black">Sampul & Info</th>
                                <th class="px-8 py-5 font-black">Penerbit</th>
                                <th class="px-8 py-5 font-black text-center">Stok</th>
                                <th class="px-8 py-5 font-black text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-all duration-300">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-20 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 shadow-sm flex-shrink-0">
                                            <img src="img/<?= $row['foto'] ?>" alt="Cover" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800"><?= $row['judul'] ?></p>
                                            <p class="text-xs text-slate-400 font-medium italic">Oleh: <?= $row['penulis'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-sm text-slate-500 font-semibold"><?= $row['penerbit'] ?></td>
                                <td class="px-8 py-4 text-center">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-black uppercase">
                                        <?= $row['stok'] ?>
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <a href="?hapus=<?= $row['id_buku'] ?>" 
                                       onclick="return confirm('Hapus buku ini?')"
                                       class="p-3 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all inline-block shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        lucide.createIcons();
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>