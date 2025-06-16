<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pulse_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

$full_name = sanitize($_POST['name']);
$nric = sanitize($_POST['nric']);
$student_id = strtoupper(sanitize($_POST['id']));
$email = sanitize($_POST['email']);
$password = $_POST['password'];

if (!preg_match("/^[a-zA-Z\s'-]+$/", $full_name)) {
    $_SESSION['error'] = "Name can only contain letters, spaces, hyphens, and apostrophes.";
    $_SESSION['form_values'] = [
        'name' => $full_name,
        'nric' => $nric,
        'id' => $student_id,
        'email' => $email
    ];
    header("Location: signup.php");
    exit;
}

// Validate NRIC format: XXXXXX-XX-XXXX
if (!preg_match('/^\d{6}-\d{2}-\d{4}$/', $nric)) {
    $_SESSION['error'] = "Invalid NRIC format. Use XXXXXX-XX-XXXX.";
    header("Location: signup.php");
    exit;
}

// Validate student ID format: DIXXXXXX and must be DI21XXXX or above
if (!preg_match('/^DI\d{6}$/', $student_id)) {
    $_SESSION['error'] = "Invalid ID format. Use DI followed by 6 digits.";
    header("Location: signup.php");
    exit;
}
$year_enrolled = intval(substr($student_id, 2, 2));
if ($year_enrolled <= 20) {
    $_SESSION['error'] = "Registration blocked. ID Number DI20XXXX and below are not allowed.";
    header("Location: signup.php");
    exit;
}

// Validate password strength
if (
    strlen($password) < 8 ||
    !preg_match('/[A-Z]/', $password) ||
    !preg_match('/[a-z]/', $password) ||
    !preg_match('/[0-9]/', $password) ||
    !preg_match('/[\W_]/', $password)
) {
    $_SESSION['error'] = "Password must be at least 8 characters, with uppercase, lowercase, number, and symbol.";
    $_SESSION['form_values'] = [
        'name' => $full_name,
        'nric' => $nric,
        'id' => $student_id,
        'email' => $email
    ];
    header("Location: signup.php");
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: signup.php");
    exit;
}

// Check for duplicates
// Check for duplicates
$check = $conn->prepare("SELECT * FROM users WHERE email = ? OR student_id = ? OR nric = ?");
$check->bind_param("sss", $email, $student_id, $nric);
$check->execute();
$result = $check->get_result();
if ($result->num_rows > 0) {
    $_SESSION['error'] = "An account with the provided information already exists";
    // DO NOT set $_SESSION['form_values'] here — clears the fields
    header("Location: signup.php");
    exit;
}


// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO users (full_name, nric, student_id, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $full_name, $nric, $student_id, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] = "Account created successfully. Please log in.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: signup.php");
    exit;
}
