<?php
// Memulai session untuk menyimpan status login
session_start();

// Menghubungkan ke database
include 'koneksi.php';

// Mengecek apakah tombol login sudah diklik
if (isset($_POST['login'])) {
    
    // Mengambil data dari form login dan menghindari SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $level    = $_POST['level'];

    if ($level == "admin") {
        // Query untuk mengecek data di tabel admin
        $queryAdmin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
        $cekAdmin   = mysqli_num_rows($queryAdmin);

        if ($cekAdmin > 0) {
            $dataAdmin = mysqli_fetch_assoc($queryAdmin);
            
            // Set session untuk admin
            $_SESSION['username'] = $username;
            $_SESSION['nama']     = "Administrator";
            $_SESSION['role']     = "admin";
            $_SESSION['status']   = "login";

            // Alihkan ke halaman dashboard admin
            header("location:dashboard_admin.php");
        } else {
            // Jika login gagal
            echo "<script>
                    alert('Login Admin Gagal! Username atau Password salah.');
                    window.location='login.php';
                  </script>";
        }

    } else if ($level == "siswa") {
        // Query untuk mengecek data di tabel anggota (siswa)
        $querySiswa = mysqli_query($conn, "SELECT * FROM anggota WHERE username='$username' AND password='$password'");
        $cekSiswa   = mysqli_num_rows($querySiswa);

        if ($cekSiswa > 0) {
            $dataSiswa = mysqli_fetch_assoc($querySiswa);
            
            // Set session untuk siswa (menggunakan id_anggota untuk relasi transaksi)
            $_SESSION['id_anggota'] = $dataSiswa['id_anggota'];
            $_SESSION['username']   = $username;
            $_SESSION['nama']       = $dataSiswa['nama_lengkap'];
            $_SESSION['role']       = "siswa";
            $_SESSION['status']     = "login";

            // Alihkan ke halaman dashboard siswa
            header("location:dashboard_siswa.php");
        } else {
            // Jika login gagal (Sesuai Flowmap: Jika Anggota = False, arahkan kembali)
            echo "<script>
                    alert('Login Siswa Gagal! Pastikan Akun sudah Terdaftar.');
                    window.location='login.php';
                  </script>";
        }
    } else {
        // Jika level tidak dipilih
        header("location:login.php?pesan=gagal");
    }

} else {
    // Jika mencoba akses langsung file ini tanpa lewat form login
    header("location:login.php");
}
?>