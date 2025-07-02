<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

// Provjera da li je korisnik admin
if (!isset($_SESSION['user']) || $_SESSION['user']['uloga'] !== 'admin') {
    die("Pristup odbijen.");
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action']; // 'approve' ili 'reject'
    $prijedlog_id = $_GET['id'];

    // Dohvati podatke prijedloga
    $stmt = $pdo->prepare("SELECT * FROM prijedlozi WHERE id = :id");
    $stmt->execute([':id' => $prijedlog_id]);
    $prijedlog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prijedlog) {
        $_SESSION['error'] = "Prijedlog nije pronađen.";
        header("Location: admin_prijedlozi.php");
        exit();
    }

    if ($action === 'approve') {
        // Umetni podatke iz prijedloga u tablicu umjetnice
        $insertStmt = $pdo->prepare("
            INSERT INTO umjetnice (ime, biografija, kontakt, slika_url)
            VALUES (:ime, :biografija, :kontakt, :slika_url)
        ");
        $insertStmt->execute([
            ':ime'        => $prijedlog['ime_umjetnice'],
            ':biografija' => $prijedlog['opis'],
            ':kontakt'    => $prijedlog['kontakt'],
            ':slika_url'  => isset($prijedlog['slika_url']) ? $prijedlog['slika_url'] : null
        ]);

        // Ažuriraj status prijedloga na 'approved'
        $updateStmt = $pdo->prepare("UPDATE prijedlozi SET status = 'approved' WHERE id = :id");
        $updateStmt->execute([':id' => $prijedlog_id]);

        $_SESSION['message'] = "Prijedlog je odobren i umjetnica je dodana.";
    } elseif ($action === 'reject') {
        // Ažuriraj status prijedloga na 'rejected'
        $updateStmt = $pdo->prepare("UPDATE prijedlozi SET status = 'rejected' WHERE id = :id");
        $updateStmt->execute([':id' => $prijedlog_id]);

        $_SESSION['message'] = "Prijedlog je odbijen.";
    } else {
        $_SESSION['error'] = "Nepoznata akcija.";
    }

    // Privremeno komentiraj redak preusmjeravanja dok debuggiraš
    // header("Location: admin_prijedlozi.php");
    // exit();

    echo "Akcija izvršena. Provjeri bazu podataka i/ili sesijske poruke.";
}
?>
