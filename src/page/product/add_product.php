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

    // Check for connection errors
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    // Set character set
    $koneksi->set_charset("utf8");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $nama = $_POST["nama"];
        $kategori = $_POST["kategori"];

         // Replace commas with dots and remove dots for thousands separator
        $harga = str_replace(',', '', $_POST["harga"]);
        $harga = str_replace('.', '', $harga);
        $harga = str_replace(',', '.', $harga);
        
        $stok = $_POST["stok"];
        $deskripsi = $_POST["deskripsi"];
    
        // File upload handling
        $gambar = ""; // Initialize the variable to store the file name

        if ($_FILES["gambar"]["error"] == 0) {
            $target_dir = "foto_product/"; // Specify the target directory
            $original_file_name = basename($_FILES["gambar"]["name"]);
            $file_extension = pathinfo($original_file_name, PATHINFO_EXTENSION);
            
            // Generate a unique file name
            $gambar = uniqid('img_', true) . '.' . $file_extension;
            $target_file = $target_dir . $gambar;

            // Check if file already exists
            while (file_exists($target_file)) {
                // If file already exists, generate a new unique file name
                $gambar = uniqid('img_', true) . '.' . $file_extension;
                $target_file = $target_dir . $gambar;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // File upload successful
            } else {
                echo "Sorry, there was an error uploading your file.";
                // You might want to handle the error appropriately
            }
        }

    
        // Perform the SQL query to insert data into tbProduk
        $sql = "INSERT INTO tbProduk (nama, id_kategori, harga, stok, gambar, deskripsi) VALUES ('$nama', '$kategori', '$harga', '$stok', '$gambar', '$deskripsi')";
    
        // Execute the query
        if ($koneksi->query($sql) === TRUE) {
            echo "Product added successfully";
            header('Location: product.php');
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    
        // Close the database connection
        $koneksi->close();
    }
} else {
    die("Error: .env file not found");
}
?>
