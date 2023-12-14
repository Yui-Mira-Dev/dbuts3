<?php
session_start();

$enteredPassword = $_POST['password'];
$correctPassword = '228067'; // Replace with your actual password

if ($enteredPassword === $correctPassword) {
    // Set session variables indicating successful authentication
    $_SESSION['admin_password'] = true;
    $_SESSION['password_timestamp'] = time(); // Set the timestamp

    // You can set additional session variables or perform other actions if needed

    echo json_encode(['success' => true, 'redirect' => '../admin/admin.php']);
} else {
    echo json_encode(['success' => false, 'message' => 'Incorrect password. Please try again.']);
}
?>
