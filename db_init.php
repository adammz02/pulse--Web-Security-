<?php
// Path to your SQLite database file
$dbFile = __DIR__ . '/pulse_db.sqlite';

// Open (and create if not exists) the SQLite database
$db = new SQLite3($dbFile);

// Create users table
$db->exec('CREATE TABLE IF NOT EXISTS users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    nric TEXT NOT NULL UNIQUE,
    student_id TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    login_attempts INTEGER DEFAULT 0,
    locked_until TEXT DEFAULT NULL
)');

// Create reports table
$db->exec('CREATE TABLE IF NOT EXISTS reports (
    report_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    subject TEXT NOT NULL,
    type TEXT NOT NULL,
    message TEXT NOT NULL,
    screenshot TEXT DEFAULT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime("now")),
    is_suspicious INTEGER DEFAULT 0
)');

// Insert sample user (only if not exists)
$userCheck = $db->querySingle("SELECT COUNT(*) FROM users WHERE email = 'di220042@student.uthm.edu.my'");
if ($userCheck == 0) {
    $db->exec("INSERT INTO users (user_id, full_name, nric, student_id, email, password, login_attempts, locked_until) VALUES
        (2, 'Aqilah Joharudin', '010101-01-0101', 'DI220042', 'di220042@student.uthm.edu.my', '$2y$10$WyUNmXQnoVLjKT7nkplDlu6VHZzFmCEBHvszFgAzWmXWgqP7C4p6K', 0, NULL)
    ");
}

// Insert sample reports (only if not exists)
$reportCheck = $db->querySingle("SELECT COUNT(*) FROM reports");
if ($reportCheck == 0) {
    $db->exec("INSERT INTO reports (report_id, user_id, subject, type, message, screenshot, created_at, is_suspicious) VALUES
    (1, 2, 'sasa', 'bug', 'eg', NULL, '2025-06-05 15:02:43', 0),
    (2, 2, '%3Cscript%3Ealert(1)%3C/script%3E', 'bug', '%3Cscript%3Ealert(1)%3C/script%3E', NULL, '2025-06-05 15:03:07', 0),
    (3, 2, '&lt;script&gt;alert(&#039;XSS&#039;)&lt;/script&gt;', 'content', '&lt;scr&lt;script&gt;ipt&gt;alert(&#039;XSS&#039;)&lt;/script&gt;', NULL, '2025-06-05 15:08:46', 0),
    (4, 2, '&#039; OR &#039;1&#039;=&#039;1', 'bug', '&#039; OR &#039;1&#039;=&#039;1', NULL, '2025-06-05 15:20:04', 0),
    (5, 2, '&lt;form action=&#039;hack.php&#039;&gt;', 'bug', '&lt;form action=&#039;hack.php&#039;&gt;', NULL, '2025-06-05 15:35:37', 0),
    (6, 2, 'try', 'feedback', 'selamat kot', NULL, '2025-06-05 15:37:49', 0),
    (7, 2, '&lt;form action=&quot;hack.php&quot;&gt;', 'feedback', '&lt;form action=&quot;hack.php&quot;&gt;', NULL, '2025-06-05 15:38:05', 1),
    (8, 2, '&quot; OR 1=1 --', 'content', '&quot; OR 1=1 --', NULL, '2025-06-05 15:38:22', 1)
    ");
}

echo "Database initialized successfully.\n";
?>
