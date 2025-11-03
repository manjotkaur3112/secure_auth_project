<?php
include_once '../config/db.php';
include_once '../includes/log_action.php';
// session_start();

// Simple admin check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/access_denied.php");
    exit();
}

$result = mysqli_query($conn, "SELECT id, username, email, role, blocked FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Users</title>
<style>
button { margin: 4px; padding: 6px 10px; }
table { border-collapse: collapse; width: 100%; }
th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
</style>
</head>
<body>
<h2>Manage Users</h2>
<a href="add_user.php"><button>Add New User</button></a>
<table>
<tr>
<th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
</tr>
<?php if($result): ?>
<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['username']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['role']) ?></td>
<td><?= $row['blocked'] ? 'Blocked' : 'Active' ?></td>
<td>
    <?php if(!$row['blocked']): ?>
        <a href="block_user.php?id=<?= $row['id'] ?>"><button>Block</button></a>
    <?php else: ?>
        <a href="unblock_user.php?id=<?= $row['id'] ?>"><button>Unblock</button></a>
    <?php endif; ?>
    <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')"><button>Delete</button></a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6">No users found.</td></tr>
<?php endif; ?>
</table>
<p><a href="view_logs.php">View Audit Logs</a></p>
</body>
</html>
