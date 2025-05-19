<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'];

// Get task details
$stmt = $conn->prepare("SELECT task, due_date, category FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$stmt->bind_result($task, $due_date, $category);
$stmt->fetch();
$stmt->close();



// Update task
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_task = trim($_POST['task']);
    $new_due = $_POST['due_date'];
    $new_category = $_POST['category'];

    $update = $conn->prepare("UPDATE tasks SET task = ?, due_date = ?, category = ? WHERE id = ? AND user_id = ?");
    $update->bind_param("sssii", $new_task, $new_due, $new_category, $task_id, $user_id);

    $update->execute();

    $_SESSION['message'] = "Task updated successfully!";
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h4>Edit Task</h4>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="task" class="form-control mb-3" value="<?= htmlspecialchars($task) ?>" required>

<select name="category" class="form-select mb-3" required>
    <option value="Work" <?= $category == 'Work' ? 'selected' : '' ?>>Work</option>
    <option value="Home" <?= $category == 'Home' ? 'selected' : '' ?>>Home</option>
    <option value="Personal" <?= $category == 'Personal' ? 'selected' : '' ?>>Personal</option>
    <option value="Other" <?= $category == 'Other' ? 'selected' : '' ?>>Other</option>
</select>

<input type="date" name="due_date" class="form-control mb-3" value="<?= $due_date ?>" required>

                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="dashboard.php" class="btn btn-secondary ms-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
