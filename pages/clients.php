<?php
include '../config.php';

// Ensure database connection is established
if (!isset($pdo)) {
    die("Database connection not established.");
}

// Handle Adding a New Client
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_client'])) {
    $clientNo = trim($_POST['clientNo']);
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $telNo = trim($_POST['telNo']);
    $prefType = trim($_POST['prefType']);
    $maxRent = trim($_POST['maxRent']);
    $eMail = trim($_POST['eMail']);

    if (!empty($clientNo) && !empty($fName) && !empty($lName) && !empty($telNo) && !empty($eMail)) {
        try {
            $sql = "INSERT INTO Client (clientNo, fName, lName, telNo, prefType, maxRent, eMail) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$clientNo, $fName, $lName, $telNo, $prefType, $maxRent, $eMail]);
            header("Location: clients.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

// Handle Deleting a Client
if (isset($_GET['delete'])) {
    $clientNo = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
    if (!empty($clientNo)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM Client WHERE clientNo = ?");
            $stmt->execute([$clientNo]);
            header("Location: clients.php");
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
    <title>Clients - Dream Home</title>
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
        <h2>Clients</h2>

        <!-- Add New Client Form -->
        <form method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="clientNo" class="form-control" placeholder="Client No" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="fName" class="form-control" placeholder="First Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="lName" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="telNo" class="form-control" placeholder="Telephone" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="prefType" class="form-control" placeholder="Preferred Type">
                </div>
                <div class="col-md-2">
                    <input type="number" name="maxRent" class="form-control" placeholder="Max Rent">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="email" name="eMail" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <button type="submit" name="add_client" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Add Client</button>
        </form>

        <!-- Clients List -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Client No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Telephone</th>
                    <th>Preferred Type</th>
                    <th>Max Rent</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM Client");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['clientNo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['fName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telNo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['prefType'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['maxRent'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['eMail']) . "</td>";
                        echo "<td class='action-icons'>
                                <a href='edit_client.php?clientNo=" . urlencode($row['clientNo']) . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                <a href='clients.php?delete=" . urlencode($row['clientNo']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i> Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='8'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
