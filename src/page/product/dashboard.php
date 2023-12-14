<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        // Cek apakah user_role adalah 'penjual'
        if ($_SESSION['user_role'] === 'penjual') {
            header('Location: product.php');
            exit;
        } else {
            // Jika tidak memenuhi kondisi di atas, arahkan ke home.php
            header('Location: ../home.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
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
            <div class="jumbotron">
                <h1 class="display-4 text-center">NAHIDO STORE</h1>
                <p class="lead text-center">Choose from a wide range of products and make your life easier with our technological solutions.</p>
                <hr class="my-4">
            </div>
        </div>
        <div class="container text-dark">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="#" class="custom-card" data-bs-toggle="modal" data-bs-target="#passwordModal">
                        <div class="card-icon">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Manage Users</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="../home.php" class="custom-card">
                        <div class="card-icon">
                            <span class="fa fa-store"></span>
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Store</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-desc"></div>
                            <div class="card-info"></div>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="../kategori/kategori.php" class="custom-card">
                        <div class="card-icon">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Category</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-desc"></div>
                            <div class="card-info"></div>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="product.php" class="custom-card">
                        <div class="card-icon">
                            <span class="fa fa-box"></span>
                        </div>
                        <div class="card-title-wrap">
                            <h3 class="card-title">Product</h3>
                            <h4 class="card-subtitle"></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-desc"></div>
                            <div class="card-info"></div>
                        </div>
                        <span class="card-color-fill"></span>
                    </a>
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