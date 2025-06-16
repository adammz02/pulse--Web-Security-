<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $loginRequired = true;
} else {
    $loginRequired = false;
}

$successMessage = $_SESSION['success'] ?? null;
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="logo.svg" type="image/x-icon">
    <title>Report a Problem</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="css/report.css" />
</head>

<body>
    <div class="<?= $loginRequired ? 'blurred-page' : '' ?>">
        <?php if ($successMessage): ?>
            <div class="alert success">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert error">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <div class="report-container">
            <button class="close-btn" onclick="window.location.href='browse.php';">&times;</button>
            <h2>🪲&nbsp; Spot an Issue?</h2>

            <form action="submit-report.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter a short title" required />
                </div>

                <div class="form-group">
                    <label for="type">Type of Issue</label>
                    <select id="type" name="type" required>
                        <option value="">Select issue type</option>
                        <option value="bug">Bug</option>
                        <option value="content">Inappropriate Content</option>
                        <option value="feedback">General Feedback</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Describe the issue in detail..."
                        required></textarea>
                </div>

                <div class="form-group">
                    <label for="screenshot">Attach a screenshot (optional)</label>
                    <input type="file" id="screenshot" name="screenshot" accept="image/*" />
                </div>

                <button type="submit" class="submit-btn">Submit Report</button>
            </form>
        </div>
    </div>
    <?php if ($loginRequired): ?>
        <div class="login-overlay">
            <div class="login-modal">
                <h2>Login Required</h2>
                <p>You must be logged in to report a problem.</p>
                <a href="login.php" class="login-redirect-btn">Log In Now</a>
            </div>
        </div>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>

</body>

</html>