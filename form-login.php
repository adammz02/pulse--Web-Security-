<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database connection
$conn = new mysqli("localhost", "root", "", "pulse_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function
function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

// reCAPTCHA secret key
$recaptcha_secret = '6LemrF8rAAAAAK5VQ5ArGZRIac_OE7wXIl7Nqx_y';
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

// Check if CAPTCHA is completed
if (empty($recaptcha_response)) {
    $_SESSION['error'] = "Please complete the CAPTCHA.";
    header("Location: login.php");
    exit;
}

// Verify CAPTCHA with Google
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
$captcha = json_decode($verify);

if (!$captcha->success) {
    $_SESSION['error'] = "CAPTCHA verification failed. Please try again.";
    header("Location: login.php");
    exit;
}

// Process login
$student_id = strtoupper(sanitize($_POST['id']));
$password = $_POST['password'];

// Validate student ID format
if (!preg_match('/^DI\d{6}$/', $student_id) || intval(substr($student_id, 2, 2)) <= 20) {
    $_SESSION['error'] = "Invalid credentials. Try again.";
    header("Location: login.php");
    exit;
}

// Query user
$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Check for account lock
    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
        $_SESSION['error'] = "Account locked. Please try again at " . date("H:i", strtotime($user['locked_until'])) . " Malaysia Time (GMT+8).";
        header("Location: login.php");
        exit;
    }

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Success: reset login attempts and lock
        $reset = $conn->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL WHERE user_id = ?");
        $reset->bind_param("i", $user['user_id']);
        $reset->execute();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: index.php");
        exit;
    } else {
        // Wrong password: update login attempts
        $attempts = $user['login_attempts'] + 1;
        if ($attempts >= 3) {
            $lockout_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));
            $update = $conn->prepare("UPDATE users SET login_attempts = ?, locked_until = ? WHERE user_id = ?");
            $update->bind_param("isi", $attempts, $lockout_time, $user['user_id']);
            $_SESSION['error'] = "Account locked due to multiple failed attempts. Try again in 5 minutes.";
        } else {
            $update = $conn->prepare("UPDATE users SET login_attempts = ? WHERE user_id = ?");
            $update->bind_param("ii", $attempts, $user['user_id']);
            $_SESSION['error'] = "Invalid ID or password.";
        }
        $update->execute();
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid ID or password.";
    header("Location: login.php");
    exit;
}
?>
