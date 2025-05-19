<?php
session_start();
include 'db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();

    $_SESSION['message'] = "Task deleted successfully!";
}

header("Location: dashboard.php");
exit();
?>
