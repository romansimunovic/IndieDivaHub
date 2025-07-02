<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$artist_id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM umjetnice WHERE id = :id");
$stmt->execute([':id' => $artist_id]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$artist) {
    die("Umjetnica nije pronađena.");
}

$stmtAlbums = $pdo->prepare("SELECT * FROM albumi WHERE umjetnica_id = :id");
$stmtAlbums->execute([':id' => $artist_id]);
$albums = $stmtAlbums->fetchAll(PDO::FETCH_ASSOC);

$stmtReviews = $pdo->prepare("
    SELECT r.*, k.korisnicko_ime 
    FROM recenzije r 
    LEFT JOIN korisnici k ON r.korisnik_id = k.id 
    WHERE r.umjetnica_id = :id OR r.album_id IN (SELECT id FROM albumi WHERE umjetnica_id = :id)
");
$stmtReviews->execute([':id' => $artist_id]);
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($artist['ime']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Indie Diva Hub</h1>
    <nav>
        <a href="index.php" class="btn">Početna</a>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Dobrodošli, <?= htmlspecialchars($_SESSION['user']['korisnicko_ime']) ?> |
                <a href="logout.php" class="btn">Odjava</a></p>
        <?php else: ?>
            <a href="login.php" class="btn">Prijavi se</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <section class="artist-profile">
        <img src="<?= htmlspecialchars($artist['slika_url']) ?>" alt="<?= htmlspecialchars($artist['ime']) ?>" class="profile-image">
        <h1><?= htmlspecialchars($artist['ime']) ?></h1>
        <p><?= nl2br(htmlspecialchars($artist['biografija'])) ?></p>
    </section>

    <section>
        <h2>Diskografija</h2>
        <?php if ($albums): ?>
            <ul>
                <?php foreach ($albums as $album): ?>
                    <li>
                        <?= htmlspecialchars($album['naslov']) ?> (<?= $album['godina_izdanja'] ?>) -
                        <a href="<?= htmlspecialchars($album['genius_url']) ?>" target="_blank">Genius</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nema albuma.</p>
        <?php endif; ?>
    </section>

    <section class="reviews-container">
        <h2>Recenzije</h2>
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <strong><?= htmlspecialchars($review['korisnicko_ime']) ?></strong> ocjena: <?= $review['ocjena'] ?><br>
                    <p class="comment"><?= nl2br(htmlspecialchars($review['komentar'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nema recenzija.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Ostavi recenziju</h2>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="form-container">
                <form method="post" action="dodaj_recenziju.php" class="review-form">
                    <input type="hidden" name="umjetnica_id" value="<?= $artist['id'] ?>">
                    <label>Ocjena (1-5):</label>
                    <input type="number" name="ocjena" min="1" max="5" required>
                    <label>Komentar:</label>
                    <textarea name="komentar" required></textarea>
                    <input type="submit" value="Pošalji recenziju">
                </form>
            </div>
        <?php else: ?>
            <p><a href="login.php">Prijavite se</a> da ostavite recenziju.</p>
        <?php endif; ?>
    </section>

    <p style="text-align: center; margin-top: 20px;">
        <a href="index.php" class="btn">Nazad na početnu</a>
    </p>
</main>

<footer>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Indie Diva Hub. Sva prava pridržana.</p>
    </div>
</footer>

</body>
</html>
