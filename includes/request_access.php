<?php
include_once 'functions.php';
if (!isset($_SESSION['user_id'])) { echo 'Login required'; exit(); }
$page = isset($_POST['page']) ? sanitize($_POST['page']) : 'unknown';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO access_requests (user_id,page,status) VALUES (?,?,'pending')");
$stmt->bind_param("is", $user_id, $page);
$stmt->execute();
echo 'Request submitted.';
?>