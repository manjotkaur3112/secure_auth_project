<?php
include_once '../config/db.php';
include_once '../includes/log_action.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/access_denied.php");
    exit();
}

if (isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = in_array($_POST['role'], ['admin','user']) ? $_POST['role'] : 'user';

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        logAction($conn, $_SESSION['user_id'] ?? 0, 'Add User', "Admin added user: $email");
        echo "<script>alert('User added successfully!');window.location='manage_users.php';</script>";
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add User</title></head>
<body>
<h2>Add New User</h2>
<form method="post">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Role:
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <button type="submit" name="add_user">Add User</button>
</form>
<p><a href="manage_users.php">Back to list</a></p>
</body>
</html>
