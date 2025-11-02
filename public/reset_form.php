<?php include_once '../includes/functions.php'; 
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header('Location: forgot_password.php'); exit();
}
?>
<!DOCTYPE html><html><head><meta charset='utf-8'><title>Reset Password</title></head><body>
<h2>Reset Password</h2>
<form method="POST" action="../includes/auth.php">
    <input type="password" name="new_password" placeholder="New password" required><br>
    <button type="submit" name="reset_password">Reset Password</button>
</form>
</body></html>