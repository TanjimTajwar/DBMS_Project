<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobra Movies</title>
    <link rel="stylesheet" href="HomePage.css">
</head>
<body>
    <header class="navbar">
        <div class="logo"><a href="HomePage.php">Jobra Movies</a></div>
        <nav>
            <ul>
                <li><a href="HomePage.php">HOME</a></li>
                <li><a href="Showtimes.html">SHOWTIMES</a></li>
                <li><a href="buy.html">Ticket Price</a></li>
                <li><a href="CommingSoon.html">Comming Soon</a></li>
                <li><a href="AboutUss.html">About Us</a></li>
                <?php if ($isLoggedIn): ?>
                    <?php if ($isAdmin): ?>
                        <li><a href="admin_dashboard.php">Admin</a></li>
                    <?php else: ?>
                        <li><a href="user_dashboard.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                    <?php endif; ?>
                    <?php else: ?>
                        <li><a href="Account.php"></a></li>
                    <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div>
        <img id="pushpaImg" src="pushpa.png" alt="pushpa">
    </div>
    <section class="hero">
        <div class="hero-content">
            <h1>Trending: Pushpa</h1>
            <div class="actions">
                <button>
                    <a href="showtimes.html">SHOWTIME</a>
                </button>
                <button>
                    <a href="buy.html">Buy Ticket</a>
                </button>
            </div>
        </div>
    </section>

    <section class="movie-gallery">
        <h2>More to See</h2>
        <div class="movies">
            <div class="movie">
                <img src="Vaikunthapurramuloo.png" alt="Vaikunthapurramuloo">
                <p>Vaikunthapurramuloo</p>
            </div>
            <div class="movie">
                <img src="Loki.png" alt="Loki">
                <p>Loki</p>
            </div>
            <div class="movie">
                <img src="Jailer.png" alt="Jailer">
                <p>Jailer</p>
            </div>
            <div class="movie">
                <img src="Good-Newwz.png" alt="Good Newwz">
                <p>Good Newwz</p>
            </div>
        </div>
    </section>
</body>
</html>
