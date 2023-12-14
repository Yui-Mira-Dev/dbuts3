<?php
include_once "db_connection_file.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars(trim($_POST["nama"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $rawPassword = $_POST["password"];

    // Hash the password using bcrypt
    $hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT);

    $query = "INSERT INTO tbuser (nama, email, password) VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$nama, $email, $hashedPassword]);

    header('Location: ../page/admin/admin.php');
    exit;
}
?>
