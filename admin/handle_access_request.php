<?php
include_once '../config/db.php';

include_once '../includes/functions.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: access_denied.php?reason=Admin%20Area');
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "Invalid request.";
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];

if ($action == 'accept') {
    $stmt = $conn->prepare("UPDATE access_requests SET status='accepted', updated_at=NOW() WHERE id=?");
} elseif ($action == 'decline') {
    $stmt = $conn->prepare("UPDATE access_requests SET status='declined', updated_at=NOW() WHERE id=?");
} else {
    echo "Invalid action.";
    exit();
}

$stmt->bind_param("i", $id);
$stmt->execute();
echo "<script>alert('Request updated successfully!');window.location='access_requests.php';</script>";
?>
