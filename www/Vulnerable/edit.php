<?php
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id";
    if ($conn->multi_query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
    Name: <input type="text" name="name" value="<?= $user['name'] ?>" required><br>
    Email: <input type="text" name="email" value="<?= $user['email'] ?>" required><br>
    <input type="submit" value="Update">
</form>
</body>
</html>

