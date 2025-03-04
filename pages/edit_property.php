<?php
include '../config.php'; // Ensure this correctly defines $pdo

// Check if propertyNo is provided
if (!isset($_GET['propertyNo'])) {
    header("Location: properties.php");
    exit();
}

$propertyNo = filter_var($_GET['propertyNo'], FILTER_SANITIZE_STRING);

// Fetch property details
try {
    $stmt = $pdo->prepare("SELECT * FROM PropertyForRent WHERE propertyNo = ?");
    $stmt->execute([$propertyNo]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$property) {
        echo "<script>alert('Property not found!'); window.location.href = 'properties.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle form submission for updating property
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_property'])) {
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $postcode = trim($_POST['postcode']);
    $type = trim($_POST['type']);
    $rooms = trim($_POST['rooms']);
    $rent = trim($_POST['rent']);
    $ownerNo = trim($_POST['ownerNo']);
    $staffNo = trim($_POST['staffNo']);
    $branchNo = trim($_POST['branchNo']);

    if (!empty($street) && !empty($city) && !empty($postcode) && !empty($type) && !empty($rooms) && !empty($rent) && !empty($ownerNo) && !empty($staffNo) && !empty($branchNo)) {
        try {
            $sql = "UPDATE PropertyForRent SET street=?, city=?, postcode=?, type=?, rooms=?, rent=?, ownerNo=?, staffNo=?, branchNo=? WHERE propertyNo=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$street, $city, $postcode, $type, $rooms, $rent, $ownerNo, $staffNo, $branchNo, $propertyNo]);
            header("Location: properties.php");
            exit();
        } catch (PDOException $e) {
            die("Error updating data: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property - Dream Home</title>
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
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-center">Dream Home</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="branches.php"><i class="fas fa-code-branch"></i> Branches</a>
        <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
        <a href="properties.php"><i class="fas fa-building"></i> Properties</a>
        <a href="clients.php"><i class="fas fa-user"></i> Clients</a>
        <a href="owners.php"><i class="fas fa-user-tie"></i> Owners</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Edit Property</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="propertyNo" class="form-label">Property No (Cannot be changed)</label>
                <input type="text" id="propertyNo" class="form-control" value="<?= htmlspecialchars($property['propertyNo']) ?>" disabled>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" id="street" name="street" class="form-control" value="<?= htmlspecialchars($property['street']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($property['city']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="postcode" class="form-label">Postcode</label>
                    <input type="text" id="postcode" name="postcode" class="form-control" value="<?= htmlspecialchars($property['postcode']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" id="type" name="type" class="form-control" value="<?= htmlspecialchars($property['type']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="rooms" class="form-label">Rooms</label>
                    <input type="number" id="rooms" name="rooms" class="form-control" value="<?= htmlspecialchars($property['rooms']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="rent" class="form-label">Rent</label>
                    <input type="number" id="rent" name="rent" class="form-control" value="<?= htmlspecialchars($property['rent']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="ownerNo" class="form-label">Owner No</label>
                    <input type="text" id="ownerNo" name="ownerNo" class="form-control" value="<?= htmlspecialchars($property['ownerNo']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="staffNo" class="form-label">Staff No</label>
                    <input type="text" id="staffNo" name="staffNo" class="form-control" value="<?= htmlspecialchars($property['staffNo']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="branchNo" class="form-label">Branch No</label>
                    <input type="text" id="branchNo" name="branchNo" class="form-control" value="<?= htmlspecialchars($property['branchNo']) ?>" required>
                </div>
            </div>
            <button type="submit" name="update_property" class="btn btn-success mt-3"><i class="fas fa-save"></i> Update Property</button>
            <a href="properties.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Back</a>
        </form>
    </div>

</body>
</html>
