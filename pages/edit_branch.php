<?php
include '../config.php';

// Ensure database connection is established
if (!isset($pdo)) {
    die("Database connection not established.");
}

// Check if branchNo is provided in URL
if (!isset($_GET['branchNo'])) {
    die("Invalid request. Branch number is required.");
}

$branchNo = $_GET['branchNo'];

// Fetch existing branch details
try {
    $stmt = $pdo->prepare("SELECT * FROM Branch WHERE branchNo = ?");
    $stmt->execute([$branchNo]);
    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$branch) {
        die("Branch not found.");
    }
} catch (PDOException $e) {
    die("Error fetching branch details: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_branch'])) {
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $postcode = trim($_POST['postcode']);

    if (!empty($street) && !empty($city) && !empty($postcode)) {
        try {
            $sql = "UPDATE Branch SET street = ?, city = ?, postcode = ? WHERE branchNo = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$street, $city, $postcode, $branchNo]);
            header("Location: branches.php");
            exit();
        } catch (PDOException $e) {
            die("Error updating branch: " . $e->getMessage());
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
    <title>Edit Branch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Branch</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Branch No</label>
                <input type="text" name="branchNo" class="form-control" value="<?= htmlspecialchars($branch['branchNo']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Street</label>
                <input type="text" name="street" class="form-control" value="<?= htmlspecialchars($branch['street']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($branch['city']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Postcode</label>
                <input type="text" name="postcode" class="form-control" value="<?= htmlspecialchars($branch['postcode']) ?>" required>
            </div>
            <button type="submit" name="update_branch" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
            <a href="branches.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
        </form>
    </div>
</body>
</html>
