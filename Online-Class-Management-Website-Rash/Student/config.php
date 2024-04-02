<?php
$hostname = 'localhost'; // Change this if your database is hosted on a different server
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password
$database = 'srms'; // Change this to the name of your database

// Create a new PDO instance
try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}