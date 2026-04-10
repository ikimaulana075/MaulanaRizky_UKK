<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow-x: hidden;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .bg-animate {
            background: linear-gradient(-45deg, #1e40af, #3b82f6, #6366f1, #4338ca);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Transisi halus untuk input */
        .input-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-animate min-h-screen flex items-center justify-center p-4 md:p-8 relative">

    <div class="glass w-full max-w-[400px] md:max-w-md p-6 sm:p-8 md:p-10 rounded-[2rem] md:rounded-[3rem] shadow-2xl relative z-10" 
         data-aos="zoom-in" data-aos-duration="800">
        
        <div class="text-center mb-8">
            <div class="bg-blue-600 w-16 h-16 md:w-20 md:h-20 rounded-2xl md:rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-xl shadow-blue-200 hover:rotate-6 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-tight">E-Lib Digital</h1>
            <p class="text-gray-500 text-xs md:text-sm mt-1 uppercase tracking-widest font-semibold">Akses Tanpa Batas</p>
        </div>

        <form action="cek_login.php" method="POST" class="space-y-5 md:space-y-6">
            
            <div data-aos="fade-up" data-aos-delay="100">
                <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Masuk Sebagai</label>
                <div class="grid grid-cols-2 gap-2 md:gap-4">
                    <label class="relative flex items-center justify-center p-3 border border-gray-100 rounded-xl md:rounded-2xl cursor-pointer bg-gray-50/50 hover:bg-white transition-all group">
                        <input type="radio" name="level" value="siswa" class="peer hidden" required checked>
                        <span class="text-xs md:text-sm font-bold text-gray-500 peer-checked:text-blue-600">Siswa</span>
                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-600 rounded-xl md:rounded-2xl pointer-events-none transition-all"></div>
                    </label>
                    <label class="relative flex items-center justify-center p-3 border border-gray-100 rounded-xl md:rounded-2xl cursor-pointer bg-gray-50/50 hover:bg-white transition-all group">
                        <input type="radio" name="level" value="admin" class="peer hidden" required>
                        <span class="text-xs md:text-sm font-bold text-gray-500 peer-checked:text-blue-600">Admin</span>
                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-600 rounded-xl md:rounded-2xl pointer-events-none transition-all"></div>
                    </label>
                </div>
            </div>

            <div class="space-y-2" data-aos="fade-up" data-aos-delay="200">
                <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Username</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="text" name="username" required
                        class="input-transition block w-full pl-11 pr-4 py-3.5 md:py-4 bg-white/50 border border-gray-100 rounded-xl md:rounded-2xl text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                        placeholder="Nama pengguna">
                </div>
            </div>

            <div class="space-y-2" data-aos="fade-up" data-aos-delay="300">
                <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Password</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="password" name="password" required
                        class="input-transition block w-full pl-11 pr-4 py-3.5 md:py-4 bg-white/50 border border-gray-100 rounded-xl md:rounded-2xl text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" name="login"
                class="w-full flex justify-center py-3.5 md:py-4 px-4 border border-transparent text-xs md:text-sm font-black rounded-xl md:rounded-2xl text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-100 shadow-xl shadow-blue-200 transform transition-all active:scale-[0.97] duration-200 tracking-widest uppercase">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100/50 text-center" data-aos="fade-up" data-aos-delay="400">
            <p class="text-xs md:text-sm text-gray-500">
                Siswa Baru? <a href="daftar_anggota.php" class="text-blue-600 font-extrabold hover:text-indigo-600 transition-colors underline-offset-4 hover:underline">Daftar Akun</a>
            </p>
        </div>
    </div>

    <p class="fixed bottom-4 text-white/50 text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em]" data-aos="fade-in">
        UKK RPL 2026 • PAKET 4
    </p>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
    </script>
</body>
</html>