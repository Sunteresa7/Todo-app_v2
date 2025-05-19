<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Add new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $due_date = $_POST['due_date'];
        $category = $_POST['category'];
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task, due_date, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $task, $due_date, $category);
        $stmt->execute();
        $_SESSION['message'] = "Task added successfully!";
        header("Location: dashboard.php");
        exit();
    }
}

// Get tasks
$stmt = $conn->prepare("SELECT id, task, due_date, category, created_at FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Your To-Do List</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Success Alert -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <!-- Add Task -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" class="d-flex">
                <input type="text" name="task" class="form-control me-2" placeholder="Enter a new task..." required>
                     <select name="category" class="form-select me-2" required>
                     <option value="Work">Work</option>
                     <option value="Home">Home</option>
                    <option value="Personal">Personal</option>
                    <option value="Other">Other</option>
            </select>
                 <input type="date" name="due_date" class="form-control me-2" required>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>
    </div>

    <!-- Task List -->
    <div class="row">
        <?php while ($task = $result->fetch_assoc()): ?>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <?php
                           $due = $task['due_date'];
                           $now = date("Y-m-d");
                           $reminder = "";
                        if ($due < $now) {
                           $reminder = "<span class='badge bg-danger'>Overdue!</span>";
                           } elseif ($due == $now) {
                          $reminder = "<span class='badge bg-warning text-dark'>Due Today</span>";
                   } else {
             $reminder = "<span class='badge bg-success'>Due: $due</span>";
    }
?>
<p class="mb-1">
    <?= htmlspecialchars($task['task']) ?> <?= $reminder ?>
    <span class="badge bg-info text-dark"><?= htmlspecialchars($task['category']) ?></span>
</p>
<small class="text-muted">Created: <?= $task['created_at'] ?></small>

                    </div>
                    <div>
                        <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
