<?php
require_once 'koneksi.php'; 

$pesan = "";
$status = "";

if (isset($_POST['daftar'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');

    $cek_user = mysqli_query($conn, "SELECT * FROM anggota WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $status = "error";
        $pesan  = "Username sudah terdaftar! Silahkan pilih username lain.";
    } else {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO anggota (nama_lengkap, username, password, alamat) 
                  VALUES ('$nama', '$username', '$hash_password', '$alamat')";
        
        if (mysqli_query($conn, $query)) {
            $status = "success";
            $pesan  = "Pendaftaran berhasil! Akun Anda telah aktif.";
        } else {
            $status = "error";
            $pesan  = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota | E-Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-600 to-violet-700 min-h-screen flex items-center justify-center p-4 md:p-6">

    <div class="w-full max-w-4xl flex flex-col md:flex-row shadow-2xl rounded-[1.5rem] md:rounded-[2.5rem] overflow-hidden glass">
        
        <div class="w-full md:w-5/12 bg-slate-900 p-8 md:p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="z-10">
                <div class="bg-indigo-500 w-12 h-12 md:w-14 md:h-14 rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 shadow-lg">
                    <i data-lucide="user-plus" class="text-white w-6 h-6 md:w-8 md:h-8"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold leading-tight mb-3 md:mb-4">Bergabung Bersama Kami</h2>
                <p class="text-slate-400 text-xs md:text-sm leading-relaxed">Akses ribuan koleksi buku digital perpustakaan dalam satu genggaman.</p>
            </div>
            
            <div class="z-10 mt-8 md:mt-12">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 md:w-10 h-1 bg-indigo-500 rounded-full"></div>
                    <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-500">E-LIBRARY SYSTEM</span>
                </div>
                <p class="text-[9px] md:text-[10px] text-slate-600 font-bold uppercase">UKK PAKET 4 • 2026</p>
            </div>
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="flex-1 p-6 md:p-14 bg-white">
            <div class="mb-6 md:mb-10">
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Buat Akun</h1>
                <p class="text-slate-400 text-[10px] md:text-xs mt-1 md:mt-2 font-bold uppercase tracking-widest italic text-rose-500">* Isi data diri dengan lengkap</p>
            </div>

            <?php if ($pesan): ?>
                <div class="mb-6 p-3 md:p-4 rounded-xl md:rounded-2xl flex items-center gap-3 <?= $status == 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                    <i data-lucide="<?= $status == 'success' ? 'check-circle' : 'alert-circle' ?>" class="w-4 h-4 md:w-5 md:h-5"></i>
                    <p class="text-[11px] md:text-xs font-bold"><?= $pesan ?></p>
                </div>
                <?php if ($status == 'success') echo '<meta http-equiv="refresh" content="2;url=login.php">'; ?>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4 md:space-y-6">
                <div>
                    <label class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="text" name="nama" required placeholder="Nama lengkap"
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 bg-slate-50 border border-slate-100 rounded-xl md:rounded-2xl outline-none focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all text-sm text-slate-700 font-semibold">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Username</label>
                    <div class="relative mt-1">
                        <i data-lucide="at-sign" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="text" name="username" required placeholder="username"
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 bg-slate-50 border border-slate-100 rounded-xl md:rounded-2xl outline-none focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all text-sm text-slate-700 font-mono">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative mt-1">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 bg-slate-50 border border-slate-100 rounded-xl md:rounded-2xl outline-none focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all text-sm text-slate-700">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                    <div class="relative mt-1">
                        <i data-lucide="map-pin" class="absolute left-4 top-4 w-4 h-4 text-slate-300"></i>
                        <textarea name="alamat" required placeholder="Alamat rumah..." rows="2"
                            class="w-full pl-11 pr-4 py-3 md:py-3.5 bg-slate-50 border border-slate-100 rounded-xl md:rounded-2xl outline-none focus:ring-4 focus:ring-indigo-100 focus:bg-white focus:border-indigo-500 transition-all text-sm text-slate-700 font-medium"></textarea>
                    </div>
                </div>

                <button type="submit" name="daftar"
                    class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-extrabold py-3.5 md:py-4 rounded-xl md:rounded-2xl shadow-xl transition-all duration-300 transform active:scale-[0.98] flex items-center justify-center gap-2 text-sm md:text-base">
                    <span>DAFTAR SEKARANG</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 md:w-5 md:h-5"></i>
                </button>
            </form>

            <div class="mt-8 md:mt-10 text-center">
                <p class="text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-tighter">Sudah punya akun? 
                    <a href="login.php" class="text-indigo-600 hover:underline ml-1">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>