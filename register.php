<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // reCAPTCHA validation
    $recaptchaSecret = '6Ldex2grAAAAAGshWla6mWIS2EKl42ez6vTxkvrk';
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($response);

    if (!$responseData->success) {
        $error = "CAPTCHA verification failed. Please try again.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Username already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow rounded">
                <h3 class="text-center mb-3">Register</h3>
                <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="g-recaptcha mb-3" data-sitekey="6Ldex2grAAAAAD3GLsvmogOkl1-syWL2vy0BsH89"></div>
                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
                <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
