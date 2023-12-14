<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    $envFile = __DIR__ . '/../../../.env';

    if (file_exists($envFile)) {
        $envContent = file_get_contents($envFile);

        $envLines = explode("\n", $envContent);

        $envVariables = [];
        foreach ($envLines as $line) {
            if (empty($line)) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $envVariables[$key] = trim($value);
        }

        $host = $envVariables['DB_HOST'];
        $user = $envVariables['DB_USER'];
        $pass = $envVariables['DB_PASSWORD'];
        $db = $envVariables['DB_DATABASE'];

        $koneksi = new mysqli($host, $user, $pass, $db);

        if ($koneksi->connect_error) {
            die('Koneksi database gagal: ' . $koneksi->connect_error);
        }

        // Prepare and execute SQL statement to delete the user
        $sql = "DELETE FROM tbUser WHERE id = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            // Redirect back to the user list
            header('Location: admin.php');
            exit;
        } else {
            // Redirect with an error message if deletion failed
            $_SESSION['error'] = 'Failed to delete user.';
            header('Location: admin.php');
            exit;
        }

        $stmt->close();
        $koneksi->close();
    } else {
        die('.env file not found');
    }
} else {
    // Redirect with an error message if user ID is not provided or invalid
    $_SESSION['error'] = 'Invalid user ID.';
    header('Location: admin.php');
    exit;
}
?>
