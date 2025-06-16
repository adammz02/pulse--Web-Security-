<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spotify Dashboard</title>
    <link rel="stylesheet" href="css/welcome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <header class="navbar">
        <div class="nav-left">
            <img src="logo.svg" alt="Logo" class="logo" />
            <i class="fas fa-home nav-icon"></i>
        </div>
        <div class="nav-center">
            <div class="search-wrapper">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="What do you want to play?" class="search-bar" />
            </div>
        </div>
        <div class="nav-right">
            <a href="#" class="nav-link"><i class="fas fa-download"></i> Install App</a>
            <a href="#" class="nav-link"><i class="fas fa-bell"></i></a>
            <img src="user-avatar.jpg" alt="User" class="profile-img">
        </div>

    </header>

    <!-- Main Dashboard -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <span>Your Library</span>
                <button class="create-btn"><i class="fas fa-plus"></i> Create</button>
            </div>
            <div class="sidebar-tabs">
                <button class="active">Playlists</button>
                <button>Artists</button>
            </div>
            <div class="sidebar-search-row">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search in Your Library">
                <span class="recents">Recents <i class="fas fa-list"></i></span>
            </div>
            <ul class="playlist-list">
                <li class="playlist-item active">
                    <img src="liked-songs.jpg" alt="Liked Songs" class="playlist-icon">
                    <div>
                        <span class="playlist-title">Liked Songs</span>
                        <span class="playlist-meta">Playlist &middot; 25 songs</span>
                    </div>
                </li>
                <li class="playlist-item"><i class="fas fa-music"></i>
                    <div>
                        <span class="playlist-title">JJ 😈</span>
                        <span class="playlist-meta">Playlist &middot; Aqil</span>
                    </div>
                </li>
                <li class="playlist-item"><i class="fas fa-music"></i>
                    <div>
                        <span class="playlist-title">Underground 😜</span>
                        <span class="playlist-meta">Playlist &middot; Aqil</span>
                    </div>
                </li>
                <li class="playlist-item"><i class="fas fa-music"></i>
                    <div>
                        <span class="playlist-title">🐍🐍</span>
                        <span class="playlist-meta">Playlist &middot; Aqil</span>
                    </div>
                </li>
                <li class="playlist-item"><i class="fas fa-music"></i>
                    <div>
                        <span class="playlist-title">Feby putri playlist</span>
                        <span class="playlist-meta">Playlist &middot; nseptune</span>
                    </div>
                </li>
                <li class="playlist-item"><i class="fas fa-music"></i>
                    <div>
                        <span class="playlist-title">Melayu 😅</span>
                        <span class="playlist-meta">Playlist &middot; Aqil</span>
                    </div>
                </li>
            </ul>
        </aside>

        <!-- Main Section -->
        <main class="main-section">
            <!-- Top Row Tabs -->
            <div class="main-top-tabs">
                <button class="active">All</button>
                <button>Music</button>
                <button>Podcasts</button>
            </div>
            <!-- Row of Tagged Playlists -->
            <div class="main-tags-row">
                <div class="main-tag active"><img src="liked-songs.jpg" alt="Liked Songs"> Liked Songs</div>
                <div class="main-tag"><i class="fas fa-music"></i> JJ 😈</div>
                <div class="main-tag"><i class="fas fa-music"></i> Underground 😜</div>
                <div class="main-tag"><i class="fas fa-music"></i> 🐍🐍</div>
                <div class="main-tag"><i class="fas fa-music"></i> Melayu 😅</div>
                <div class="main-tag"><img src="artist-lowkey.jpg" alt="Lowkey" class="tag-img"> lowkey</div>
                <div class="main-tag"><img src="dzy-starterkit.jpg" alt="D’zy Starter Kit" class="tag-img"> D’zy Starter Kit</div>
                <div class="main-tag"><i class="fas fa-music"></i> Feby putri playlist</div>
            </div>
            <!-- Section: Made For Aqil -->
            <div class="made-for-section">
                <div class="made-for-header">
                    <span>Made For</span> <span class="user-name">Aqil</span>
                    <span class="show-all">Show all</span>
                </div>
                <div class="daily-mix-row">
                    <div class="daily-mix-card">
                        <img src="mix1.jpg" alt="Mix 1">
                        <div class="mix-label mix1">Daily Mix 01</div>
                        <div class="mix-desc">Taylor Swift, Ariana Grande, Maroon 5 and...</div>
                    </div>
                    <div class="daily-mix-card">
                        <img src="mix2.jpg" alt="Mix 2">
                        <div class="mix-label mix2">Daily Mix 02</div>
                        <div class="mix-desc">D’zy, Xae Neptune, Nakalness and more</div>
                    </div>
                    <div class="daily-mix-card">
                        <img src="mix3.jpg" alt="Mix 3">
                        <div class="mix-label mix3">Daily Mix 03</div>
                        <div class="mix-desc">ST12, Tulus, NIKI and more</div>
                    </div>
                    <div class="daily-mix-card">
                        <img src="mix4.jpg" alt="Mix 4">
                        <div class="mix-label mix4">Daily Mix 04</div>
                        <div class="mix-desc">Sal Priadi, Nadin Amizah, Payung...</div>
                    </div>
                    <div class="daily-mix-card">
                        <img src="mix5.jpg" alt="Mix 5">
                        <div class="mix-label mix5">Daily Mix 05</div>
                        <div class="mix-desc">Masdo, Hujan, etc.</div>
                    </div>
                </div>
                <div class="made-for-note">
                    Non-stop music based on your favourite songs and artists.
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="rightbar">
            <div class="nowplaying-card">
                <img src="liked-songs-bg.jpg" alt="Liked Songs" class="nowplaying-bg">
                <div class="nowplaying-info">
                    <div class="nowplaying-title">Liked Songs</div>
                    <div class="nowplaying-artist">End of Beginning<br><span>Djo</span></div>
                </div>
            </div>
            <div class="about-artist-card">
                <div class="about-artist-title">About the artist</div>
            </div>
        </aside>
    </div>

    <!-- Player Bar -->
    <footer class="player-bar">
        <div class="player-left">
            <img src="djo.jpg" alt="Playing" class="player-album">
            <div>
                <div class="player-title">End of Beginning</div>
                <div class="player-artist">Djo</div>
            </div>
        </div>
        <div class="player-controls">
            <i class="fas fa-random"></i>
            <i class="fas fa-step-backward"></i>
            <i class="fas fa-play-circle main-play"></i>
            <i class="fas fa-step-forward"></i>
            <i class="fas fa-redo"></i>
        </div>
        <div class="player-progress">
            <span>0:01</span>
            <input type="range" min="0" max="100" value="1">
            <span>2:39</span>
        </div>
    </footer>
</body>

</html>