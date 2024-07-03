<?php
session_start();

require_once 'db_config.php';

mysqli_select_db($conn, 'test');
// Perform the reset operation
$sql = "DELETE FROM transactions"; // This will delete all records from the table
mysqli_query($conn, $sql);

// Reset the auto-increment value
$sql = "ALTER TABLE transactions AUTO_INCREMENT = 1";
mysqli_query($conn, $sql);

// Redirect back to the pcash.php page after resetting
header("Location: index.php");
?>
