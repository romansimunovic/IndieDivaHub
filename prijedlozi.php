<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

$message = '';
$messageClass = 'success-message';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime_umjetnice = trim($_POST['ime_umjetnice']);
    $opis = trim($_POST['opis']);
    $kontakt = trim($_POST['kontakt']);
    $slika_url = trim($_POST['slika_url']);
    
    $poslao_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

    if (empty($ime_umjetnice) || empty($slika_url)) {
        $message = "Ime umjetnice i URL slike su obavezni!";
        $messageClass = 'error-msg';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO prijedlozi (ime_umjetnice, opis, kontakt, slika_url, status, poslao_id)
                VALUES (:ime_umjetnice, :opis, :kontakt, :slika_url, 'pending', :poslao_id)
            ");
            $stmt->execute([
                ':ime_umjetnice' => $ime_umjetnice,
                ':opis'         => $opis,
                ':kontakt'      => $kontakt,
                ':slika_url'    => $slika_url,
                ':poslao_id'    => $poslao_id
            ]);
            $message = "Vaš prijedlog je uspješno poslan!";
            $messageClass = 'success-message';
        } catch (PDOException $e) {
            $message = "Došlo je do greške: " . $e->getMessage();
            $messageClass = 'error-msg';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Predloži umjetnicu</title>
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
            <a href="login.php" class="btn">Prijava</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <h2>Predloži novu umjetnicu</h2>

    <?php if (!empty($message)): ?>
        <p class="<?= $messageClass ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="ime_umjetnice">Ime umjetnice:</label>
        <input type="text" name="ime_umjetnice" id="ime_umjetnice" required>

        <label for="opis">Opis:</label>
        <textarea name="opis" id="opis" rows="4"></textarea>

        <label for="kontakt">Kontakt:</label>
        <input type="text" name="kontakt" id="kontakt">

        <label for="slika_url">URL slike:</label>
        <input type="url" name="slika_url" id="slika_url" required>

        <button type="submit" class="btn">Pošalji prijedlog</button>
    </form>

    <p style="margin-top: 20px;"><a href="index.php" class="btn">Nazad na početnu</a></p>
</main>

<footer>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Indie Diva Hub. Sva prava pridržana.</p>
    </div>
</footer>

</body>
</html>
