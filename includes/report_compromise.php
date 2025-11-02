<?php
include_once 'functions.php';
if (!isset($_SESSION['user_id'])) { echo 'Login required'; exit(); }
$user_id = $_SESSION['user_id'];
$reason = isset($_POST['reason']) ? sanitize($_POST['reason']) : 'User reported compromise';
$stmt = $conn->prepare("INSERT INTO compromise_reports (user_id,report_reason) VALUES (?,?)");
$stmt->bind_param("is", $user_id, $reason);
$stmt->execute();
$report_id = $stmt->insert_id;
$ev = 'compromise_reported';
$details = 'report_id:'.$report_id.',user_id:'.$user_id;
$conn->prepare("INSERT INTO audit_logs (user_id,event,details) VALUES (?,?,?)")->bind_param("iss", $user_id, $ev, $details)->execute();
mail('admin@example.com','Compromise report #'.$report_id,"User $user_id reported account compromise. Reason: $reason");
echo 'Report submitted.';
?>