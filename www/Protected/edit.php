<?php
include 'config.php';
include 'csrf.php';

// Validate 'id' to ensure it's an integer
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Use a prepared statement to fetch the user safely
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);  // 'i' indicates the parameter is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($user)) {

    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed!");
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    // Use prepared statement to update the user
    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
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
    <title>Edit User</title>
</head>
<body>
<h2>Edit User</h2>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    <input type="submit" value="Update">
</form>
</body>
</html>


