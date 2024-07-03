<?php
// db_config.php

// Replace these variables with your actual database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
