<?php
// Cuplikan Logika Peminjaman [cite: 63]
if(isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_SESSION['id_anggota'];
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days')); // Durasi 7 hari

    // Cek stok buku
    $cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku='$id_buku'");
    $s = mysqli_fetch_assoc($cek_stok);

    if($s['stok'] > 0) {
        // Kurangi stok dan masukkan ke tabel transaksi [cite: 61, 91]
        mysqli_query($conn, "INSERT INTO transaksi VALUES('', '$id_anggota', '$id_buku', '$tgl_pinjam', '$tgl_kembali', 'dipinjam')");
        mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku='$id_buku'");
        echo "<script>alert('Buku Berhasil Dipinjam!'); window.location='dashboard_siswa.php';</script>";
    } else {
        echo "<script>alert('Stok Habis!');</script>";
    }
}
?>