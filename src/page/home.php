<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        #mainContent {
            display: none;
        }
        a{
        text-decoration: none;
        }
        body{
            background-color: #F8F8FF;
        }
        .carousel-item-class{
            border-radius: 15px;
        }
        .card {
            min-height: 250px;
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .card-text {
            margin-bottom: 0.75rem;
        }
        /* CSS for the shimmer animation */
        .placeholder {
            animation: placeHolderShimmer 1s linear infinite forwards;
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-size: 800px 104px;
            border-radius: 4px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            }

            .placeholder.col-6 {
            width: 100%;
            }

            .placeholder.col-7 {
            width: 85.7142857143%;
            }

            .placeholder.col-4 {
            width: 33.3333333333%;
            }

            .placeholder.col-6 {
            width: 50%;
            }

            .placeholder.col-8 {
            width: 66.6666666667%;
        }
    </style>
</head>
<body>
    <header class="border-bottom">    
        <nav class="navbar container navbar-expand-lg ">
            <div class="container-fluid">
                <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="175" height="60" role="img" aria-label="Bootstrap">
                        <image href="../ico/logo/png/logo-no-background.png" width="100%" height="100%" />
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

                    <form method='get' action='' class='col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
                        <input class="form-control me-2" type="search" name="search" placeholder="Cari Kategori/Produk di sini" aria-label="Search" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    </form>

                    <div class="dropdown text-center">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../ico/img/IMG-20191208-WA0004.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
                            <?php echo isset($_SESSION['user_nama']) ? $_SESSION['user_nama'] : ''; ?>
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="product/dashboard.php">Admin</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <!-- <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">Settings</a></li> -->
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../login/logout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Loading spinner placeholder with shimmer animation -->
    <div id="loadingSpinner" class="text-center container placeholder">
        <div class="card" aria-hidden="true">
            <div class="card-body">
                <h5 class="card-title placeholder-glow">
                <span class="placeholder col-6"></span>
                </h5>
                <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
                </p>
            </div>
        </div>
    </div>
    <main>
        
        <div id="mainContent" class="container mt-2">
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $imagePath = 'promosi/';
                    $images = glob($imagePath . '*.*');
    
                    foreach ($images as $image) {
                        $imageSrc = substr($image, strlen($imagePath));
                        echo "<div class='carousel-item active' data-bs-interval='2500'>";
                        echo "<img src='$image' class='d-block w-100 carousel-item-class' alt='$imageSrc'>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <?php
                $envFile = __DIR__ . '/../../.env';
    
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
    
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
                    // Define the number of products to be displayed per page
                    $productsPerPage = 30;
    
                    // Define the starting point for the current page
                    $offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $productsPerPage : 0;
    
                    // Fetch categories for dropdown
                    $categoryDropdownQuery = "SELECT * FROM tbkategori";
                    $categoryDropdownResult = $koneksi->query($categoryDropdownQuery);
    
                    // Get products from database
                    $search = isset($_GET['search']) ? $koneksi->real_escape_string($_GET['search']) : '';
                    $categoryFilter = isset($_GET['category']) ? $koneksi->real_escape_string($_GET['category']) : '';
    
                    // Modify the SQL query to include the category in the search
                    $sql = "SELECT * FROM tbProduk WHERE (nama LIKE '%$search%' OR deskripsi LIKE '%$search%' OR id_kategori IN (SELECT id FROM tbkategori WHERE nama LIKE '%$search%'))";
                    if (!empty($categoryFilter)) {
                        $sql .= " AND id_kategori = $categoryFilter";
                    }
                    $sql .= " LIMIT $productsPerPage OFFSET $offset";
    
                    $result = $koneksi->query($sql);
    
    
                    // Output search form
                    echo "<form method='get' action='' class='row g-3 mt-3'>
                      <div class='col-md-6'>
                          <label for='search' class='form-label'>Search:</label>
                          <input type='text' class='form-control' id='search' name='search' value='$search'>
                      </div>
                      <div class='col-md-4'>
                          <label for='category' class='form-label'>Category:</label>
                          <select class='form-select' id='category' name='category'>
                              <option value='' " . ($categoryFilter == '' ? 'selected' : '') . ">All Categories</option>";
    
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
    
                    echo "<hr>";
                    echo "<p class='mt-2'>Choose from a wide range of products and make your life easier with our technological solutions.</p>";
    
                    echo "<div class='row row-cols-1 row-cols-md-6 g-4'>";
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-sm-6 mb-3 mb-sm-'>";
                        echo "<div class='card h-100' id='card" . $row['id'] . "'>";
                        echo "<img src='product/foto_product/" . $row['gambar'] . "' class='card-img-top' alt='...'>";
                        echo "<div class='card-body'>";
    
                        $judulProduk = $row['nama'];
                        if (strlen($judulProduk) > 25) {
                            $judulProduk = substr($judulProduk, 0, 25) . "...";
                        }
    
                        echo "<h5 class='card-title' style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $judulProduk . "</h5>";
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
                        echo "<div class='mt-5'>";
                        // echo "<a href='product/product_detail.php?id=" . $row['id'] . "' class='btn btn-primary position-absolute bottom-0 start-0'>Details</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
    
                    echo "</div>";
    
                    $sql = "SELECT * FROM tbProduk WHERE (nama LIKE '%$search%' OR deskripsi LIKE '%$search%' OR id_kategori IN (SELECT id FROM tbkategori WHERE nama LIKE '%$search%'))";
                    if (!empty($categoryFilter)) {
                        $sql .= " AND id_kategori = $categoryFilter";
                    }
                    $sql .= " LIMIT $productsPerPage OFFSET $offset";
    
                    $result = $koneksi->query($sql);
    
                    // Add this code to get the total number of products for the given search and category
                    $totalProductsQuery = "SELECT COUNT(*) as total FROM tbProduk WHERE (nama LIKE '%$search%' OR deskripsi LIKE '%$search%')";
                    if (!empty($categoryFilter)) {
                        $totalProductsQuery .= " AND id_kategori = $categoryFilter";
                    }
                    $totalProductsResult = $koneksi->query($totalProductsQuery);
                    $totalProductsRow = $totalProductsResult->fetch_assoc();
                    $totalProducts = $totalProductsRow['total'];
    
                    // Calculate the total number of pages
                    $totalPages = ceil($totalProducts / $productsPerPage);
    
                    // Pagination links
                    echo "<nav aria-label='Page navigation'><ul class='pagination justify-content-center'>";
                    echo "<li class='page-item " . ($page == 1 ? 'disabled' : '') . "'><a class='page-link' href='?page=" . ($page - 1) . "&search=$search&category=$categoryFilter' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
    
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i&search=$search&category=$categoryFilter'>$i</a></li>";
                    }
    
                    echo "<li class='page-item " . ($page == $totalPages ? 'disabled' : '') . "'><a class='page-link' href='?page=" . ($page + 1) . "&search=$search&category=$categoryFilter' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li></ul></nav>";
    
                    // Close the connection after fetching all data
                    $koneksi->close();
                } else {
                    die('.env file not found');
                }
            ?>
        </div>

        <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Language Settings -->
                        <div class="mb-3">
                            <label for="languageSelect" class="form-label">Select Language:</label>
                            <select class="form-select" id="languageSelect">
                                <option value="en">English</option>
                                <option value="id">Bahasa Indonesia</option>
                            </select>
                        </div>

                        <!-- Theme Settings -->
                        <div class="mb-3">
                            <label class="form-label">Select Theme:</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="themeSwitch">
                                <label class="form-check-label" for="themeSwitch">Dark Mode</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="applySettings()">Apply Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
            <div class="col mb-3">
            <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="175" height="60" role="img" aria-label="Bootstrap">
                    <image href="../ico/logo/png/logo-no-background.png" width="100%" height="100%" />
                </svg>
            </a>
            <p class="text-body-secondary">&copy; 2023</p>
            </div>

            <div class="col mb-3">

            </div>

            <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
            </div>

            <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
            </div>

            <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha384-uFiZ5YUVlTJKqIep9tiCxS/Z9fNfEX/ndd9h8Q+p3S+Al/pa8rWOujEWEveJ6sI9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function() {
                const id = this.id.split('card')[1];
                window.location.href = `product/product_detail.php?id=${id}`;
            });
        });
    </script>
    <script>
    // JavaScript to show loading spinner, delay, and reveal main content
    document.addEventListener("DOMContentLoaded", function () {
        // Show loading spinner
        document.getElementById("loadingSpinner").style.display = "block";

        // Function to delay for 2.5 seconds
        function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
        }

        // Delay for 2.5 seconds and then reveal main content
        delay(1000).then(function () {
        // Hide loading spinner
        document.getElementById("loadingSpinner").style.display = "none";

        // Show main content
        document.getElementById("mainContent").style.display = "block";
        });
    });
    </script>

<script>
    // Function to apply theme settings
    function applySettings() {
        // Get the state of the theme switch
        var themeSwitch = document.getElementById('themeSwitch');
        var selectedTheme = themeSwitch.checked ? 'dark' : 'light';

        // Apply the new theme
        document.documentElement.setAttribute('data-bs-theme', selectedTheme);

        // Save the theme preference
        localStorage.setItem('theme', selectedTheme);

        // Close the settings modal
        var settingsModal = new bootstrap.Modal(document.getElementById('settingsModal'));
        settingsModal.hide();
    }

    // Check if there is a saved theme preference
    var savedTheme = localStorage.getItem('theme');

    // If a theme preference is found, apply it
    if (savedTheme) {
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        // Set the state of the theme switch based on the saved theme
        var themeSwitch = document.getElementById('themeSwitch');
        themeSwitch.checked = (savedTheme === 'dark');
    }
</script>


</body>
</html>