<?php
include_once '../config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/access_denied.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid report ID.";
    exit();
}

$id = intval($_GET['id']);

// Update action (when admin submits form)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $note = $_POST['admin_note'];

    $stmt = $conn->prepare("UPDATE compromise_reports SET status=?, admin_note=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $note, $id);

    if ($stmt->execute()) {
        $msg = "✅ Report updated successfully!";
    } else {
        $msg = "❌ Error updating report.";
    }
    $stmt->close();
}

// Fetch report details
$stmt = $conn->prepare("SELECT cr.id, cr.user_id, u.username, u.email, cr.report_reason, cr.status, cr.admin_note, cr.created_at 
                        FROM compromise_reports cr
                        JOIN users u ON cr.user_id = u.id
                        WHERE cr.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No report found.";
    exit();
}

$report = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Compromise Report</title>
    <style>
        body { font-family: Arial; background-color: #f7f7f7; }
        .container {
            width: 60%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        td:first-child { font-weight: bold; width: 35%; }
        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        .btn:hover { background-color: #0056b3; }
        .form-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        label { font-weight: bold; display: block; margin-top: 10px; }
        select, textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        .success { color: green; font-weight: bold; text-align: center; }
        .error { color: red; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Compromise Report Details</h2>

    <?php if (isset($msg)) echo "<p class='".(strpos($msg, '✅') !== false ? 'success' : 'error')."'>$msg</p>"; ?>

    <table>
        <tr><td>Report ID</td><td><?= htmlspecialchars($report['id']) ?></td></tr>
        <tr><td>User ID</td><td><?= htmlspecialchars($report['user_id']) ?></td></tr>
        <tr><td>Username</td><td><?= htmlspecialchars($report['username']) ?></td></tr>
        <tr><td>Email</td><td><?= htmlspecialchars($report['email']) ?></td></tr>
        <tr><td>Reason</td><td><?= htmlspecialchars($report['report_reason']) ?></td></tr>
        <tr><td>Status</td><td><?= htmlspecialchars($report['status']) ?></td></tr>
        <tr><td>Admin Note</td><td><?= htmlspecialchars($report['admin_note'] ?? 'N/A') ?></td></tr>
        <tr><td>Created At</td><td><?= htmlspecialchars($report['created_at']) ?></td></tr>
    </table>

    <div class="form-section">
        <form method="POST">
            <label for="status">Update Status:</label>
            <select name="status" id="status" required>
                <option value="Pending" <?= $report['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Reviewed" <?= $report['status'] == 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                <option value="Resolved" <?= $report['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>

            <label for="admin_note">Admin Note:</label>
            <textarea name="admin_note" id="admin_note" rows="4" placeholder="Enter note here..."><?= htmlspecialchars($report['admin_note']) ?></textarea>

            <button type="submit" class="btn">💾 Save Changes</button>
        </form>
    </div>

    <a href="compromise_requests.php" class="btn">⬅ Back to Reports</a>
</div>
</body>
</html>
