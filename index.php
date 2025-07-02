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
    <link rel="stylesheet" href="style.css?v=2">
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
            <span>Dobrodošli, <strong><?= htmlspecialchars($_SESSION['user']['korisnicko_ime']) ?></strong></span>
            <a href="logout.php" class="btn">Odjava</a>
        <?php else: ?>
            <a href="login.php" class="btn">Prijavi se</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <h2>Umjetnice</h2>
    <section class="artist-grid">
        <?php foreach ($umjetnice as $artist): ?>
            <article class="artist-card">
                <div class="image-wrapper">
                    <img src="<?= htmlspecialchars($artist['slika_url']) ?>" alt="<?= htmlspecialchars($artist['ime']) ?>">
                </div>
                <h3><?= htmlspecialchars($artist['ime']) ?></h3>
                <p><?= substr(htmlspecialchars($artist['biografija']), 0, 100) ?>...</p>
                <a href="umjetnica.php?id=<?= $artist['id'] ?>" class="btn">Pogledaj profil</a>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<footer>
    <div class="footer-content">
        <div class="social-links">
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
        </div>
        <div class="newsletter">
            <h3>Prijavite se na newsletter</h3>
            <form id="newsletter-form" action="newsletter_signup.php" method="post">
                <input type="email" name="email" placeholder="Unesite vaš email" required>
                <button type="submit" class="btn">Prijava</button>
            </form>
            <div id="success-message" class="success-message" style="display: none;">
                Uspješno ste prijavljeni!
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Indie Diva Hub. Sva prava pridržana.</p>
    </div>
</footer>

<script>
    const form = document.getElementById('newsletter-form');
    const message = document.getElementById('success-message');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        message.style.display = 'block';
        setTimeout(() => message.style.display = 'none', 4000);
    });
</script>

</body>
</html>
