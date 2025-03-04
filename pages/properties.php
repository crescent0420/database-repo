<?php
include '../config.php'; // Ensure this correctly defines $pdo

// Handle Adding a New Property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_property'])) {
    $propertyNo = trim($_POST['propertyNo']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $postcode = trim($_POST['postcode']);
    $type = trim($_POST['type']);
    $rooms = trim($_POST['rooms']);
    $rent = trim($_POST['rent']);
    $ownerNo = trim($_POST['ownerNo']);
    $staffNo = trim($_POST['staffNo']);
    $branchNo = trim($_POST['branchNo']);

    if (!empty($propertyNo) && !empty($street) && !empty($city) && !empty($postcode) && !empty($type) && !empty($rooms) && !empty($rent) && !empty($ownerNo) && !empty($staffNo) && !empty($branchNo)) {
        try {
            $sql = "INSERT INTO PropertyForRent (propertyNo, street, city, postcode, type, rooms, rent, ownerNo, staffNo, branchNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$propertyNo, $street, $city, $postcode, $type, $rooms, $rent, $ownerNo, $staffNo, $branchNo]);
            header("Location: properties.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

// Handle Deleting a Property
if (isset($_GET['delete'])) {
    $propertyNo = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
    if (!empty($propertyNo)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM PropertyForRent WHERE propertyNo = ?");
            $stmt->execute([$propertyNo]);
            header("Location: properties.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
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
        .action-icons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
    <h2 class="text-center"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></h2>
        <a href="branches.php"><i class="fas fa-code-branch"></i> Branches</a>
        <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
        <a href="properties.php"><i class="fas fa-building"></i> Properties</a>
        <a href="clients.php"><i class="fas fa-user"></i> Clients</a>
        <a href="privateowner.php"><i class="fas fa-user-tie"></i> Owners</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Properties</h2>

        <!-- Add New Property Form -->
        <form method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="propertyNo" class="form-control" placeholder="Property No" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="street" class="form-control" placeholder="Street" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="postcode" class="form-control" placeholder="Postcode" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="type" class="form-control" placeholder="Type" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="rooms" class="form-control" placeholder="Rooms" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="rent" class="form-control" placeholder="Rent" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="ownerNo" class="form-control" placeholder="Owner No" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="staffNo" class="form-control" placeholder="Staff No" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="branchNo" class="form-control" placeholder="Branch No" required>
                </div>
            </div>
            <button type="submit" name="add_property" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Add Property</button>
        </form>

        <!-- Properties List -->
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM PropertyForRent");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                        echo "<td class='action-icons'>
                                <a href='edit_property.php?propertyNo=" . urlencode($row['propertyNo']) . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                <a href='properties.php?delete=" . urlencode($row['propertyNo']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i> Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='11'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
