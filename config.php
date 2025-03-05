<?php
$host = 'localhost';
$dbname = 'dream_home';  // Ensure this is the correct database name
$username = 'root';
$password = 'password';

// Create MySQLi connection with explicit authentication method
$conn = new mysqli($host, $username, $password, $dbname, null, '/var/run/mysqld/mysqld.sock');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure MySQLi uses mysql_native_password
$conn->query("SET SESSION old_passwords=0");

// Create a PDO instance with mysql_native_password authentication
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION old_passwords=0"
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>
