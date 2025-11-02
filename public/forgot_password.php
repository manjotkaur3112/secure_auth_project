<?php include_once '../includes/functions.php'; ?>
<!DOCTYPE html><html><head><meta charset='utf-8'><title>Forgot Password</title></head><body>
<h2>Forgot Password</h2>
<form method="POST" action="../includes/auth.php">
    Email: <input type="email" name="email" required><br>
    <button type="submit" name="forgot_password">Send OTP</button>
</form>
<p><a href="login.php">Back to login</a></p>
</body></html>