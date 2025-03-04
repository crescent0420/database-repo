<?php
include '../config.php'; // Ensure this contains a valid $conn (mysqli) connection

// Function to get total count from a table
function getCount($conn, $table) {
    $query = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // Return 0 if query fails
    }
}

// Retrieve counts from database
$counts = [
    "branches" => getCount($conn, "branches"),
    "staff" => getCount($conn, "staff"),
    "properties" => getCount($conn, "properties"),
    "clients" => getCount($conn, "clients"),
    "owners" => getCount($conn, "owners"),
    "viewings" => getCount($conn, "viewings"),
    "users" => getCount($conn, "users")
];

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
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background: rgb(1, 93, 87);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .icon {
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
    <h2 class="text-center"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></h2>
        <a href="branches.php">Branches</a>
        <a href="staff.php">Staff</a>
        <a href="properties.php">Properties</a>
        <a href="clients.php">Clients</a>
        <a href="owners.php">Owners</a>
        <a href="viewing.php">Viewings</a>
        <a href="registration.php">User Registration</a>
    </div>

    <div class="content">
        <h2>Dashboard</h2>
        <div class="row">
            <?php
            $items = [
                "Branches" => ["count" => $counts['branches'], "icon" => "fa-building"],
                "Staff" => ["count" => $counts['staff'], "icon" => "fa-users"],
                "Properties" => ["count" => $counts['properties'], "icon" => "fa-home"],
                "Clients" => ["count" => $counts['clients'], "icon" => "fa-user"],
                "Owners" => ["count" => $counts['owners'], "icon" => "fa-user-tie"],
                "Viewings" => ["count" => $counts['viewings'], "icon" => "fa-eye"],
                "Registrations" => ["count" => $counts['users'], "icon" => "fa-user-plus"]
            ];

            foreach ($items as $key => $item) {
                echo '
                <div class="col-md-4 mb-3">
                    <div class="card text-white" style="background-color: #FFA726;">
                        <div>
                            <h3>' . $key . '</h3>
                            <p>Total: ' . $item['count'] . '</p>
                        </div>
                        <i class="fa ' . $item['icon'] . ' icon"></i>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
