<?php
include_once '../config/db.php';
include_once '../includes/log_action.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/access_denied.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}
$id = intval($_GET['id']);

$update = $conn->prepare("UPDATE users SET blocked=1 WHERE id=?");
$update->bind_param("i", $id);
$update->execute();
$update->close();

logAction($conn, $_SESSION['user_id'] ?? 0, 'Block User', "Blocked user ID: $id");
header("Location: manage_users.php");
exit();
?>