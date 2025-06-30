<?php
$host = 'todo-db.c90koim8kxpr.ap-southeast-1.rds.amazonaws.com';
$user = 'admin';
$pass = 'your_secure_password123';
$dbname = 'todo_db';

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
