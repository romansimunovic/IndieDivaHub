<?php
session_start();
require_once 'db.php';

$message = '';
$messageClass = 'error-msg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $korisnicko_ime = trim($_POST['username']);
    $lozinka = trim($_POST['password']);
    $potvrda_lozinke = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if ($lozinka !== $potvrda_lozinke) {
        $message = "Lozinke se ne podudaraju.";
    } else {
        // Provjera korisničkog imena
        $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
        $stmt->execute([':username' => $korisnicko_ime]);
        if ($stmt->fetch()) {
            $message = "Korisničko ime već postoji.";
        } else {
            // Provjera emaila
            $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                $message = "Email adresa već postoji.";
            } else {
                // Hash lozinke
                $hashed_password = password_hash($lozinka, PASSWORD_DEFAULT);

                // Unos u bazu
                $stmt = $pdo->prepare("INSERT INTO korisnici (korisnicko_ime, lozinka, email, uloga) 
                                       VALUES (:username, :password, :email, 'user')");
                $stmt->execute([
                    ':username' => $korisnicko_ime,
                    ':password' => $hashed_password,
                    ':email' => $email
                ]);

                // Dohvati novog usera
                $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
                $stmt->execute([':username' => $korisnicko_ime]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="register-container">
    <h2>Registracija</h2>

    <?php if (!empty($message)): ?>
        <p class="<?= $messageClass ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label for="username">Korisničko ime:</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email adresa:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Lozinka:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Potvrdi lozinku:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit" class="btn">Registracija</button>
    </form>

    <p><a href="login.php" class="back-link">Već imate račun? Prijavite se</a></p>
</div>

</body>
</html>
