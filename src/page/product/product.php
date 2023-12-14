<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}

$user_role = $_SESSION['user_role'];

if ($user_role == 'admin' || $user_role == 'penjual') {
    // Jika sudah diarahkan ke product.php, biarkan pengguna di sana
    if (basename($_SERVER['PHP_SELF']) !== 'product.php') {
        header('Location: product.php');
        exit;
    }
} elseif ($user_role == 'pembeli') {
    // Jika sudah diarahkan ke home.php, biarkan pengguna di sana
    if (basename($_SERVER['PHP_SELF']) !== 'home.php') {
        header('Location: ../home.php');
        exit;
    }
} else {
    // Jika sudah diarahkan ke index.php, biarkan pengguna di sana
    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        header('Location: ../../../index.php');
        exit;
    }
}

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

    $sql = "SELECT * FROM tbProduk";
    $result = $koneksi->query($sql);
    $kategori = $koneksi->query("SELECT * FROM tbkategori");

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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
    <header class=" bg-primary ">
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
                        <li><a href="#" class="nav-link px-2 link-body-emphasis text-light">Products</a></li>
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah Produk</button>
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
    
                    // Number of products per page
                    $productsPerPage = 5;
    
                    // Check if a page number is set in the URL, default to page 1 if not set
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
                    // Calculate the offset for the SQL query
                    $offset = ($page - 1) * $productsPerPage;
    
                    // Search filter
                    $search = isset($_GET['search']) ? $koneksi->real_escape_string($_GET['search']) : '';
    
                    // Category filter
                    $categoryFilter = isset($_GET['category']) ? $koneksi->real_escape_string($_GET['category']) : '';
    
                    // Modify your SQL query to include search and category filters
                    $sql = "SELECT * FROM tbProduk WHERE (nama LIKE '%$search%' OR deskripsi LIKE '%$search%')";
                    if (!empty($categoryFilter)) {
                        $sql .= " AND id_kategori = $categoryFilter";
                    }
                    $sql .= " LIMIT $productsPerPage OFFSET $offset";
    
                    $result = $koneksi->query($sql);
    
                                    // Output search form
                    echo "<form method='get' action='' class='row g-3'>
                    <div class='col-md-6'>
                        <label for='search' class='form-label'>Search:</label>
                        <input type='text' class='form-control' id='search' name='search' value='$search'>
                    </div>
                    <div class='col-md-4'>
                        <label for='category' class='form-label'>Category:</label>
                        <select class='form-select' id='category' name='category'>
                            <option value='' " . ($categoryFilter == '' ? 'selected' : '') . ">All Categories</option>";
    
                    // Fetching categories for the dropdown
                    $categoryDropdownQuery = "SELECT * FROM tbkategori";
                    $categoryDropdownResult = $koneksi->query($categoryDropdownQuery);
                    while ($categoryRow = $categoryDropdownResult->fetch_assoc()) {
                    $categoryId = $categoryRow['id'];
                    $categoryName = $categoryRow['nama'];
                    echo "<option value='$categoryId' " . ($categoryFilter == $categoryId ? 'selected' : '') . ">$categoryName</option>";
                    }
    
                    echo "</select>
                    </div>
                    <div class='col-1'>
                        <label for='search' class='form-label'>Cari:</label>
                        <button type='submit' class='btn btn-primary'>Search</button>
                    </div>
                    </form>";
    
                    echo "<div class='overflow-auto'>";
                    // Output HTML table header
                    echo "<table class='table overflow-auto table-overflow'>
                            <thead>
                                <tr>
                                    <th class='text-center'>Kategori</th>
                                    <th class='text-center'>Nama Product</th>
                                    <th class='text-center'>Harga</th>
                                    <th class='text-center'>Stok</th>
                                    <th class='text-center'>Product</th>
                                    <th class='text-center'>Deskripsi</th>
                                    <th class='text-center'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>";
    
                    while ($row = $result->fetch_assoc()) {
                        // Fetching category name based on category ID
                        $categoryId = $row['id_kategori'];
                        $categoryQuery = "SELECT nama FROM tbkategori WHERE id = $categoryId";
                        $categoryResult = $koneksi->query($categoryQuery);
    
                        if ($categoryResult && $categoryRow = $categoryResult->fetch_assoc()) {
                            $categoryName = $categoryRow['nama'];
                        } else {
                            $categoryName = "Unknown Category";
                        }
    
                        echo "<tr>";
                        echo "<td> #" . $categoryName . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        $harga = number_format($row['harga'], strlen($row['harga']) > 3 ? 0 : 2, ".", ".");

                        echo "<td>Rp" . $harga . "</td>";
                        echo "<td>" . $row['stok'] . "</td>";
                        echo "<td><img src='foto_product/" . $row['gambar'] . "' alt='Product Image' style='width: 200px; height: 200px;'></td>";
                        echo "<td><ul>";
    
                        $deskripsiLines = explode("\n", $row['deskripsi']);
                        foreach ($deskripsiLines as $line) {
                            if (!empty($line)) {
                                echo "<li>" . trim($line) . "</li>";
                            }
                        }
    
                        echo "</ul></td>";
                        echo "<td>
                            <a href='edit_product.php?id={$row['id']}' class='btn btn-info'>Edit</a>
                            <a href='#' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteProductModal{$row['id']}'>Hapus</a>
                        </td>";
                        echo "</tr>";

                        // Modal Hapus
                        echo "<div class='modal fade' id='deleteProductModal{$row['id']}' tabindex='-1' aria-labelledby='deleteProductModalLabel{$row['id']}' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='deleteProductModalLabel{$row['id']}'>Hapus Produk</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Anda yakin ingin menghapus produk '{$row['nama']}'?</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <form method='post' action='delete_product.php'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                            <button type='submit' class='btn btn-danger'>Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
    
                        // Free the result set for the category query
                        $categoryResult->free();
                    }
    
                    // Output HTML table footer
                    echo "</tbody></table>";
                    echo "</div>";
    
                    // Pagination links
                    $totalProductsQuery = "SELECT COUNT(*) as total FROM tbProduk WHERE (nama LIKE '%$search%' OR deskripsi LIKE '%$search%')";
                    if (!empty($categoryFilter)) {
                        $totalProductsQuery .= " AND id_kategori = $categoryFilter";
                    }
                    $totalProductsResult = $koneksi->query($totalProductsQuery);
                    $totalProductsRow = $totalProductsResult->fetch_assoc();
                    $totalProducts = $totalProductsRow['total'];
                    $totalPages = ceil($totalProducts / $productsPerPage);
    
                    
    
                    // Pagination links
                    echo "<nav aria-label='Page navigation'>
                            <ul class='pagination justify-content-center'>
                                <li class='page-item " . ($page == 1 ? 'disabled' : '') . "'>
                                    <a class='page-link' href='?page=" . ($page - 1) . "&search=$search&category=$categoryFilter' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>";
    
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i&search=$search&category=$categoryFilter'>$i</a></li>";
                    }
    
                    echo "<li class='page-item " . ($page == $totalPages ? 'disabled' : '') . "'>
                                    <a class='page-link' href='?page=" . ($page + 1) . "&search=$search&category=$categoryFilter' aria-label='Next'>
                                        <span aria-hidden='true'>&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>";
                    // Close the connection after fetching all data
                    $koneksi->close();
                } else {
                    die('.env file not found');
                }
            ?>
        </div>
    
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="add_product.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="kategori" class="col-form-label">Kategori:</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <?php
    
                                    while ($row = $kategori->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="col-form-label">Nama Produk:</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rp.</span>
                                <input type="text" class="form-control" id="harga" name="harga" placeholder="harga" aria-label="harga" aria-describedby="addon-wrapping" required>
                            </div>
                            <div class="mb-3">
                                <label for="stok" class="col-form-label">Stok:</label>
                                <input type="text" class="form-control" id="stok" name="stok" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="col-form-label">Product Image:</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha384-uFiZ5YUVlTJKqIep9tiCxS/Z9fNfEX/ndd9h8Q+p3S+Al/pa8rWOujEWEveJ6sI9" crossorigin="anonymous"></script>
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
