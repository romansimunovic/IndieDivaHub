<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
    $umjetnica_id = intval($_POST['umjetnica_id']);
    $ocjena = intval($_POST['ocjena']);
    $komentar = trim($_POST['komentar']);
    $korisnik_id = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("INSERT INTO recenzije (korisnik_id, umjetnica_id, album_id, ocjena, komentar) VALUES (:korisnik_id, :umjetnica_id, NULL, :ocjena, :komentar)");
    $stmt->execute([
        ':korisnik_id' => $korisnik_id,
        ':umjetnica_id' => $umjetnica_id,
        ':ocjena' => $ocjena,
        ':komentar' => $komentar
    ]);
}
header("Location: umjetnica.php?id=".$umjetnica_id);
exit;
?>
