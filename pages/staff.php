<?php
include '../config.php';

// Handle Adding a New Staff Member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_staff'])) {
    $staffNo = $_POST['staffNo'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $position = $_POST['position'];
    $sex = $_POST['sex'];
    $DOB = $_POST['DOB'];
    $salary = $_POST['salary'];
    $branchNo = $_POST['branchNo'];

    $sql = "INSERT INTO Staff (staffNo, firstName, lastName, position, sex, DOB, salary, branchNo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$staffNo, $firstName, $lastName, $position, $sex, $DOB, $salary, $branchNo]);

    header("Location: staff.php");
    exit();
}

// Handle Deleting a Staff Member
if (isset($_GET['delete'])) {
    $staffNo = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM Staff WHERE staffNo = ?");
    $stmt->execute([$staffNo]);
    header("Location: staff.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Dream Home</title>
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
        <a href="owners.php"><i class="fas fa-user-tie"></i> Owners</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Staff</h2>

        <!-- Add New Staff Member Form -->
        <form method="POST" class="mb-3">
            <div class="row">
                <div class="col-md-1">
                    <input type="text" name="staffNo" class="form-control" placeholder="Staff No" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="position" class="form-control" placeholder="Position" required>
                </div>
                <div class="col-md-1">
                    <select name="sex" class="form-control" required>
                        <option value="">Sex</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="DOB" class="form-control" required>
                </div>
                <div class="col-md-1">
                    <input type="text" name="salary" class="form-control" placeholder="Salary" required>
                </div>
                <div class="col-md-1">
                    <input type="text" name="branchNo" class="form-control" placeholder="Branch No" required>
                </div>
            </div>
            <button type="submit" name="add_staff" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Add Staff</button>
        </form>

        <!-- Staff List -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Staff No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Sex</th>
                    <th>DOB</th>
                    <th>Salary</th>
                    <th>Branch No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM Staff");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['staffNo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sex']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['DOB']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['branchNo']) . "</td>";
                    echo "<td class='action-icons'>
                            <a href='edit_staff.php?staffNo=" . $row['staffNo'] . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                            <a href='staff.php?delete=" . $row['staffNo'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i> Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
