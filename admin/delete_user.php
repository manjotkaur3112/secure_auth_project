<?php
include_once '../config/db.php';
include_once '../includes/log_action.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/access_denied.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$id = intval($_GET['id']);

// Prepare and execute with proper error handling
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Log the delete action
    logAction($conn, $_SESSION['user_id'] ?? 0, 'Delete User', "Deleted user ID: $id");
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error preparing delete statement: " . $conn->error;
}
?>

<?php
// include_once '../config/db.php';
// include_once '../includes/log_action.php';

// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: ../public/access_denied.php');
//     exit();
// }

// if (!isset($_GET['id'])) {
//     echo "Invalid request.";
//     exit();
// }

// $id = intval($_GET['id']);

// // Confirm logAction is available
// if (!function_exists('logAction')) {
//     die("logAction() not found — check log_action.php include path!");
// }

// $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
// if ($stmt) {
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $stmt->close();

//     // Log the delete action
//     // logAction($conn, $_SESSION['user_id'] ?? 0, 'Delete User', "Deleted user ID: $id");
//     log_action('Add User', "Admin added user: $email");

//     header("Location: manage_users.php");
//     exit();
// } else {
//     echo "Error preparing delete statement: " . $conn->error;
// }
?>
