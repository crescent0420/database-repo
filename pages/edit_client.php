<?php
include '../config.php';

// Check if clientNo is provided
if (!isset($_GET['clientNo']) || empty($_GET['clientNo'])) {
    die("Client ID is missing.");
}

$clientNo = $_GET['clientNo'];

// Fetch existing client details
$stmt = $pdo->prepare("SELECT * FROM Client WHERE clientNo = ?");
$stmt->execute([$clientNo]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    die("Client not found.");
}

// Handle form submission (Updating the client)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_client'])) {
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $telNo = trim($_POST['telNo']);
    $prefType = trim($_POST['prefType']);
    $maxRent = trim($_POST['maxRent']);
    $eMail = trim($_POST['eMail']);

    if (!empty($fName) && !empty($lName) && !empty($telNo) && !empty($eMail)) {
        try {
            $sql = "UPDATE Client SET fName = ?, lName = ?, telNo = ?, prefType = ?, maxRent = ?, eMail = ? WHERE clientNo = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fName, $lName, $telNo, $prefType, $maxRent, $eMail, $clientNo]);

            // Redirect back to clients.php after update
            header("Location: clients.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
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
    <title>Edit Client - Dream Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Client</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="fName" class="form-control" value="<?= htmlspecialchars($client['fName']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lName" class="form-control" value="<?= htmlspecialchars($client['lName']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telephone</label>
                <input type="text" name="telNo" class="form-control" value="<?= htmlspecialchars($client['telNo']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Preferred Type</label>
                <input type="text" name="prefType" class="form-control" value="<?= htmlspecialchars($client['prefType'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Max Rent</label>
                <input type="number" name="maxRent" class="form-control" value="<?= htmlspecialchars($client['maxRent'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="eMail" class="form-control" value="<?= htmlspecialchars($client['eMail']) ?>" required>
            </div>
            <button type="submit" name="update_client" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
            <a href="clients.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
        </form>
    </div>
</body>
</html>
