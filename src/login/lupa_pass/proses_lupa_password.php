<?php
include_once "../db_connection_file.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];

    $nama = htmlspecialchars(trim($nama));
    $email = htmlspecialchars(trim($email));

    $query = "SELECT id FROM tbuser WHERE nama = ? AND email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama, $email]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch();
        $id = $result['id'];

        // Mengarahkan ke formulir ubah password dengan menyertakan id
        header("Location: ubah_password.php?id=$id");
        exit;
    } else {
        // Pengguna tidak ditemukan, alihkan dengan pesan kesalahan
        header('Location: ../../../index.php?error=invalid_credentials');
        exit;
    }
}
?>
