<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $loginRequired = true;
} else {
    $loginRequired = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.svg" type="image/x-icon">
    <title>Pulse | Browse</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="css/browse.css">
</head>

<body>
    <div class="<?= $loginRequired ? 'blurred-page' : '' ?>">
        <header class="navbar">
            <div class="nav-left">
                <img src="logo.svg" alt="Logo" class="logo" />
                <i class="fas fa-home nav-icon"></i>
            </div>
            <div class="nav-center">
                <div class="search-wrapper">
                    <input type="text" placeholder="What do you want to play?" class="search-bar" />
                    <i class="fa-solid fa-search" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="user-dropdown">
                <i class="fas fa-user-circle user-icon"></i>
                <div class="dropdown-menu">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </header>
        <aside>
            <div class="logo"><i class="fas fa-circle-notch"></i> pulse</div>

            <div class="sidebar-section">
                <nav>
                    <a href="index.php"><i class="fas fa-compass"></i> Discover</a>
                    <a href="#" class="active"><i class="fas fa-stream"></i> Browse</a>
                    <a href="#"><i class="fas fa-chart-line"></i> Charts</a>
                    <a href="#"><i class="fas fa-user"></i> Artist</a>
                    <a href="#"><i class="fas fa-search"></i> Search</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h4>Your collection</h4>
                <nav>
                    <a href="#"><i class="fas fa-music"></i> Tracks <span style="margin-left:auto;">8</span></a>
                    <a href="#"><i class="fas fa-list"></i> Playlists</a>
                    <a href="#"><i class="fas fa-heart"></i> Likes</a>
                </nav>
            </div>
        </aside>

        <main>
            <div class="browse-header">
                <h1>Browse</h1>
                <select>
                    <option>All</option>
                </select>
            </div>
            <div class="albums">
                <div class="album"><img src="img/lauv.jpg">
                    <h4>Mean It</h4>
                    <p>Lauv, LANY</p>
                </div>
                <div class="album"><img src="img/rayuan.jpg">
                    <h4>Rayuan Perempuan Gila</h4>
                    <p>Nadin Amizah</p>
                </div>
                <div class="album"><img src="img/serana.jpg">
                    <h4>Serana</h4>
                    <p>For Revenge</p>
                </div>
                <div class="album"><img src="img/omi.png">
                    <h4>Cheerleader</h4>
                    <p>OMI, Felix Jaehn</p>
                </div>
                <div class="album"><img src="img/pasilyo.png">
                    <h4>Pasilyo</h4>
                    <p>SunKissed Lola</p>
                </div>
                <div class="album"><img src="img/poison.png">
                    <h4>Poison</h4>
                    <p>Rita Ora</p>
                </div>
                <div class="album"><img src="img/lowkey.png">
                    <h4>lowkey</h4>
                    <p>lucidrari, Heil Nuan</p>
                </div>
                <div class="album"><img src="img/sombr.png">
                    <h4>back to friends</h4>
                    <p>sombr</p>
                </div>
            </div>
        </main>

        <div class="right-bar">
            <div class="track-preview">
                <img src="img/mangu.png" alt="Mangu Cover">
                <h3>Mangu</h3>
                <p>Fourtwnty, Charita Utami</p>
                <div class="track-icons">
                    <i class="fas fa-share-alt"></i>
                    <i class="fas fa-plus-circle"></i>
                </div>
            </div>

            <div class="credits-box">
                <div class="credits-header">
                    <span>Credits</span>
                    <a href="#">Show all</a>
                </div>
                <div class="artist-credit">
                    <span>Fourtwnty</span>
                    <button class="follow-btn">Follow</button>
                </div>
            </div>
        </div>


        <div class="footer">
            <div class="footer-main">
                <div><strong>Mangu</strong> - Fourtwnty, Charita Utami</div>

                <div class="footer-controls">
                    <i class="fas fa-random"></i>
                    <i class="fas fa-step-backward"></i>
                    <i class="fas fa-play play-btn"></i>
                    <i class="fas fa-step-forward"></i>
                    <i class="fas fa-redo"></i>
                </div>

                <div>01:37 / 04:21 <i class="fas fa-volume-up"></i></div>
            </div>

            <div class="report-link">
                <a href="#">Safety & Privacy Center</a>
                <a href="#">Cookies</a>
                <a href="#">About ads</a>
                <a href="#">Legal</a>
                <a href="#">Accessibility</a>
                <a href="report.php">Report a problem</a>
            </div>
        </div>
    </div>

    <?php if ($loginRequired): ?>
    <div class="login-overlay">
      <div class="login-modal">
        <button class="close-btn" onclick="window.location.href='index.php';">&times;</button>
        <h2>Login Required</h2>
        <p>You must be logged in to access this page.</p>
        <a href="login.php" class="login-redirect-btn">Log In Now</a>
      </div>
    </div>
  <?php endif; ?>
</body>

<script>
    document.querySelector('.user-icon').addEventListener('click', function() {
        const menu = document.querySelector('.dropdown-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    // Optional: Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const menu = document.querySelector('.dropdown-menu');
        const icon = document.querySelector('.user-icon');
        if (!icon.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
</script>


</html>