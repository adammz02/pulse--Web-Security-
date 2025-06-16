<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.svg" type="image/x-icon">
    <title>pulse | Log In</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <?php
        session_start();
        if (isset($_SESSION['success'])) {
            echo "<div class='form-success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
        ?>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='form-error'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        ?>

        <button class="close-btn" onclick="window.location.href='index.php';">&times;</button>
        <h1>LOG IN TO PULSE</h1>
        <!---<div class="social-login">
            <button><img src="https://img.icons8.com/color/20/facebook-new.png" alt="Facebook"> Continue with Facebook</button>
            <div class="row">
            <button class="social-btn apple">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple logo" class="icon" />Apple
            </button>
                <button><img src="https://img.icons8.com/color/20/google-logo.png" alt="Google"> Google</button>
            </div>
        </div>
        <div class="divider">or</div>--->
        <form action="form-login.php" method="POST">
            <input type="text" name="id" placeholder="ID Number (Matric Number)" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log In</button>
            <div class="g-recaptcha" data-sitekey="6LemrF8rAAAAAG4iGcvf7VlUB5LSOcmHHEfWKp2s"></div>

        </form>
        <a href="#" class="forgot-password">Forgot password?</a>
        <div class="signup">
            Don’t have an account yet? <a href="signup.php">Sign up here</a>
        </div>
    </div>
</body>

<script>
    const idInput = document.querySelector('input[name="id"]');
    idInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>

</html>