<?php
//Checks if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>