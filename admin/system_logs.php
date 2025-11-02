<?php
// include '../config/db.php';
// include '../includes/session_check.php';

// if ($_SESSION['role'] !== 'admin') {
//     header('Location: ../public/access_denied.php');
//     exit();
// }

// echo "<h2>Audit Logs</h2>";

// $query = "SELECT * FROM audit_logs ORDER BY created_at DESC";
// $result = mysqli_query($conn, $query);

// if (mysqli_num_rows($result) > 0) {
//     echo "<table border='1' cellpadding='8'>
//             <tr>
//                 <th>ID</th>
//                 <th>User ID</th>
//                 <th>Event</th>
//                 <th>Details</th>
//                 <th>Created At</th>
//             </tr>";
//     while ($row = mysqli_fetch_assoc($result)) {
//         echo "<tr>
//                 <td>{$row['id']}</td>
//                 <td>{$row['user_id']}</td>
//                 <td>{$row['event']}</td>
//                 <td>{$row['details']}</td>
//                 <td>{$row['created_at']}</td>
//             </tr>";
//     }
//     echo "</table>";
// } else {
//     echo "<p>No logs found.</p>";
// }
?>

<?php
include('../config/db.php');

$result = mysqli_query($conn, "SELECT * FROM audit_logs ORDER BY created_at DESC");

echo "<h2>Audit Logs</h2>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5'>
            <tr><th>User ID</th><th>Event</th><th>Details</th><th>Time</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['event']}</td>
                <td>{$row['details']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No logs found.";
}
?>
