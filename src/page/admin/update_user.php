<?php
// Database connection
include_once "koneksi.php";

// User data to be updated
$user_id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['nama']) ? $_POST['nama'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$rawPassword = isset($_POST['password']) ? $_POST['password'] : ''; // Retrieve raw password from form data

// Hash password before updating user
$hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT);

// User role to be updated
$user_role = isset($_POST['user_role']) ? $_POST['user_role'] : '';

// Updating the user
$sql = "UPDATE tbuser SET nama='$name', email='$email', password='$hashedPassword', user_role='$user_role' WHERE id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo "User updated successfully";

    // Redirect to admin page
    header("Location: admin.php?updated successfully");
} else {
    echo "Error updating user: " . $conn->error;
}

// Close connection
$conn->close();
?>
