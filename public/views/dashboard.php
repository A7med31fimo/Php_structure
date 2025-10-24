<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | CV-Creator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #6610f2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .dashboard-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .dashboard-card h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .btn-custom {
            width: 150px;
            margin: 10px;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: #0dcaf0;
            color: white;
        }

        .btn-register {
            background-color: #ffc107;
            color: black;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <script>
        // If already logged in, go to home page
        const token = localStorage.getItem("auth_token");
        if (token) {
            window.location.href = "http://localhost/Php_structure/public/views/home.php";
        }
    </script>
    <div class="dashboard-card">
        <h1>Welcome to FimoCV Builder 🚀</h1>
        <p>Create your professional CV easily and manage your profile.</p>
        <div>
            <a href="./auth/login.php" class="btn btn-custom btn-login">Login</a>
            <a href="./auth/register.php" class="btn btn-custom btn-register">Register</a>
        </div>
    </div>
</body>

</html>