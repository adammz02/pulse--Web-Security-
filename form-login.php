<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database connection (SQLite)
$dbFile = __DIR__ . '/pulse_db.sqlite';
$conn = new SQLite3($dbFile);

// Helper function
function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

// reCAPTCHA secret key
$recaptcha_secret = '6Ld6p2IrAAAAAN7lzFbjlT81KgiPyz2cN0xdg8-5';
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha_response)) {
    $_SESSION['error'] = "Please complete the CAPTCHA.";
    header("Location: login.php");
    exit;
}

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
$captcha = json_decode($verify);

if (!$captcha->success) {
    $_SESSION['error'] = "CAPTCHA verification failed. Please try again.";
    header("Location: login.php");
    exit;
}

$student_id = strtoupper(sanitize($_POST['id']));
$password = $_POST['password'];

if (!preg_match('/^DI\d{6}$/', $student_id) || intval(substr($student_id, 2, 2)) <= 20) {
    $_SESSION['error'] = "Invalid credentials. Try again.";
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = :student_id");
$stmt->bindValue(':student_id', $student_id, SQLITE3_TEXT);
$result = $stmt->execute();

$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user) {
    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
        $_SESSION['error'] = "Account locked. Please try again at " . date("H:i", strtotime($user['locked_until'])) . " Malaysia Time (GMT+8).";
        header("Location: login.php");
        exit;
    }

    if (password_verify($password, $user['password'])) {
        // Reset login attempts and lockout
        $reset = $conn->prepare("UPDATE users SET login_attempts = 0, locked_until = NULL WHERE user_id = :user_id");
        $reset->bindValue(':user_id', $user['user_id'], SQLITE3_INTEGER);
        $reset->execute();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: index.php");
        exit;
    } else {
        $attempts = $user['login_attempts'] + 1;
        if ($attempts >= 3) {
            $lockout_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));
            $update = $conn->prepare("UPDATE users SET login_attempts = :attempts, locked_until = :locked_until WHERE user_id = :user_id");
            $update->bindValue(':attempts', $attempts, SQLITE3_INTEGER);
            $update->bindValue(':locked_until', $lockout_time, SQLITE3_TEXT);
            $update->bindValue(':user_id', $user['user_id'], SQLITE3_INTEGER);
            $_SESSION['error'] = "Account locked due to multiple failed attempts. Try again in 5 minutes.";
        } else {
            $update = $conn->prepare("UPDATE users SET login_attempts = :attempts WHERE user_id = :user_id");
            $update->bindValue(':attempts', $attempts, SQLITE3_INTEGER);
            $update->bindValue(':user_id', $user['user_id'], SQLITE3_INTEGER);
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
