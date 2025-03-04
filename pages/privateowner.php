<?php
include '../config.php'; // Ensure this correctly defines $pdo
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Dream Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            background:rgb(79, 151, 142);
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
            background:rgb(1, 93, 87);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
    <h2 class="text-center"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></h2>
    <a href="branches.php"><i class="fas fa-code-branch"></i> Branches</a>
        <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
        <a href="properties.php"><i class="fas fa-building"></i> Properties</a>
        <a href="clients.php"><i class="fas fa-user"></i> Clients</a>
    </div>
    <div class="content">
        <h2>Properties</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Property No</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Postcode</th>
                    <th>Type</th>
                    <th>Rooms</th>
                    <th>Rent</th>
                    <th>Owner No</th>
                    <th>Staff No</th>
                    <th>Branch No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM PropertyForRent");
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($rows)) {
                        echo "<tr><td colspan='10' class='text-center'>No properties available.</td></tr>";
                    } else {
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['propertyNo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['street']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['postcode']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['rooms']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['rent']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ownerNo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['staffNo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['branchNo']) . "</td>";
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='10' class='text-danger'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
