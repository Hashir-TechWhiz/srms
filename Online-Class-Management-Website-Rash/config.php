<?php
$hostname = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'srms'; 

// Create a new PDO instance
try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}