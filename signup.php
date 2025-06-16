<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/logo.png" type="image/x-icon">
  <title>pulse | Sign Up</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/register.css">
</head>

<body>
  <div class="login-container">
    <button class="close-btn" onclick="window.location.href='index.php';">&times;</button>
    <h1>WELCOME TO PULSE</h1>
    <h4>Sign up student plan, for free.</h4>

    <!-- Error Message -->
    <?php if (isset($_SESSION['error'])): ?>
      <div class="form-error"><?= $_SESSION['error'];
                              unset($_SESSION['error']); ?></div>
    <?php endif; ?>


    <div class="social-login">
      <div class="row">
        <button>
          <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="icon">
          Apple
        </button>
        <button>
          <img src="https://img.icons8.com/color/20/google-logo.png" alt="Google">
          Google
        </button>
      </div>
    </div>

    <div class="divider">or</div>

    <form action="form-register.php" method="POST">
      <input type="text" name="name" placeholder="Full Name"
        value="<?= isset($_SESSION['form_values']['name']) ? htmlspecialchars($_SESSION['form_values']['name']) : '' ?>" required>

      <input type="text" name="nric" placeholder="User ID (NRIC)"
        value="<?= isset($_SESSION['form_values']['nric']) ? htmlspecialchars($_SESSION['form_values']['nric']) : '' ?>" required>

      <input type="text" name="id" placeholder="ID Number (Matric Number)"
        value="<?= isset($_SESSION['form_values']['id']) ? htmlspecialchars($_SESSION['form_values']['id']) : '' ?>" required>

      <input type="email" name="email" placeholder="Email"
        value="<?= isset($_SESSION['form_values']['email']) ? htmlspecialchars($_SESSION['form_values']['email']) : '' ?>" required>

      <input type="password" name="password" placeholder="Password (at least 8 characters)" required>
      <button type="submit">Sign Up For Free</button>
    </form>

    <?php unset($_SESSION['form_values']); ?>

    <div class="signup">
      Already have an account? <a href="login.php">Log in</a>
    </div>
  </div>
</body>

<script>
  document.querySelector('input[name="nric"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '').slice(0, 12);
    if (value.length >= 6) value = value.slice(0, 6) + '-' + value.slice(6);
    if (value.length >= 9) value = value.slice(0, 9) + '-' + value.slice(9);
    e.target.value = value;
  });

  const idInput = document.querySelector('input[name="id"]');
  idInput.addEventListener('input', function () {
    this.value = this.value.toUpperCase();
  });
</script>

</html>