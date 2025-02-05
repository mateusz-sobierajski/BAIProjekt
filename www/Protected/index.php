<?php
include 'config.php';

// Fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Protected CRUD Website</title>
</head>
<body>
<h2>Users List</h2>
<a href="add.php">Add New User</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
