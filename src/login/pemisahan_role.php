<?php
session_start();

// Cek apakah sesi user_role telah di-set
if (isset($_SESSION['user_role'])) {
    // Redirect ke halaman sesuai berdasarkan user_role
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: ../page/product/dashboard.php');
        exit();
    } elseif ($_SESSION['user_role'] === 'penjual') {
        header('Location: ../page/product/product.php');
        exit();
    } elseif ($_SESSION['user_role'] === 'pembeli') {
        header('Location: ../page/home.php');
        exit();
    } else {
        // Jika user_role tidak dikenali, tambahkan logika tambahan atau arahkan ke halaman default.
        header('Location: ../../index.php');
        exit();
    }
} else {
    // Jika sesi user_role tidak di-set, arahkan pengguna ke halaman login atau halaman default.
    header('Location: ../../index.php?');
    exit();
}
?>
