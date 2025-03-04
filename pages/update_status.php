<?php
include '../config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['viewingID'], $_POST['status'])) {
    $viewingID = $_POST['viewingID'];
    $newStatus = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE viewing SET comment = :status WHERE id = :viewingID");
        $stmt->execute(['status' => $newStatus, 'viewingID' => $viewingID]);
        echo "Success"; // Response for AJAX
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
