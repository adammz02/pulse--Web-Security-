<?php
session_start();

$dbFile = __DIR__ . '/pulse_db.sqlite';
$conn = new SQLite3($dbFile);

function canonicalize($input) {
    return trim($input);
}
function isValidIssueType($type) {
    $valid = ['bug', 'content', 'feedback', 'other'];
    return in_array($type, $valid);
}
function sanitizeForHTML($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
function containsSuspiciousInput($text) {
    $patterns = [
        "/<script.*?>.*?<\/script>/is",
        "/\b(select|insert|update|delete|drop|union|--)\b/i",
        "/('|\")\s*or\s*('|\")?\d+\s*=\s*\d+/i",
        "/onerror\s*=|onload\s*=|onclick\s*=|onmouseover\s*=|javascript:/i",
        "/<form.*?>/i",
        "/<iframe.*?>/i",
        "/<embed.*?>/i",
        "/<object.*?>/i",
        "/<img.*?src=['\"]?javascript:.*?>/i",
        "/<.*?on[a-z]+=['\"].*?['\"]>/i",
        "/<\/?[a-z]+\s+[^>]*>/i",
        "/[<>{}]/",
        "/[\[\]();]/"
    ];
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $text)) {
            return true;
        }
    }
    return false;
}

$subject = canonicalize($_POST['subject'] ?? '');
$type = canonicalize($_POST['type'] ?? '');
$message = canonicalize($_POST['message'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    $_SESSION['error'] = "Login required to submit a report.";
    header("Location: login.php");
    exit;
}

if ($subject === '' || $type === '' || $message === '') {
    $_SESSION['error'] = "All fields are required.";
    header("Location: report.php");
    exit;
}
if (!isValidIssueType($type)) {
    $_SESSION['error'] = "Invalid issue type selected.";
    header("Location: report.php");
    exit;
}

$subjectSafe = sanitizeForHTML($subject);
$typeSafe = sanitizeForHTML($type);
$messageSafe = sanitizeForHTML($message);

$screenshotPath = null;
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['screenshot']['tmp_name'];
    $fileName = basename($_FILES['screenshot']['name']);
    $fileSize = $_FILES['screenshot']['size'];
    $fileType = mime_content_type($fileTmp);

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['error'] = "Only JPG, PNG, and GIF files are allowed.";
        header("Location: report.php");
        exit;
    }
    if ($fileSize > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Screenshot must be under 2MB.";
        header("Location: report.php");
        exit;
    }

    $uploadDir = "uploads/reports/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $safeName = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", pathinfo($fileName, PATHINFO_FILENAME));
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $newFileName = uniqid("screenshot_") . "_" . $safeName . "." . $extension;
    $screenshotPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmp, $screenshotPath)) {
        $_SESSION['error'] = "Failed to upload screenshot.";
        header("Location: report.php");
        exit;
    }
}

$isSuspicious = containsSuspiciousInput($subject) || containsSuspiciousInput($message);
$isSuspiciousFlag = $isSuspicious ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO reports (user_id, subject, type, message, screenshot, created_at, is_suspicious)
    VALUES (:user_id, :subject, :type, :message, :screenshot, :created_at, :is_suspicious)");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->bindValue(':subject', $subjectSafe, SQLITE3_TEXT);
$stmt->bindValue(':type', $typeSafe, SQLITE3_TEXT);
$stmt->bindValue(':message', $messageSafe, SQLITE3_TEXT);
$stmt->bindValue(':screenshot', $screenshotPath, SQLITE3_TEXT);
$stmt->bindValue(':created_at', date('Y-m-d H:i:s'), SQLITE3_TEXT);
$stmt->bindValue(':is_suspicious', $isSuspiciousFlag, SQLITE3_INTEGER);

if ($stmt->execute()) {
    if (!$isSuspicious) {
        $_SESSION['success'] = "Report submitted successfully.";
    }
} else {
    $_SESSION['error'] = "Something went wrong. Try again.";
}
header("Location: report.php");
exit;
?>
