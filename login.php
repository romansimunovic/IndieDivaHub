<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = trim($_POST['username']);
    $lozinka = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
    $stmt->execute([':username' => $korisnicko_ime]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && (hash('md5', $lozinka) === $user['lozinka'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Neispravno korisničko ime ili lozinka.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EEF1E6;
            /* Alabaster */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #95B4CC;
            /* Wild Blue Yonder */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        h2 {
            color: #EEF1E6;
            /* Alabaster */
            margin-bottom: 20px;
        }

        .error-msg {
            color: #F9665E;
            /* Pastel Red */
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #EEF1E6;
            /* Alabaster */
            text-align: left;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #AFC7D0;
            /* Pastel Blue */
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #F9665E;
            /* Pastel Red */
            color: #EEF1E6;
            /* Alabaster */
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #FEC9C9;
            /* Light Red */
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #EEF1E6;
            /* Alabaster */
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Prijava</h2>

        <?php if (isset($error)): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
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