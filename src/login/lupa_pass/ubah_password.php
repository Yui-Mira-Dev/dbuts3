<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/5509/5509636.png" />
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/stylebg.css">
    <style>
        body {
            background-color: #1d2630;
        }
        a {
            text-decoration: none;
            color: azure;
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .show-password-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }
    </style>
    <script>
        window.onload = function() {
            var params = new URLSearchParams(window.location.search);
            var errorMessage = params.get('error');
            if (errorMessage) {
                alert(errorMessage);
            }
        };

        function togglePassword() {
            var passwordInput = document.getElementById('floatingPassword');
            var passwordToggle = document.getElementById('passwordToggle');
            var showPasswordText = document.getElementById('showPasswordText');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
                showPasswordText.textContent = 'Sembunyikan Password';
            } else {
                passwordInput.type = 'password';
                passwordToggle.innerHTML = '<i class="bi bi-eye"></i>';
                showPasswordText.textContent = 'Lihat Password';
            }
        }
    </script>
</head>
<body>
    <div class="container mb-5" style="margin-top: 125px;">
        <div class="row justify-content-center">
            <div class="card border-light mb-3 bg-primary p-2 bg-opacity-25 col-6 mx-auto" style="max-width: 29rem;">
                <h2 class="card-header text-center">Ubah Password</h2>
                <div class="card-body">
                    <form ACTION="proses_ubah_password.php" method="POST">
                        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                        <div class="form-floating mb-3 password-container">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password Baru" name="password" required>
                            <label for="floatingPassword">Password Baru</label>
                            <span id="passwordToggle" class="password-toggle" onclick="togglePassword()"><i class="bi bi-eye"></i></span>
                        </div>
                        <small id="showPasswordText" class="show-password-text">Lihat Password</small>
                        <div>
                            <button type="submit" class="btn btn-success mt-2" name="submit">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-animation" style="z-index: -1;">
        <div id="stars"></div>
        <div id="stars2"></div>
        <div id="stars3"></div>
        <div id="stars4"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
