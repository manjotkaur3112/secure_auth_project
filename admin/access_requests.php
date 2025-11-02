<?php
include_once '../config/db.php';

include_once '../includes/functions.php';
include_once '../includes/session_check.php';
if ($_SESSION['role'] !== 'admin') { header('Location: ../public/access_denied.php'); exit(); }

$res = $conn->query("SELECT r.id, r.user_id, u.username, r.page, r.status, r.created_at FROM access_requests r JOIN users u ON r.user_id=u.id WHERE r.status='pending' ORDER BY r.created_at DESC");
?>
<!DOCTYPE html><html><head><meta charset='utf-8'><title>Access Requests</title></head><body>
<h2>Access Requests</h2>
<?php while ($row = $res->fetch_assoc()) { ?>
  <div>
    User: <?php echo htmlspecialchars($row['username']); ?> requests <?php echo htmlspecialchars($row['page']); ?>
    <a href="handle_access_request.php?id=<?php echo $row['id']; ?>&action=accept&minutes=30">Accept (30m)</a>
    <a href="handle_access_request.php?id=<?php echo $row['id']; ?>&action=decline">Decline</a>
  </div>
<?php } ?>
</body></html>