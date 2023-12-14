<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../../index.php');
    exit;
}

// Check if the session variable is set
if (!isset($_SESSION['admin_password'])) {
    // If not, check if the form is submitted with a password
    if (isset($_POST['admin_password'])) {
        // Check if the entered password is correct
        $enteredPassword = $_POST['admin_password'];
        $correctPassword = '228067'; // Replace with your actual password

        if ($enteredPassword === $correctPassword) {
            // Password is correct, set session variable and timestamp
            $_SESSION['admin_password'] = $enteredPassword;
            $_SESSION['password_timestamp'] = time();
        } else {
            // Password is incorrect, display an error message
            echo "Incorrect password. Please try again.";
            exit;
        }
    } else {
        // If no session and no password submitted, prompt for password
        echo "<form method='post'>";
        echo "<label for='admin_password'>Enter Admin Password: </label>";
        echo "<input type='password' name='admin_password' required>";
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
        exit;
    }
}

// Check if the password session has expired (30 seconds)
if (isset($_SESSION['password_timestamp'])) {
    $sessionDuration = 180; // Session duration in seconds
    $timeLeft = $sessionDuration - (time() - $_SESSION['password_timestamp']);

    if ($timeLeft > 0) {
        // If the password is set and not expired, continue with the rest of your code
        echo "<div id='timer'></div>";


        // Include JavaScript to update the timer in real-time
        echo "<script>";
        echo "var timeLeft = $timeLeft;";
        echo "function updateTimer() {";
        echo "  document.getElementById('timer').innerHTML = 'Time left: ' + timeLeft + ' seconds';";
        echo "  if (timeLeft > 0) {";
        echo "    timeLeft--;";
        echo "    setTimeout(updateTimer, 1000);"; // Update every second
        echo "  } else {";
        echo "    window.location.href = '../product/dashboard.php';"; // Expire session when timer reaches 0
        echo "  }";
        echo "}";
        echo "updateTimer();"; // Start the timer when the page loads
        echo "</script>";
    } else {
        // Expire the password session
        unset($_SESSION['admin_password']);
        unset($_SESSION['password_timestamp']);
        echo "Password session expired. Please try again.";
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

    $sql = "SELECT * FROM tbUser";
    $result = $koneksi->query($sql);

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
    <title>Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
                        <li><a href="#" class="nav-link px-2 link-body-emphasis text-light" data-bs-toggle="modal" data-bs-target="#passwordModal">Data User</a></li>
                        <li><a href="../home.php" class="nav-link px-2 link-body-emphasis text-light">Store</a></li>
                        <li><a href="../kategori/kategori.php" class="nav-link px-2 link-body-emphasis text-light">Category</a></li>
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
        <div class="container mt-2 overflow-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $editUserIds = [];
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                        
                            echo "<tr>";
                            echo "<td> #" . $i++ . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td> ***** </td>";
                            echo "<td>" . $row['user_role'] . "</td>";
                            echo "<td>
                                <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#editUserModal-" . $row['id'] . "'>Edit</button>
                                <a href='#' class='btn btn-danger mt-1' data-bs-toggle='modal' data-bs-target='#deleteUserModal' data-user-id='" . $row['id'] . "'>Hapus</a>
                            </td>";
                            echo "</tr>";
                            
                            // Store user ID for toggle script
                            $editUserIds[] = $row['id'];
                            // modal edit
                            echo "<div class='modal fade' id='editUserModal-{$row['id']}' tabindex='-1' aria-labelledby='editUserModalLabel' aria-hidden='true'>";
                            echo "<div class='modal-dialog'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<h5 class='modal-title' id='editUserModalLabel'>Edit User</h5>";
                            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "<form method='post' action='update_user.php'>";
                            echo "<input type='hidden' name='id' value='{$row['id']}'>";
                            echo "<div class='mb-3'>";
                            echo "<label for='nama' class='col-form-label'>Nama:</label>";
                            echo "<input type='text' class='form-control' id='nama' name='nama' value='{$row['nama']}' required>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<label for='email' class='col-form-label'>Email:</label>";
                            echo "<input type='email' class='form-control' id='email' name='email' value='{$row['email']}' required>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<label for='password' class='col-form-label'>Password:</label>";
                            echo "<div class='input-group'>";
                            echo "<input type='password' class='form-control' id='password-{$row['id']}' name='password' value='' required>";
                            echo "<span class='input-group-text bg-transparent'>";
                            echo "<i class='bi bi-eye-slash' id='togglePassword-{$row['id']}'></i>";
                            echo "</span>";
                            echo "</div>";
                            echo "</div>";

                            // Dropdown untuk memilih user_role
                            echo "<div class='mb-3'>";
                            echo "<label for='userRole' class='col-form-label'>User Role:</label>";
                            echo "<select class='form-select' id='userRole' name='user_role' required>";
                            echo "<option value='admin' " . ($row['user_role'] == 'admin' ? 'selected' : '') . ">Admin</option>";
                            echo "<option value='penjual' " . ($row['user_role'] == 'penjual' ? 'selected' : '') . ">Penjual</option>";
                            echo "<option value='pembeli' " . ($row['user_role'] == 'pembeli' ? 'selected' : '') . ">Pembeli</option>";
                            echo "</select>";
                            echo "</div>";

                            echo "</div>";
                            echo "<div class='modal-footer'>";
                            echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                            echo "<button type='submit' class='btn btn-primary'>Update</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../../login/proses_register.php">
                            <div class="mb-3">
                                <label for="nama" class="col-form-label">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="col-form-label">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <span class="input-group-text bg-transparent">
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </span>
                                </div>
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

        <!-- Add User Action Modal -->
        <div class="modal fade" id="userActionModal" tabindex="-1" aria-labelledby="userActionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userActionModalLabel">Choose Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="userActionForm">
                            <div class="mb-3">
                                <label for="action" class="col-form-label">Select Action:</label>
                                <select class="form-select" id="action" name="action" required>
                                    <option value="edit">Edit User</option>
                                    <option value="password">Change Password</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete User Confirmation Modal -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger" id="confirmDelete">Delete</a>
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
        document.getElementById('togglePassword').addEventListener('click', function() {
            var password = document.getElementById('password');
            if (password.type === 'password') {
                password.type = 'text';
                this.classList.remove('bi-eye-slash');
                this.classList.add('bi-eye');
            } else {
                password.type = 'password';
                this.classList.remove('bi-eye');
                this.classList.add('bi-eye-slash');
            }
        });

        // Toggle password for each user
        <?php
        foreach ($editUserIds as $userId) {
            echo "document.getElementById('togglePassword-{$userId}').addEventListener('click', function() {
                var password = document.getElementById('password-{$userId}');
                if (password.type === 'password') {
                    password.type = 'text';
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                } else {
                    password.type = 'password';
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                }
            });";
        }
        ?>
    </script>
    <script>
        function setDeleteUserId(userId) {
            document.getElementById('confirmDelete').href = 'delete_user.php?id=' + userId;
        }

        // Event listener for modal shown event to reset the href
        document.addEventListener('DOMContentLoaded', function () {
            var deleteUserModals = document.querySelectorAll('#deleteUserModal');
            deleteUserModals.forEach(function (modal) {
                modal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var userId = button.getAttribute('data-user-id');
                    setDeleteUserId(userId);
                });
            });
        });
    </script>
</body>
</html>