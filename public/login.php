
<?php 
include_once '../includes/functions.php';
include('../config/db.php');
include('../includes/log_action.php');
?>
<!DOCTYPE html><html><head><meta charset='utf-8'><title>Login</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #dbeeff, #eaf5ff);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    h2 {
    text-align: center;
    color: #1e3a8a;
    font-size: 40px;
    margin-bottom: 25px;
    transition: color 0.3s ease;
    position: absolute;
    top: 50px;
    right: 680px;
}

    form {
  height: 525px;
  width: 500px;
  border-radius: 30px 0px;
  align-content: center;
  justify-items: center;
  justify-self: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    label {
        margin-left: 200px !important;
        width: 100%;
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        display: block;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2px;
    }


    input{
        margin-left: 100px !important;
        padding: 7px 15px;
  margin: 5px;
  font-size: 16px;
  border-radius: 5px;
  width: 250px;
  border-style: hidden;
  box-shadow: 0px 0px 10px 0px #d1d5db;
  color: #858484 !important;
  border: 2px solid #d1d5db;
  transition: all 0.3s ease;
    }

    input:focus {
        border-color: #2563eb;
        outline: none;
    }

    button {
        margin-top: 30px;
         margin-left: 120px !important;
        width: 50%;
        background-color: #2563eb;
        color: white;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 12px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
    }

    p {
    text-align: center;
    color: #1a2d57;
    font-size: 18px;
}

    a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
    position: relative;
    bottom: -180px;
    right: 320px;
}

    a:hover {
        text-decoration: underline;
    }
</style>
</head><body>
<h2>Login</h2>
<div class="login-form">
<form method="POST" action="../includes/auth.php">
    <label>Email:</label> <input type="email" name="email" required><br>
   <label> Password:</label> <input type="password" name="password" required><br>
    <button type="submit" name="login">Login</button>
</form>
</div>
<div class="para-style">
<p><a href="forgot_password.php">Forgot Password?</a></p>
<p><a href="register.php">Create new account</a></p>
</div>
</body></html>