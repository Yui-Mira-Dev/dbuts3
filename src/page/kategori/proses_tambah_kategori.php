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

    // Bagian ini untuk membaca data kategori
    $sql = "SELECT * FROM tbkategori";
    $result = $koneksi->query($sql);
} else {
    die('.env file not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];

    // Gunakan parameterized query untuk mencegah SQL injection
    $stmt = $koneksi->prepare("INSERT INTO tbkategori (nama) VALUES (?)");
    $stmt->bind_param('s', $nama);

    // Eksekusi query
    if ($stmt->execute()) {
        header('Location: kategori.php');
    } else {
        echo "Gagal menambahkan kategori.";
    }

    // Tutup statement dan koneksi setelah operasi query
    $stmt->close();
    $koneksi->close();
}
?>