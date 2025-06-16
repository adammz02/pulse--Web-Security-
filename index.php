<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['full_name'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Pulse</title>
    <link rel="icon" href="logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <header class="navbar">
        <div class="nav-left">
            <img src="logo.svg" alt="Logo" class="logo" />
            <i class="fas fa-home nav-icon"></i>
            <?php if ($isLoggedIn): ?>
                <span class="welcome-text">Welcome, <?= htmlspecialchars($userName) ?>!</span>
            <?php endif; ?>
        </div>

        <div class="nav-center">
            <div class="search-wrapper">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="What do you want to play?" class="search-bar" />
            </div>
        </div>
        <div class="nav-right">
            <?php if ($isLoggedIn): ?>
                <div class="user-dropdown">
                    <i class="fas fa-user-circle user-icon"></i>
                    <div class="dropdown-menu">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="login-btn">Log In</a>
            <?php endif; ?>
        </div>

    </header>

    <main class="main-container">
        <div class="left-panel">
            <div class="panel-inner">
                <h3>Your Library <span class="plus">+</span></h3>

                <div class="library-card">
                    <h4>Explore your music taste</h4>
                    <p>Tailored just for you</p>
                    <a href="browse.php" class="library-button">Start now</a>
                </div>

                <div class="library-card">
                    <h4>Let’s find some podcasts to follow</h4>
                    <p>We’ll keep you updated on new episodes</p>
                    <a href="browse.php" class="library-button">Browse podcasts</a>
                </div>

                <div class="report-link">
                    <a href="#">Safety & Privacy Center&nbsp;</a>
                    <a href="#">&nbsp;Cookies&nbsp;</a>
                    <a href="#">&nbsp;About ads&nbsp;</a>
                    <a href="#">&nbsp;Legal&nbsp;</a>
                    <a href="#">&nbsp;Accessibility&nbsp;</a>
                    <a href="report.php">&nbsp;Report a problem&nbsp;</a>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="panel-inner">
                <h2>Trending Songs</h2>
                <div class="song-grid">
                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/svt.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">THUNDER</p>
                        <p class="song-artist">SEVENTEEN</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/mangu.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">Mangu</p>
                        <p class="song-artist">Fourtwnty, Charita Utami</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/lowkey.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">lowkey</p>
                        <p class="song-artist">lucidrari, Heil Nuan</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/sombr.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">back to friends</p>
                        <p class="song-artist">sombr</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/inteam.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">Kasih Kekasih</p>
                        <p class="song-artist">In-Team</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/jj.png" alt="Album">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                            <p class="song-title">Kasih Aba Aba</p>
                            <p class="song-artist">Naykilla, Tenxi, Jemsii</p>
                        </div>
                    </div>
                </div>

                <br>

                <h2>Popular Artist</h2>
                <div class="song-grid">
                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/jennie.png" alt="Artist" class="circle-img">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">JENNIE</p>
                        <p class="song-artist">Artist</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/weeknd.png" alt="Artist" class="circle-img">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">The Weeknd</p>
                        <p class="song-artist">Artist</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/yungkai.png" alt="Artist" class="circle-img">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">yung kai</p>
                        <p class="song-artist">Artist</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/coldplay.png" alt="Artist" class="circle-img">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">Coldplay</p>
                        <p class="song-artist">Artist</p>
                    </div>

                    <div class="song-card">
                        <div class="img-container">
                            <img src="img/kendrick.png" alt="Artist" class="circle-img">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <p class="song-title">Kendrick Lamar</p>
                        <p class="song-artist">Artist</p>
                    </div>

                </div>
            </div>
    </main>


</body>

</html>