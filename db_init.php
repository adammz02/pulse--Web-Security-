<?php
// Run this ONCE to create your SQLite database and tables!
$dbFile = __DIR__ . '/pulse_db.sqlite';
$db = new SQLite3($dbFile);

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    nric TEXT NOT NULL UNIQUE,
    student_id TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    login_attempts INTEGER DEFAULT 0,
    locked_until TEXT DEFAULT NULL
)");

// Create reports table
$db->exec("CREATE TABLE IF NOT EXISTS reports (
    report_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    subject TEXT NOT NULL,
    type TEXT NOT NULL,
    message TEXT NOT NULL,
    screenshot TEXT,
    created_at TEXT NOT NULL,
    is_suspicious INTEGER DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)");

echo "Database and tables created (if not already existing).";
?>
