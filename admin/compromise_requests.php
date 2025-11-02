<?php
include_once '../config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/access_denied.php');
    exit();
}

$result = $conn->query("SELECT id, user_id, report_reason AS description, status, created_at FROM compromise_reports");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Compromise Reports</title>
    <style>
        body { font-family: Arial; }
        .message {
            width: 60%;
            margin: 20px auto;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        a.button {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
        }
        .approve { background-color: green; }
        .reject { background-color: red; }
    </style>
</head>
<body>
<h2 style="text-align:center;">Compromise Reports</h2>

<?php if (isset($_GET['msg'])): ?>
    <div class="message success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="message error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Description</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['description']}</td>
            <td>{$row['status']}</td>
            <td>{$row['created_at']}</td>
            <td>
                <a href='view_report.php?id=" . $row['id'] . "' class='button' style='background-color:blue;'>View</a>
                <a href='handle_compromise.php?id=" . $row['id'] . "&action=approve' class='button approve'>Approve</a>
                <a href='handle_compromise.php?id=" . $row['id'] . "&action=reject' class='button reject'>Reject</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No reports found.</td></tr>";
}
?>

</table>

</body>
</html>


<?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; text-align:center; border-radius: 5px;">
        ✅ Action recorded successfully.
    </div>
<?php endif; ?>
