<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['uloga'] != 'admin') {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

$stmt = $pdo->query("SELECT * FROM prijedlozi ORDER BY poslano DESC");
$prijedlozi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Indie Diva Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <p>Dobrodošli, <strong><?= htmlspecialchars($_SESSION['user']['korisnicko_ime']) ?></strong> | 
        <a href="logout.php" class="btn">Odjava</a></p>
    </header>

    <div class="container">
        <h2>Prijedlozi umjetnica</h2>

        <?php if ($prijedlozi): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime umjetnice</th>
                        <th>Opis</th>
                        <th>Kontakt</th>
                        <th>Status</th>
                        <th>Poslano</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prijedlozi as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['ime_umjetnice']) ?></td>
                            <td><?= htmlspecialchars($p['opis']) ?></td>
                            <td><?= htmlspecialchars($p['kontakt']) ?></td>
                            <td><?= $p['status'] ?></td>
                            <td><?= $p['poslano'] ?></td>
                            <td>
                                <?php if ($p['status'] === 'pending'): ?>
                                    <a href="admin_action.php?action=approve&id=<?= $p['id'] ?>" class="btn">Odobri</a>
                                    <a href="admin_action.php?action=reject&id=<?= $p['id'] ?>" class="btn">Odbij</a>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nema novih prijedloga.</p>
        <?php endif; ?>

        <p style="text-align: center; margin-top: 20px;">
            <a href="index.php" class="btn">Nazad na početnu</a>
        </p>
    </div>

    <footer>
        <p>&copy; <?= date('Y') ?> Indie Diva Hub</p>
    </footer>
</body>
</html>
