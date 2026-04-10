<?php
session_start();

// Hapus semua data session
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | Sampai Jumpa!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Progress Bar */
        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        .progress-fill {
            animation: progress 2s linear forwards;
        }

        /* Fade Out Effect */
        .fade-out {
            animation: fadeOut 0.5s ease-in-out forwards;
            animation-delay: 1.7s;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full text-center fade-out">
        <div class="mb-8 flex justify-center">
            <div class="relative">
                <div class="w-24 h-24 bg-rose-100 rounded-[2rem] flex items-center justify-center text-rose-600 shadow-xl shadow-rose-100 animate-pulse">
                    <i data-lucide="log-out" class="w-10 h-10"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white p-1.5 rounded-xl shadow-lg">
                    <div class="bg-emerald-500 text-white p-1 rounded-lg">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold text-slate-800 mb-3 tracking-tight">Sesi Berakhir</h2>
        <p class="text-slate-500 text-sm mb-10 leading-relaxed px-4">
            Terima kasih telah berkunjung. Akun Anda telah aman dikeluarkan dari sistem perpustakaan.
        </p>

        <div class="max-w-[200px] mx-auto">
            <div class="flex justify-between items-end mb-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mengamankan</span>
                <span class="text-[10px] font-bold text-indigo-600">100%</span>
            </div>
            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                <div class="progress-fill h-full bg-indigo-600 rounded-full"></div>
            </div>
        </div>

        <script>
            setTimeout(function() {
                window.location.href = "login.php?pesan=logout";
            }, 2000);
            
            // Inisialisasi Lucide Icons
            lucide.createIcons();
        </script>
    </div>

</body>
</html>