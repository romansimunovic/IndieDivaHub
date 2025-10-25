<?php
session_start();
require_once 'db.php';

// Samo admin korisnik može pristupiti
if (!isset($_SESSION['user']) || $_SESSION['user']['uloga'] !== 'admin') {
    die("Pristup odbijen.");
}

if (isset($_GET['action'], $_GET['id'])) {
    $action = $_GET['action']; // 'approve' ili 'reject'
    $prijedlog_id = intval($_GET['id']);

    // Dohvati prijedlog
    $stmt = $pdo->prepare("SELECT * FROM prijedlozi WHERE id = :id");
    $stmt->execute([':id' => $prijedlog_id]);
    $prijedlog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prijedlog) {
        $_SESSION['error'] = "Prijedlog nije pronađen.";
        header("Location: admin.php");
        exit;
    }

    if ($action === 'approve') {
        // Dodaj u tablicu umjetnice
        $insertStmt = $pdo->prepare("
            INSERT INTO umjetnice (ime, biografija, kontakt, slika_url)
            VALUES (:ime, :biografija, :kontakt, :slika_url)
        ");
        $insertStmt->execute([
            ':ime' => $prijedlog['ime_umjetnice'],
            ':biografija' => $prijedlog['opis'],
            ':kontakt' => $prijedlog['kontakt'],
            ':slika_url' => $prijedlog['slika_url'] ?? null
        ]);

        // Ažuriraj status prijedloga
        $updateStmt = $pdo->prepare("UPDATE prijedlozi SET status = 'approved' WHERE id = :id");
        $updateStmt->execute([':id' => $prijedlog_id]);

        $_SESSION['message'] = "Prijedlog odobren. Umjetnica dodana.";
    } elseif ($action === 'reject') {
        // Odbij prijedlog
        $updateStmt = $pdo->prepare("UPDATE prijedlozi SET status = 'rejected' WHERE id = :id");
        $updateStmt->execute([':id' => $prijedlog_id]);

        $_SESSION['message'] = "Prijedlog je odbijen.";
    } else {
        $_SESSION['error'] = "Nepoznata akcija.";
    }

    header("Location: admin.php");
    exit;
} else {
    $_SESSION['error'] = "Nedostaju parametri.";
    header("Location: admin.php");
    exit;
}
