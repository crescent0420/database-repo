<?php
include '../config.php';

// Function to get count from the database
function getCount($pdo, $table) {
    $query = "SELECT COUNT(*) as total FROM $table";
    $stmt = $pdo->query($query); // Execute query
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Use PDO's fetch() method
        return $row['total'] ?? 0; // Return total count or 0 if not found
    } else {
        return 0; // Return 0 if query fails
    }
}


// Fetch total counts from the database
$branchCount = getCount($pdo, 'Branch');
$staffCount = getCount($pdo, 'Staff');
$propertyCount = getCount($pdo, 'PropertyForRent');
$clientCount = getCount($pdo, 'Client');
$ownerCount = getCount($pdo, 'PrivateOwner');
$viewingCount = getCount($pdo, 'Viewing');
$registrationCount = getCount($pdo, 'Registration');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Home Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            background: rgb(79, 151, 142);
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px;
            text-decoration: none; /* Removes underline */
            color: white;
            display: flex;
            align-items: center;
            gap: 10px; /* Adds space between icon and text */
        }
        .sidebar a:hover {
        background: rgb(1, 93, 87);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            padding: 20px;
            color: white;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
            text-align: center;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card a {
            text-decoration: none;
            color: white;
        }
        
.content a {
    text-decoration: none; /* Removes underline */
    color: white;
    
    align-items: center;
    gap: 10px; /* Adds space between icon and text */
}


.content a:hover {
    background: rgb(1, 93, 87);
    color: white; /* Keeps text white on hover */
}

    </style>
</head>
<body>
<div class="sidebar">
    <h2 class="text-center"><a href="home.php"><i class="fa-solid fa-house"></i>Home</a></h2>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="branches.php"><i class="fas fa-building"></i> Branches</a>
    <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
    <a href="properties.php"><i class="fas fa-home"></i> Properties</a>
    <a href="clients.php"><i class="fas fa-user"></i> Clients</a>
    <a href="privateowner.php"><i class="fas fa-user-tie"></i> Owners</a>
    <a href="viewings.php"><i class="fas fa-eye"></i> Viewing</a>
    <a href="registrations.php"><i class="fas fa-file-signature"></i> Registration</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

    <div class="content">
        <h2>Dashboard</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="branches.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-building fa-2x"></i>
                        <h3>Branches</h3>
                        <p>Total: <?= $branchCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="staff.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-users fa-2x"></i>
                        <h3>Staff</h3>
                        <p>Total: <?= $staffCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="properties.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-home fa-2x"></i>
                        <h3>Properties</h3>
                        <p>Total: <?= $propertyCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="clients.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-user fa-2x"></i>
                        <h3>Clients</h3>
                        <p>Total: <?= $clientCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="owners.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-user-tie fa-2x"></i>
                        <h3>Owners</h3>
                        <p>Total: <?= $ownerCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="viewings.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-eye fa-2x"></i>
                        <h3>Viewings</h3>
                        <p>Total: <?= $viewingCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="registration.php">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <i class="fas fa-file-signature fa-2x"></i>
                        <h3>Registration</h3>
                        <p>Total: <?= $registrationCount ?></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
