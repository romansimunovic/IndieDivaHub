<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = trim($_POST['username']);
    $lozinka = trim($_POST['password']);
    $potvrda_lozinke = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);  // Novi unos za email

    // Provjera da li lozinke odgovaraju
    if ($lozinka !== $potvrda_lozinke) {
        $error = "Lozinke se ne podudaraju.";
    } else {
        // Provjera da li korisničko ime već postoji
        $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE korisnicko_ime = :username");
        $stmt->execute([':username' => $korisnicko_ime]);
        if ($stmt->fetch()) {
            $error = "Korisničko ime već postoji.";
        } else {
            // Provjera da li email već postoji
            $stmt = $pdo->prepare("SELECT * FROM korisnici WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                $error = "Email adresa već postoji.";
            } else {
                // Hashiranje lozinke
                $hashed_password = hash('md5', $lozinka);

                // Unos novih podataka u bazu
                $stmt = $pdo->prepare("INSERT INTO korisnici (korisnicko_ime, lozinka, email, uloga) 
                                       VALUES (:username, :password, :email, 'user')");
                $stmt->execute([':username' => $korisnicko_ime, ':password' => $hashed_password, ':email' => $email]);

                $_SESSION['user'] = ['korisnicko_ime' => $korisnicko_ime];
                header("Location: index.php");
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EEF1E6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: #95B4CC;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        h2 {
            color: #EEF1E6;
            margin-bottom: 20px;
        }

        .error-msg {
            color: #F9665E;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #EEF1E6;
            text-align: left;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #AFC7D0;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #F9665E;
            color: #EEF1E6;
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
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #EEF1E6;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Registracija</h2>

        <?php if (isset($error)): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
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