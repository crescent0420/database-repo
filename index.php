<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dream Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Branches</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Branch No</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Postcode</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM Branch");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$row['branchNo']}</td><td>{$row['street']}</td><td>{$row['city']}</td><td>{$row['postcod']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
