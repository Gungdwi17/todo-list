<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e9e5dc 0%,rgb(255, 255, 254) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(108, 117, 125, 0.10);
            border: none;
            background:white;
        }
        .card-header {
            background: #198754;
            border-radius: 18px 18px 0 0;
        }
        .card-header h4 {
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .d-grid button {

            border-color: #198754 important;
        }
        .btn-earth {
            background-color: #198754;
            color: #fff;
            border: none;
        }
        .btn-earth:hover {
            background-color:rgb(18, 88, 56);
            color: #fff;
        }
        .register-link {
            text-align: center;
            margin-top: 18px;
            font-size: 15px;
        }
        .register-link a {
            color: #198754;
            font-weight: 600;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
            color: #6c757d;
        }
        
</style>

<body>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-4">

                <div classs login-container>
                </div>
                <div class="card">

                    <div class="card-header text-center">

                        <h4>Login</h4>

                    </div>

                    <div class="card-body">

                        <form action="proses_login.php" method="POST">

                            <div class="mb-3">

                                <label for="user_id" class="form-label">Email</label>

                                <input type="text" class="form-control" id="user_id" name="email" required>

                            </div>

                            <div class="mb-3">

                                <label for="password" class="form-label">Password</label>

                                <input type="password" class="form-control" id="password" name="password" required>

                            </div>

                            <div class="d-grid">

                                <button type="submit" class="btn btn-earth">Login</button>


                            </div>

                        </form>
                        <div class="register-link">
                            Sudah punya akun? <a href="registrasi.php">
                                daftar
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>