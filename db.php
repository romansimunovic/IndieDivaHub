<?php
$server = "localhost";
$korisnik = "root";
$lozinka = "";
$baza = "indie_diva_hub";

try {
    $pdo = new PDO("mysql:host=$server;dbname=$baza;charset=utf8", $korisnik, $lozinka);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Uspješna konekcija!";
} catch (PDOException $e) {
    echo "Greška pri povezivanju: " . $e->getMessage();
}
?>