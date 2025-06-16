<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "pulse_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Canonicalization Helper ---
function canonicalize($input) {
    return trim($input);
}

// --- Validation Helper ---
function isValidIssueType($type) {
    $valid = ['bug', 'content', 'feedback', 'other'];
    return in_array($type, $valid);
}

// --- Sanitization Helper (for display) ---
function sanitizeForHTML($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// --- Suspicious Input Detector ---
function containsSuspiciousInput($text) {
    $patterns = [
        // Script injection
        "/<script.*?>.*?<\/script>/is",

        // SQL keywords (basic SQL injection)
        "/\b(select|insert|update|delete|drop|union|--)\b/i",

        // Logic-based SQL injection
        "/('|\")\s*or\s*('|\")?\d+\s*=\s*\d+/i",

        // Inline JS events and URLs
        "/onerror\s*=|onload\s*=|onclick\s*=|onmouseover\s*=|javascript:/i",

        // HTML injection: form, iframe, embed, object
        "/<form.*?>/i",
        "/<iframe.*?>/i",
        "/<embed.*?>/i",
        "/<object.*?>/i",

        // Image-based XSS
        "/<img.*?src=['\"]?javascript:.*?>/i",

        // Unusual tags or malformed tags
        "/<.*?on[a-z]+=['\"].*?['\"]>/i",
        "/<\/?[a-z]+\s+[^>]*>/i",

        // Common attack characters/patterns (basic heuristic)
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


// --- Canonicalize all inputs ---
$subject = canonicalize($_POST['subject'] ?? '');
$type = canonicalize($_POST['type'] ?? '');
$message = canonicalize($_POST['message'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;

// --- Validate login ---
if (!$user_id) {
    $_SESSION['error'] = "Login required to submit a report.";
    header("Location: login.php");
    exit;
}

// --- Validate required fields ---
if ($subject === '' || $type === '' || $message === '') {
    $_SESSION['error'] = "All fields are required.";
    header("Location: report.php");
    exit;
}

// --- Validate issue type ---
if (!isValidIssueType($type)) {
    $_SESSION['error'] = "Invalid issue type selected.";
    header("Location: report.php");
    exit;
}

// --- Sanitize inputs for storage/output ---
$subjectSafe = sanitizeForHTML($subject);
$typeSafe = sanitizeForHTML($type);
$messageSafe = sanitizeForHTML($message);

// --- Handle screenshot upload ---
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

// --- Suspicious Input Check ---
$isSuspicious = containsSuspiciousInput($subject) || containsSuspiciousInput($message);

$isSuspiciousFlag = $isSuspicious ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO reports (user_id, subject, type, message, screenshot, created_at, is_suspicious) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("issssi", $user_id, $subjectSafe, $typeSafe, $messageSafe, $screenshotPath, $isSuspiciousFlag);

if ($stmt->execute()) {
    if (!$isSuspicious) {
        $_SESSION['success'] = "Report submitted successfully.";
    }
} else {
    $_SESSION['error'] = "Something went wrong. Try again.";
}

$stmt->close();
$conn->close();
header("Location: report.php");
exit;
