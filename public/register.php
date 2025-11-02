<?php 
include_once '../includes/functions.php';
include('../config/db.php'); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>

<form method="POST" action="../includes/auth.php" onsubmit="return validatePassword();">
    <label>Username:</label> 
    <input type="text" name="username" required><br>

    <label>Email:</label> 
    <input type="email" name="email" required><br>

    <label>Password:</label> 
    <input type="password" id="password" name="password" required><br>

    <label>Confirm Password:</label> 
    <input type="password" id="confirm_password" required><br>

    <label>Role:</label>
    <select name="role">
        <option value="user" selected>User</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit" name="register">Register</button>
</form>

<p>Already registered? <a href="login.php">Login</a></p>

<script>
function validatePassword() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!pattern.test(password)) {
        alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
        return false;
    }

    if (password !== confirm) {
        alert('Passwords do not match!');
        return false;
    }

    return true;
}
</script>
</body>
</html>
