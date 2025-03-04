<?php
include '../config.php'; // Ensure this correctly defines $pdo

// Check if staffNo is provided
if (!isset($_GET['staffNo'])) {
    header("Location: staff.php");
    exit();
}

$staffNo = filter_var($_GET['staffNo'], FILTER_SANITIZE_STRING);

// Fetch staff details
try {
    $stmt = $pdo->prepare("SELECT * FROM Staff WHERE staffNo = ?");
    $stmt->execute([$staffNo]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        echo "<script>alert('Staff member not found!'); window.location.href = 'staff.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Handle form submission for updating staff
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_staff'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $position = trim($_POST['position']);
    $sex = trim($_POST['sex']);
    $DOB = trim($_POST['DOB']);
    $salary = trim($_POST['salary']);
    $branchNo = trim($_POST['branchNo']);

    if (!empty($firstName) && !empty($lastName) && !empty($position) && !empty($sex) && !empty($DOB) && !empty($salary) && !empty($branchNo)) {
        try {
            $sql = "UPDATE Staff SET firstName=?, lastName=?, position=?, sex=?, DOB=?, salary=?, branchNo=? WHERE staffNo=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $position, $sex, $DOB, $salary, $branchNo, $staffNo]);
            header("Location: staff.php");
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
    <title>Edit Staff - Dream Home</title>
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
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Edit Staff</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="staffNo" class="form-label">Staff No (Cannot be changed)</label>
                <input type="text" id="staffNo" class="form-control" value="<?= htmlspecialchars($staff['staffNo']) ?>" disabled>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control" value="<?= htmlspecialchars($staff['firstName']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control" value="<?= htmlspecialchars($staff['lastName']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" id="position" name="position" class="form-control" value="<?= htmlspecialchars($staff['position']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="sex" class="form-label">Sex</label>
                    <select id="sex" name="sex" class="form-control" required>
                        <option value="M" <?= $staff['sex'] == 'M' ? 'selected' : '' ?>>Male</option>
                        <option value="F" <?= $staff['sex'] == 'F' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="DOB" class="form-label">Date of Birth</label>
                    <input type="date" id="DOB" name="DOB" class="form-control" value="<?= htmlspecialchars($staff['DOB']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" id="salary" name="salary" class="form-control" value="<?= htmlspecialchars($staff['salary']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="branchNo" class="form-label">Branch No</label>
                    <input type="text" id="branchNo" name="branchNo" class="form-control" value="<?= htmlspecialchars($staff['branchNo']) ?>" required>
                </div>
            </div>
            <button type="submit" name="update_staff" class="btn btn-success mt-3"><i class="fas fa-save"></i> Update Staff</button>
            <a href="staff.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Back</a>
        </form>
    </div>

</body>
</html>
