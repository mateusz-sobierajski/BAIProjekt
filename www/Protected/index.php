<?php
include 'config.php';
include 'csrf.php';

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
                <form action="edit.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit">Edit</button>
                </form>


                <form action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit">Delete</button>
                </form>


            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
