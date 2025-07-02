<?php
session_start();
require_once 'db.php';
$stmt = $pdo->query("SELECT * FROM umjetnice ORDER BY datum_dodavanja DESC");
$umjetnice = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indie Diva Hub</title>
    <style>
        body {
            background-color: #EEF1E6;
            /* Alabaster - blaga svijetla pozadina */
            color: #333333;
            /* Tamno siva za bolju čitljivost */
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #F9665E;
            /* Pastel Red */
            margin-top: 20px;
        }

        h2 {
            color: #799FCB;
            /* Dark Pastel Blue */
            margin-bottom: 20px;
        }

        a {
            color: #F9665E;
            /* Pastel Red */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .artist-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .artist-card {
            background-color: #95B4CC;
            /* Wild Blue Yonder */
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .artist-card:hover {
            transform: scale(1.05);
        }

        .image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 10px;
        }

        .artist-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .artist-card h3 {
            color: #FEC9C9;
            /* Light Red */
            margin-top: 10px;
        }

        .artist-card p {
            color: #333333;
            /* Tamno siva za bolju čitljivost */
        }

        .btn {
            display: inline-block;
            background-color: #799FCB;
            /* Dark Pastel Blue */
            color: #EEF1E6;
            /* Alabaster */
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #AFC7D0;
            /* Pastel Blue */
        }

        .top-bar {
            margin-bottom: 20px;
        }

        .top-bar p {
            margin: 5px 0;
        }

        .admin-link {
            margin-top: 20px;
            font-weight: bold;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #799FCB;
            /* Dark Pastel Blue */
            padding: 15px 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            color: #EEF1E6;
            /* Alabaster */
            margin: 0;
        }

        header nav {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Razmak između gumbova */
        }

        header nav p {
            margin: 0;
            color: #EEF1E6;
            /* Alabaster */
        }

        header .btn {
            background-color: #F9665E;
            /* Pastel Red */
            color: #EEF1E6;
            /* Alabaster */
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }

        header .btn:hover {
            background-color: #FEC9C9;
            /* Light Red */
        }

        footer {
            background-color: #799FCB;
            /* Pastel Red */
            color: #EEF1E6;
            /* Alabaster */
            padding: 40px 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
        }

        .social-links a {
            color: #EEF1E6;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        .newsletter {
            max-width: 300px;
            margin: 0 auto;
        }

        .newsletter form {
            display: flex;
            justify-content: space-between;
        }

        .newsletter input {
            padding: 8px;
            width: 70%;
            border: none;
            border-radius: 5px;
        }

        .newsletter button {
            padding: 8px 16px;
            margin-left: 15px;
            background-color: #95B4CC;
            /* Dark Pastel Blue */
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .newsletter button:hover {
            background-color: #AFC7D0;
            /* Pastel Blue */
        }

        .footer-bottom {
            background-color: #799FCB;
            /* Dark Pastel Blue */
            padding: 10px;
        }

        .success-message {
            display: none;
            background-color: #F9665E;
            /* Pastel Red */
            color: #EEF1E6;
            /* Alabaster */
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <h1>Indie Diva Hub</h1>
        <nav>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['uloga'] == 'admin'): ?>
                <a href="admin.php" class="btn">Admin Panel</a>
            <?php endif; ?>
            <a href="prijedlozi.php" class="btn">Predloži umjetnicu</a>
            <?php if (isset($_SESSION['user'])): ?>
                <p>Dobrodošli, <?php echo htmlspecialchars($_SESSION['user']['korisnicko_ime']); ?> |
                    <a href="logout.php" class="btn">Odjava</a>
                </p>
            <?php else: ?>
                <a href="login.php" class="btn">Prijavi se</a>
            <?php endif; ?>
        </nav>
    </header>



    <h2>Umjetnice</h2>
    <div class="artist-container">
        <?php foreach ($umjetnice as $artist): ?>
            <div class="artist-card">
                <div class="image-container">
                    <img src="<?php echo htmlspecialchars($artist['slika_url']); ?>"
                        alt="<?php echo htmlspecialchars($artist['ime']); ?>">
                </div>
                <h3><?php echo htmlspecialchars($artist['ime']); ?></h3>
                <p><?php echo substr(htmlspecialchars($artist['biografija']), 0, 100); ?>...</p>
                <a href="umjetnica.php?id=<?php echo $artist['id']; ?>" class="btn">Pogledaj profil</a>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <div class="footer-content">
            <div class="social-links">
                <a href="https://facebook.com" target="_blank" class="social-icon">Facebook</a>
                <a href="https://instagram.com" target="_blank" class="social-icon">Instagram</a>
                <a href="https://twitter.com" target="_blank" class="social-icon">Twitter</a>
            </div>
            <div class="newsletter">
                <h3>Prijavite se na naš newsletter</h3>
                <form id="newsletter-form" action="newsletter_signup.php" method="post"
                    onsubmit="return showSuccessMessage()">
                    <input type="email" name="email" placeholder="Unesite vaš email" required>
                    <button type="submit" id="newsletter-button" class="btn">Prijavite se</button>
                </form>
                <div id="success-message" class="success-message" style="display: none;">
                    Prijavljeni ste na newsletter!
                </div>

            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Indie Diva Hub. Sva prava pridržana.</p>
        </div>
    </footer>



    <script>

        document.getElementById('newsletter-form').addEventListener('submit', function (event) {
            event.preventDefault();
            document.getElementById('success-message').style.display = 'block';
            setTimeout(function () {
                document.getElementById('success-message').style.display = 'none';
            }, 4000);
        });
    </script>


</body>

</html>