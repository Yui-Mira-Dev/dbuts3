<?php
include_once "../db_connection_file.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $user_id = $_GET["id"];
    $rawPassword = $_POST["password"];

    // Hash the password using bcrypt
    $hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT);

    $query = "UPDATE tbuser SET password = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$hashedPassword, $user_id]);

    header('Location: ../../../index.php?success=password_changed');
    exit;
} else {
    // Handle the case where the ID is not provided
    header('Location: ../../../index.php?error=missing_id');
    exit;
}
?>
