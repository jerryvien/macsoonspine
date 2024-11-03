<?php
// database.php

// Database configuration
$host = 'localhost'; // Use 'localhost' for a local database
$dbName = 'u821069140_macsoon2024'; // Database name
$username = 'u821069140_macsoon'; // Database username
$password = '$1Rv1r@dmInS'; // Database password

// Create a new PDO instance for the connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Connection success message (for testing purposes)
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); // Error message if connection fails
}
