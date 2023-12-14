<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}

$user_role = $_SESSION['user_role'];

if ($user_role == 'admin' || $user_role == 'penjual') {
    // Jika sudah diarahkan ke product.php, biarkan pengguna di sana
    if (basename($_SERVER['PHP_SELF']) !== 'kategori.php') {
        header('Location: kategori.php');
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

    // Paginasi
    $limit = 5; // Jumlah data per halaman
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini

    $start = ($page - 1) * $limit;

    $sql = "SELECT * FROM tbkategori LIMIT $start, $limit";
    $result = $koneksi->query($sql);

    // Hitung total records
    $sqlCount = "SELECT COUNT(*) AS total FROM tbkategori";
    $resultCount = $koneksi->query($sqlCount);
    $data = $resultCount->fetch_assoc();
    $total_pages = ceil($data['total'] / $limit);

    $koneksi->close();
} else {
    die('.env file not found');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'gagal') {
        echo '<script>
            alert("Kategori masih berkaitan dengan beberapa produk.");
            </script>';
        }
    ?>
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
                        <li><a href="#" class="nav-link px-2 link-body-emphasis text-light">Category</a></li>
                        <li><a href="../product/product.php" class="nav-link px-2 link-body-emphasis text-light">Products</a></li>
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
                            <li><a class="dropdown-item" href="../product/dashboard.php">Admin</a></li>
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
            <h2>Data Kategori</h2>
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Tambah Kategori</a>
            <!-- Modal Tambah Kategori -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="proses_tambah_kategori.php">
                                <div class="mb-3">
                                    <label for="nama" class="col-form-label">Nama Kategori:</label>
                                    <div class="input-group flex-nowrap">
                                        <span class="input-group-text" id="addon-wrapping">#</span>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kategori" aria-label="Nama Kategori" aria-describedby="addon-wrapping" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Nama</th>
                        <th class='text-end'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['nama']}</td>
                            <td class='text-end'>
                                <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editCategoryModal{$row['id']}'>Edit</a>
                                <a href='#' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteCategoryModal{$row['id']}'>Hapus</a>
                            </td>
                        </tr>";
    
                        // Modal Edit
                        echo "<div class='modal fade' id='editCategoryModal{$row['id']}' tabindex='-1' aria-labelledby='editCategoryModalLabel{$row['id']}' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='editCategoryModalLabel{$row['id']}'>Edit Kategori</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form method='post' action='proses_edit_kategori.php'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <div class='mb-3'>
                                                    <label for='nama' class='col-form-label'>Nama Kategori:</label>
                                                    <input type='text' class='form-control' id='nama' name='nama' value='{$row['nama']}' required>
                                                </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-primary'>Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
    
                        // Modal Hapus
                        echo "<div class='modal fade' id='deleteCategoryModal{$row['id']}' tabindex='-1' aria-labelledby='deleteCategoryModalLabel{$row['id']}' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='deleteCategoryModalLabel{$row['id']}'>Hapus Kategori</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p>Anda yakin ingin menghapus kategori '{$row['nama']}'?</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <form method='post' action='proses_hapus_kategori.php'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                                <button type='submit' class='btn btn-danger'>Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                    ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
                }
                ?>
            </ul>
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
            fetch('../product/check_password.php', {
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
