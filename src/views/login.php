<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = trim($_POST['username']);
    $lozinka = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
    $stmt->execute([':username' => $korisnicko_ime]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($lozinka, $user['lozinka'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Neispravno korisničko ime ili lozinka.";
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Prijava</h2>

        <?php if (isset($error)): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="login.php">
            <label for="username">Korisničko ime:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Lozinka:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="btn">Prijava</button>
        </form>

        <p><a href="register.php" class="register-btn">Registracija</a></p>
        <p><a href="index.php" class="back-link">Nazad na početnu</a></p>
    </div>
</body>
</html>
