<?php
// Uključi prikaz grešaka (samo tijekom razvoja)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

$message = '';

// Ovdje nema provjere da li je korisnik admin – svi posjetitelji mogu pristupiti
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Čišćenje podataka iz forme
    $ime_umjetnice = trim($_POST['ime_umjetnice']);
    $opis = trim($_POST['opis']);
    $kontakt = trim($_POST['kontakt']);
    $slika_url = trim($_POST['slika_url']);
    
    // Ako je korisnik prijavljen, pohrani njegov ID, inače postavi null
    $poslao_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

    // Validacija obaveznih polja (ime umjetnice i slika su obavezni)
    if (empty($ime_umjetnice) || empty($slika_url)) {
        $message = "Ime umjetnice i URL slike su obavezni!";
    } else {
        try {
            // Umetanje podataka u tablicu 'prijedlozi'
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
        } catch (PDOException $e) {
            $message = "Došlo je do greške: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Predloži umjetnicu</title>
</head>
<body>
    <h1>Predloži umjetnicu</h1>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="ime_umjetnice">Ime umjetnice:</label><br>
        <input type="text" name="ime_umjetnice" id="ime_umjetnice" required><br><br>
        
        <label for="opis">Opis:</label><br>
        <textarea name="opis" id="opis"></textarea><br><br>
        
        <label for="kontakt">Kontakt:</label><br>
        <input type="text" name="kontakt" id="kontakt"><br><br>
        
        <label for="slika_url">URL slike:</label><br>
        <input type="text" name="slika_url" id="slika_url" required><br><br>
        
        <button type="submit">Pošalji prijedlog</button>
    </form>
</body>
</html>
