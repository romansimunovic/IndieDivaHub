<?php
session_start();
require_once 'db.php';

// Samo POST i prijavljeni korisnici
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $umjetnica_id = intval($_POST['umjetnica_id']);
    $ocjena = intval($_POST['ocjena']);
    $komentar = trim($_POST['komentar']);
    $korisnik_id = $_SESSION['user']['id'];

    // Validacija ocjene
    if ($ocjena < 1 || $ocjena > 5) {
        $_SESSION['error'] = "Ocjena mora biti između 1 i 5.";
        header("Location: umjetnica.php?id=" . $umjetnica_id);
        exit;
    }

    // Ubacivanje u bazu
    $stmt = $pdo->prepare("
        INSERT INTO recenzije (korisnik_id, umjetnica_id, album_id, ocjena, komentar)
        VALUES (:korisnik_id, :umjetnica_id, NULL, :ocjena, :komentar)
    ");
    $stmt->execute([
        ':korisnik_id' => $korisnik_id,
        ':umjetnica_id' => $umjetnica_id,
        ':ocjena' => $ocjena,
        ':komentar' => $komentar
    ]);

    $_SESSION['message'] = "Recenzija je uspješno dodana!";
}

header("Location: umjetnica.php?id=" . $umjetnica_id);
exit;
