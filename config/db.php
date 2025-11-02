<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "operating_system";

$conn = mysqli_connect($host, $user, $pass, $dbname);
// if (!$conn) die("Database connection failed: " . mysqli_connect_error());
?>

<?php
// $conn = new mysqli("localhost", "root", "", "operating_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
