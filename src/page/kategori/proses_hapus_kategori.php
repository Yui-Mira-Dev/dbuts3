<?php
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        // Check if there are still connections between tbkategori and tbproduk
        $checkProducts = $koneksi->query("SELECT COUNT(*) as count FROM tbproduk WHERE id_kategori = $id");
        $count = $checkProducts->fetch_assoc()['count'];

        if ($count > 0) {
            // Send signal back to kategori.php
            echo json_encode(['status' => 'connected']);
            header('Location: kategori.php?error=gagal');
        } else {
            // Proceed with deletion
            $stmt = $koneksi->prepare("DELETE FROM tbkategori WHERE id = ?");
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
                header('Location: kategori.php');
            } else {
                echo json_encode(['status' => 'failed']);
            }

            // Tutup statement setelah operasi query
            $stmt->close();
        }
    } else {
        echo json_encode(['status' => 'invalid_request']);
    }

    // Close the database connection
    $koneksi->close();
} else {
    echo json_encode(['status' => 'env_not_found']);
}
?>
