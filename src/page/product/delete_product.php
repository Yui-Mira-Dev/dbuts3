<?php
// delete_product.php

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

    // Assuming you receive the product ID through a GET parameter
    $productId = $_POST['id'];

    $sql = "DELETE FROM tbProduk WHERE id=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        echo "Product deleted successfully!";
        header('Location: product.php');
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $koneksi->close();
} else {
    die('.env file not found');
}
?>
