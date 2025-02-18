<?php
// Include the database connection
require 'C:\xampp\htdocs\MediSync\php\php\db_connction.php';

// Query to retrieve all users
$query = "SELECT username, password_hash FROM users";
$result = $con->query($query);

if ($result->num_rows > 0) {
    echo "<h2>Stored Users:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row['username'] . " | Password Hash: " . $row['password_hash'] . "<br>";
    }
} else {
    echo "No users found in the database.";
}
?>
