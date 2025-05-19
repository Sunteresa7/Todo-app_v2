<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("Location: admin_login.php");
    exit();
}

$user_id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>
