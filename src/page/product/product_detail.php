<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
    body{
        background-color: #F8F8FF;
    }
    .card img {
        width: 50%;
        height: auto;
    }
    .card {
        width: 100%;
        /* padding-bottom: 62.5%; */
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    </style>
    </head>
    <body>
    <header class="border-bottom">    
        <nav class="navbar container navbar-expand-lg ">
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
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <!-- <li><a href="#" class="nav-link px-2 link-body-emphasis">Overview</a></li> -->
                        <li><a href="#" class="nav-link px-2 link-body-emphasis">Keranjang</a></li>
                        <li><a href="#" class="nav-link px-2 link-body-emphasis">Kategory</a></li>
                        <li><a href="#" class="nav-link px-2 link-body-emphasis">Products</a></li>
                    </ul>

                    <form method='get' action='../home.php' class='col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
                        <input class="form-control me-2" type="search" name="search" placeholder="Cari Kategori/Produk di sini" aria-label="Search" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    </form>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
    <!-- <header class="p-3 mb-3 border-bottom ">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="../home.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="175" height="60" role="img" aria-label="Bootstrap">
                        <image href="../../ico/logo/png/logo-no-background.png" width="100%" height="100%" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 link-body-emphasis">Keranjang</a></li>
                <li><a href="#" class="nav-link px-2 link-body-emphasis">Kategory</a></li>
                <li><a href="#" class="nav-link px-2 link-body-emphasis">Products</a></li>
                </ul>

                <form method='get' action='../home.php' class='col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari Kategori/Produk di sini" aria-label="Search" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                </form>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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
    </header> -->
    <div class="container mt-2">
        <?php
            $id = $_GET['id'];

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

                $sql = "SELECT * FROM tbProduk WHERE id = $id";
                $result = $koneksi->query($sql);

                if ($row = $result->fetch_assoc()) {
                    echo "<div class='card mb-3' style='max-width: 1540px;'>";
                    echo "<div id='carouselExample' class='carousel slide' data-bs-ride='carousel'>";
                    echo "<div class='carousel-inner'>";

                    // Loop through images to create carousel items
                    $gambarArray = explode(",", $row['gambar']);
                    foreach ($gambarArray as $index => $gambar) {
                        $activeClass = ($index === 0) ? 'active' : '';
                        echo "<div class='carousel-item $activeClass'>";
                        echo "<img src='foto_product/$gambar' class='d-block w-100 img-fluid' alt='Product Image' style='object-fit: cover; max-height: 400px;'>";
                        echo "</div>";
                    }

                    echo "</div>";
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#carouselExample' data-bs-slide='prev'>";
                    echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                    echo "<span class='visually-hidden'>Previous</span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#carouselExample' data-bs-slide='next'>";
                    echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                    echo "<span class='visually-hidden'>Next</span>";
                    echo "</button>";
                    echo "</div>";

                    echo "<div class='row g-0'>";
                    echo "<div class='col-md-12'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['nama'] . "</h5>";
                    // Format the price
                    $harga = number_format($row['harga'], strlen($row['harga']) > 3 ? 0 : 2, ".", ".");

                    echo "<p class='card-text'>Rp" . $harga . "</p>";
                    echo "<p class='card-text ";

                    // Check stock level and set text color accordingly
                    $stok = $row['stok'];
                    if ($stok < 5) {
                        echo "text-danger";
                    } elseif ($stok < 15) {
                        echo "text-warning";
                    } else {
                        echo "text-success";
                    }

                    echo "'>Stok: $stok</p>";

                    echo "<p class='card-text'>Description:</p>";
                    echo "<ul class='card-text'>";

                    // Loop through description lines
                    $deskripsiLines = explode("\n", $row['deskripsi']);
                    foreach ($deskripsiLines as $line) {
                        if (!empty($line)) {
                            echo "<li>" . trim($line) . "</li>";
                        }
                    }

                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "Product not found.";
                }

                // Close the connection after fetching all data
                $koneksi->close();
            } else {
                die('.env file not found');
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha384-uFiZ5YUVlTJKqIep9tiCxS/Z9fNfEX/ndd9h8Q+p3S+Al/pa8rWOujEWEveJ6sI9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>