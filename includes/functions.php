<?php
// session_start();

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '../vendor/autoload.php';
// include_once '../config/db.php';
// include_once '../includes/functions.php';
// include_once '../includes/log_action.php';

// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
//     $first_name = trim($_POST['first_name']);
//     $last_name = trim($_POST['last_name']);
//     $email = trim($_POST['email']);
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//     // ✅ Check if email already exists
//     $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
//     $check->bind_param("s", $email);
//     $check->execute();
//     $check->store_result();
//     if ($check->num_rows > 0) {
//         echo "<script>alert('Email already registered. Please login instead.'); window.location.href='../public/login.php';</script>";
//         exit();
//     }
//     $check->close();

//     // ✅ Save registration data temporarily in session
//     $_SESSION['first_name'] = $first_name;
//     $_SESSION['last_name'] = $last_name;
//     $_SESSION['email'] = $email;
//     $_SESSION['password'] = $password;

//     // ✅ Generate OTP
//     $otp = rand(100000, 999999);
//     $_SESSION['otp'] = $otp;
//     $_SESSION['otp_expiry'] = time() + 300; // valid for 5 min

//     // ✅ Send OTP using PHPMailer
//     $mail = new PHPMailer(true);
//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'manjot.kaur0226@gmail.com'; // ✅ your Gmail
//         $mail->Password = 'zylkhfxikabbxwhv';   // ✅ Gmail App Password
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         $mail->setFrom('manjot.kaur0226@gmail.com', 'Secure Auth System');
//         $mail->addAddress($email);
//         $mail->isHTML(true);
//         $mail->Subject = 'Your OTP Code';
//         $mail->Body = "<h3>Your OTP is <b>$otp</b></h3><p>Valid for 5 minutes only.</p>";

//         $mail->send();

//         log_action($conn, 0, "Registration OTP Sent", "OTP sent to $email");

//         echo "<script>alert('OTP sent successfully to $email'); window.location.href='../public/verify_otp.php';</script>";
//     } catch (Exception $e) {
//         echo "<script>alert('Failed to send OTP. {$mail->ErrorInfo}'); window.location.href='../public/register.php';</script>";
//     }
// }
?>


<?php
include_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer support

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ------------------ SECURITY HELPERS ------------------ */

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function isStrongPassword($password) {
    // Min 8 chars, at least 1 lowercase, 1 uppercase, 1 digit, 1 special char
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

/* ------------------ OTP GENERATOR ------------------ */
if (!function_exists('generateOTP')) {
    function generateOTP($length = 6) {
        // Create a 6-digit random number
        return strval(rand(pow(10, $length - 1), pow(10, $length) - 1));
    }
}

/* ------------------ EMAIL SENDER (PHPMailer) ------------------ */
function sendEmailOTP($to, $otp, $subject = "OTP Verification") {
    if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        echo "<p style='color:red;'>❌ PHPMailer not found. Check composer autoload.</p>";
        return false;
    }

    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'manjot.kaur0226@gmail.com';
        $mail->Password = 'zylkhfxikabbxwhv'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & recipient
        $mail->setFrom('manjot.kaur0226@gmail.com', 'Secure Authentication System');
        $mail->addAddress($to);

        // Email body
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>🔐 Email Verification</h3>
            <p>Your One-Time Password (OTP) is:</p>
            <h2 style='color:#0078D4;'>$otp</h2>
            <p>This OTP is valid for 10 minutes.</p>
        ";

        $mail->send();
        echo "<p style='color:green;'>✅ OTP sent successfully to {$to}</p>";
        return true;
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Mailer Error: {$mail->ErrorInfo}</p>";
        return false;
    }
}
?>
