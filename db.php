<?php
// Connection settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mini_cms_api";

// 1. Connect to MySQL server (without specifying database yet)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Automatically create the database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// 3. Select the database to use
$conn->select_db($dbname);

// 4. Automatically create the Users table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)");

// 5. Automatically create the Posts table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    content TEXT,
    tags VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

// Note: We DO NOT close the connection here ($conn->close()) 
// because api.php needs this open connection to run your queries!
?>