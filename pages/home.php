<?php
session_start();

// Set background image and logo paths (update these as needed)
$backgroundImage = "../assets/img/background.jpg";  // Ensure this file exists in assets/img/
$logoImage = "../assets/img/logo.png";  // Ensure this file exists in assets/img/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Dream Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('<?php echo $backgroundImage; ?>') no-repeat center center fixed;
            background-size: cover;
        }
        .navbar {
            background-color: rgba(79, 151, 142, 0.9); /* Semi-transparent */
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            width: 40px; /* Adjust logo size */
            height: 40px;
            margin-right: 10px;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .hero {
            background-color: rgba(255, 167, 38, 0.9); /* Semi-transparent orange */
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-radius: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?php echo $logoImage; ?>" alt="Dream Home Logo"> Dream Home
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="container">
    <div class="hero">
        <h1>Welcome to Dream Home</h1>
        <p>Your one-stop solution for managing properties, staff, and clients.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
