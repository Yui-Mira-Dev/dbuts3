<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/5509/5509636.png" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/stylebg.css">
    <style>
        body {
            background-color: #1d2630;
        }
        a{
            text-decoration: none;
            color: azure;
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
    </script>
</head>
<body>
    <div class="container mb-5" style="margin-top: 125px;">
        <div class="row justify-content-center">
            <div class="card border-light mb-3 bg-primary p-2 bg-opacity-25 col-6 mx-auto" style="max-width: 29rem;">
                <h2 class="card-header text-center">Register</h2>
                <div class="card-body">
                <form ACTION="proses_register.php" METHOD="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="Nama" name="nama" required>
                        <label for="floatingName">Nama</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" placeholder="Email" name="email" required>
                        <label for="floatingEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success mt-2" name="register">Register</button>
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