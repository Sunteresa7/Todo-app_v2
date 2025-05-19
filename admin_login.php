<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "<pre>";
    echo "Entered Username: $username\n";
    echo "Entered Password: $password\n";

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $hashed_password);

    if ($stmt->fetch()) {
        echo "Fetched Hash: $hashed_password\n";
        if (password_verify($password, $hashed_password)) {
            echo "✅ Password matched. Logging in...\n";
            $_SESSION['admin_id'] = $admin_id;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "❌ Password does NOT match!\n";
        }
    } else {
        echo "❌ Admin not found!\n";
    }
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login (Debug)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow rounded">
                <h3 class="text-center mb-3">Admin Login</h3>
                <form method="POST">
                    <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
