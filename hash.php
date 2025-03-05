<?php
$password = 'password'; // Replace with the password you want to hash
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo "Hashed Password: " . $hashed_password;
?>
