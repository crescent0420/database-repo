<?php
include '../config.php'; // Ensure database connection is included

// Fetch viewing records from the database
try {
    $stmt = $pdo->query("SELECT * FROM viewing");
    $viewings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewings - Dream Home</title>
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
        .table thead {
            background: rgb(79, 151, 142);
            color: white;
        }
        select {
            border: none;
            background: none;
            font-weight: bold;
            cursor: pointer;
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
        <a href="privateowner.php"><i class="fas fa-user-tie"></i> Owners</a>
    </div>

    <div class="content">
        <h2>Viewing Appointments</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Property ID</th>
                    <th>Viewing Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($viewings as $viewing): ?>
                    <tr>
                        <td><?= htmlspecialchars($viewing['clientNo']) ?></td>
                        <td><?= htmlspecialchars($viewing['propertyNo']) ?></td>
                        <td><?= htmlspecialchars($viewing['viewDate']) ?></td>
                        <td>
                            <select class="status-dropdown" data-id="<?= $viewing['id'] ?>">
                                <option value="Scheduled" <?= ($viewing['comment'] == "Available") ? "selected" : "" ?>>Available</option>
                                <option value="Completed" <?= ($viewing['comment'] == "Occupied") ? "selected" : "" ?>>Occupied</option>
                                <option value="Cancelled" <?= ($viewing['comment'] == "Pending") ? "selected" : "" ?>>Pending</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div id="status-message" class="alert alert-success" style="display: none;">Status updated successfully!</div>
    </div>

    <script>
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                let viewingID = this.dataset.id;
                let newStatus = this.value;

                fetch('update_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `viewingID=${viewingID}&status=${newStatus}`
                })
                .then(response => response.text())
                .then(data => {
                    let messageDiv = document.getElementById('status-message');
                    messageDiv.style.display = 'block';
                    setTimeout(() => messageDiv.style.display = 'none', 2000);
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>
</html>
