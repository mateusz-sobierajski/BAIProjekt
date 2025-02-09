<?php
include 'config.php';
include 'csrf.php';
include 'rate_limiter.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed!");
    }

    $rateLimiter = new RateLimiter(2, 3600); // 100 requests per hour
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!$rateLimiter->isAllowed($ip)) {
        die("Too many requests. Please try again later.");
}

    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);

    if ($stmt->execute() === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
<h2>Add New User</h2>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    <input type="submit" value="Add">
</form>
</body>
</html>