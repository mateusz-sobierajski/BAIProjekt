<?php
include 'config.php';
include 'csrf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed!");
    }


    // Validate and sanitize the id to ensure it is an integer
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0) {
        // Prepare the DELETE statement with a placeholder for the id
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);  // 'i' means the parameter is an integer

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid user ID.";
    }
} else {
    die("Invalid request!");
}
?>