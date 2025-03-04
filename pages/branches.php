<?php
include '../config.php';

// Ensure database connection is established
if (!isset($pdo)) {
    die("Database connection not established.");
}

// Handle Adding a New Branch
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_branch'])) {
    $branchNo = trim($_POST['branchNo']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $postcode = trim($_POST['postcode']);

    if (!empty($branchNo) && !empty($street) && !empty($city) && !empty($postcode)) {
        try {
            $sql = "INSERT INTO Branch (branchNo, street, city, postcode) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$branchNo, $street, $city, $postcode]);
            header("Location: branches.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

// Handle Deleting a Branch
if (isset($_GET['delete'])) {
    $branchNo = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
    if (!empty($branchNo)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM Branch WHERE branchNo = ?");
            $stmt->execute([$branchNo]);
            header("Location: branches.php");
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
    <title>Branches - Dream Home</title>
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
        <h2>Branches</h2>

        <!-- Add New Branch Form -->
        <form method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="branchNo" class="form-control" placeholder="Branch No" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="street" class="form-control" placeholder="Street" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="postcode" class="form-control" placeholder="Postcode" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add_branch" class="btn btn-primary"><i class="fas fa-plus"></i> Add Branch</button>
                </div>
            </div>
        </form>

        <!-- Branch List -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Branch No</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Postcode</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM Branch");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['branchNo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['street']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                        echo "<td>" . (!empty($row['postcode']) ? htmlspecialchars($row['postcode']) : 'N/A') . "</td>";
                        echo "<td class='action-icons'>
    <a href='edit_branch.php?branchNo=" . urlencode($row['branchNo']) . "' class='btn btn-warning btn-sm'>
        <i class='fas fa-edit'></i> Edit
    </a>
    <a href='branches.php?delete=" . urlencode($row['branchNo']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
        <i class='fas fa-trash'></i> Delete
    </a>
</td>
";
                        echo "</tr>";
                    }
                    
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
 