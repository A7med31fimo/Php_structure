<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | CV-Creator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="max-width:400px;width:100%;">
            <h3 class="text-center mb-4">Create Account ✨</h3>

            <div id="alertBox"></div>

            <form id="registerForm">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Full name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="Email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>

                <p class="text-center mt-3">
                    Already have an account? <a href="login.php">Login</a>
                </p>
            </form>
        </div>
    </div>

    <script src="../../assets/scripts/auth.js"></script>
    <script>
        initAuthForm('register');
    </script>
</body>

</html>