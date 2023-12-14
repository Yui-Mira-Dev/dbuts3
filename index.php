<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/5509/5509636.png" />
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/css/stylebg.css">
    <style>
        body {
            background-color: #1d2630;
        }
        a{
            text-decoration: none;
            color: azure;
        }
        @import url("https://fonts.googleapis.com/css2?family=Zilla+Slab&display=swap");

        svg {
            font-family: "Zilla Slab", sans-serif;
            width: 100%; height: 100%;
        }
        svg text {
            animation: stroke 4s infinite alternate;
            stroke-width: 2;
            stroke: #000000;
            font-size: 65px;
        }
        @keyframes stroke {
            0%   {
                fill: rgba(255,255,255,0); stroke: rgba(0,0,0,1);
                stroke-dashoffset: 25%; stroke-dasharray: 0 50%; stroke-width: 2;
            }
            70%  {fill: rgba(255,255,255,0); stroke: rgba(0,0,0,1); }
            80%  {fill: rgba(255,255,255,0); stroke: rgba(0,0,0,1); stroke-width: 3; }
            100% {
                fill: rgba(255,255,255,1); stroke: rgba(0,0,0,0);
                stroke-dashoffset: -25%; stroke-dasharray: 50% 0; stroke-width: 0;
            }
        }
    </style>
    <?php
    if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') {
        echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
                <div class="toast-header">
                    <img src="src/ico/database-dash.svg" class="rounded me-2" alt="...">
                    <strong class="me-auto">Admin</strong>
                    <small class="text-body-secondary">Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-black">
                    Nama or password is invalid <br>
                    Silahkan Register untuk Melanjutkan
                </div>
            </div>
        </div>';

        echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var toastElement = document.querySelector(".toast");
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    });
                </script>';
        }
    ?>
</head>
<body>
    <main>
        <section>
            <div class="container mb-5" style="margin-top: 125px;">
                <div class="row justify-content-center">
                    <div class="card border-light mb-3 bg-primary p-2 text-dark bg-opacity-25 col-6 mx-auto" style="max-width: 29rem; box-shadow: 2px 2px 11px -2px rgba(14, 196, 200, 0.83);">
                        <div class="wrapper">
                            <svg>
                                <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                                    Login
                                </text>
                            </svg>
                        </div>
                        <div class="card-body">
                            <form ACTION="src/login/proses_login.php" METHOD="POST" NAME="input">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Nama" name="nama">
                                    <label for="floatingInput">Username/Email</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="exampleCheckbox">
                                    <label class="form-check-label text-white" for="exampleCheckbox">
                                        remember Me
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success mt-2" name="Login">Login</button>
                                    <!-- <a href="src/utils/back_page/register.php"><button type="btn" class="btn btn-info mt-2">Login</button></a> -->
                                </div>
                                <div>
                                <!-- <p class="text-white">Belum punya akun? <a href="src/login/register.php" class="text-success">Daftar</a></p> -->
                                <p class="text-white"><a href="src/login/lupa_pass/forgot_password.php" class="text-success">Lupa Password?</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="bg-animation" style="z-index: -1;">
            <div id="stars"></div>
            <div id="stars2"></div>
            <div id="stars3"></div>
            <div id="stars4"></div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>