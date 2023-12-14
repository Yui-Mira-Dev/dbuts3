<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "db_connection_file.php";

    $namaOrEmail = $_POST["nama"];
    $password = $_POST["password"];

    // Check if the input is an email or a name
    if (filter_var($namaOrEmail, FILTER_VALIDATE_EMAIL)) {
        // If it's an email, use email in the query
        $query = "SELECT * FROM tbuser WHERE email = ? LIMIT 1";
    } else {
        // If it's not an email, assume it's a name
        $query = "SELECT * FROM tbuser WHERE nama = ? LIMIT 1";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute([$namaOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['user_nama'] = $user['nama']; 
        $_SESSION['user_role'] = $user['user_role']; 
        header('Location: pemisahan_role.php');
        exit;
    } else {
        // Invalid credentials
        header('Location: ../../index.php?error=invalid_credentials');
        exit;
    }
} else {
    header('Location: ../../index.php');
    exit;
}
?>
