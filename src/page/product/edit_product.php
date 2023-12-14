<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}
// edit_product.php

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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Assuming you receive the product ID through a GET parameter
        $productId = $_GET['id'];

        // Fetch the product details based on the ID
        $sql = "SELECT * FROM tbProduk WHERE id = $productId";
        $result = $koneksi->query($sql);
        $product = $result->fetch_assoc();

        // Fetching categories for the dropdown
        $categoryDropdownQuery = "SELECT * FROM tbkategori";
        $categoryDropdownResult = $koneksi->query($categoryDropdownQuery);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming you have form fields for other product details, update them here
        $productId = $_POST['product_id'];
        $kategori = $_POST['kategori'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $deskripsi = $_POST['deskripsi'];

        // Update the product in the database
        $sql = "UPDATE tbProduk SET id_kategori=$kategori, nama='$nama', harga=$harga, stok=$stok, deskripsi='$deskripsi' WHERE id=$productId";
        $result = $koneksi->query($sql);

        if ($result) {
            echo "Product details updated successfully!";
            header('Location: product.php');
        } else {
            echo "Error updating product details: " . $koneksi->error;
        }

        // Handle image update
        if ($_FILES['gambar']['error'] == 0) {
            // Check if the file is an image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['gambar']['type'];
            
            if (in_array($fileType, $allowedTypes)) {
                // Remove the old image file
                $oldImagePath = "foto_product/" . $product['gambar'];

                if (file_exists($oldImagePath)) {
                    $deletedImagePath = "foto_terhapus/" . basename($product['gambar']);
                    rename($oldImagePath, $deletedImagePath);
                }
        
                // Upload the new image
                $newImageName = $_FILES['gambar']['name'];
                $newImagePath = "foto_product/" . $newImageName;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $newImagePath);
        
                // Update the image name in the database
                $sqlUpdateImage = "UPDATE tbProduk SET gambar='$newImageName' WHERE id=$productId";
                $resultUpdateImage = $koneksi->query($sqlUpdateImage);
        
                if ($resultUpdateImage) {
                    echo "Product image updated successfully!";
                } else {
                    echo "Error updating product image: " . $koneksi->error;
                }
            } else {
                echo "Invalid file type. Please upload a valid image file.";
            }
        }
    }

    // Close the connection
    $koneksi->close();
} else {
    die('.env file not found');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
<header class=" bg-primary">
        <nav class="navbar container navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a href="../home.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="175" height="60" role="img" aria-label="Bootstrap">
                        <image href="../../ico/logo/png/logo-no-background.png" width="100%" height="100%" />
                    </svg>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 ">
                        <li><a href="../admin/admin.php" class="nav-link px-2 link-body-emphasis text-light" data-bs-toggle="modal" data-bs-target="#passwordModal">Data User</a></li>
                        <li><a href="../home.php" class="nav-link px-2 link-body-emphasis text-light">Store</a></li>
                        <li><a href="../kategori/kategori.php" class="nav-link px-2 link-body-emphasis text-light">Category</a></li>
                        <li><a href="product.php" class="nav-link px-2 link-body-emphasis text-light">Products</a></li>
                    </ul>

                    <form method='get' action='../home.php' class='col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
                        <input class="form-control me-2" type="search" name="search" placeholder="Cari Kategori/Produk di sini" aria-label="Search" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    </form>

                    <div class="dropdown text-center ">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../ico/img/IMG-20191208-WA0004.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
                            <?php echo isset($_SESSION['user_nama']) ? $_SESSION['user_nama'] : ''; ?>
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="dashboard.php">Admin</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../../login/logout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-2">
            <h2>Edit Product</h2>
            <!-- Form for editing product details -->
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori:</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <?php
                        while ($categoryRow = $categoryDropdownResult->fetch_assoc()) {
                            $categoryId = $categoryRow['id'];
                            $categoryName = $categoryRow['nama'];
                            echo "<option value='$categoryId' " . ($kategori == $categoryId ? 'selected' : '') . ">$categoryName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $product['nama']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="addon-wrapping">Rp.</span>
                        <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $product['harga']; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok:</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $product['stok']; ?>" required>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <label for="gambar" class="form-label mt-1">Product Image:</label>
                    <img class="mt-2" src="foto_product/<?php echo $product['gambar']; ?>" alt="Product Image" style="width: 150px; height: 150px;">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required><?php echo $product['deskripsi']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-4">Update</button>
                <a href="product.php" class="btn btn-primary mb-4">Back</a>
            </form>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Enter Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please enter the password to access the Manage Users section.</p>
                        <input type="password" class="form-control" id="passwordInput" placeholder="Password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="checkPassword()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function checkPassword() {
            var enteredPassword = document.getElementById('passwordInput').value;

            // Send password to server for validation
            fetch('check_password.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'password=' + encodeURIComponent(enteredPassword),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect; // Redirect to Manage Users page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
