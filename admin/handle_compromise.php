<?php
include_once '../config/db.php';
session_start();

// Check admin login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/access_denied.php');
    exit();
}

// Validate input
if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "Invalid report";
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];
$admin_id = $_SESSION['user_id']; // make sure you store admin id in session

if ($action === 'approve') {
    $status = 'Approved';
} elseif ($action === 'reject') {
    $status = 'Rejected';
} else {
    echo "Invalid action";
    exit();
}

// Update report status
$stmt = $conn->prepare("UPDATE compromise_reports SET status = ?, updated_at = NOW() WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    // Add to audit_logs
    $log_action = "Admin ID $admin_id $status report ID $id";
    $log_stmt = $conn->prepare("INSERT INTO audit_logs (admin_id, action) VALUES (?, ?)");
    $log_stmt->bind_param("is", $admin_id, $log_action);
    $log_stmt->execute();

    header('Location: compromise_requests.php?msg=success');
    exit();
} else {
    echo "Failed to update report.";
}
?>
