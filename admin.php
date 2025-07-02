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
    <title>Admin Panel</title>
    <style>
        body {
            background-color: #EEF1E6;
            color: #333333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            color: #F9665E;
            text-align: center;
            margin: 20px 0;
        }

        p {
            text-align: center;
            margin: 10px;
        }

        a {
            color: #F9665E;
            /* Pastel Red */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border: 1px solid #34495e;
            background-color: #34495e;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border: 1px solid #7f8c8d;
            vertical-align: middle;
        }

        th {
            background-color: #1abc9c;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #16a085;
        }

        tr:nth-child(odd) {
            background-color: #1abc9c;
        }

        td a {
            ;
            margin-top: 10px;
            color: white;
            padding: 5px 10px;
            background-color: #e74c3c;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        td a:last-child {
            margin-right: 0;
        }


        td a:hover {
            background-color: #c0392b;
        }


        .btn {
            background-color: #F9665E;
            color: #EEF1E6;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #FEC9C9;
        }
    </style>
</head>

<body>
    <h1>Admin Panel</h1>
    <p>Dobrodošli, <?php echo htmlspecialchars($_SESSION['user']['korisnicko_ime']); ?> | <a href="logout.php"
            class="btn">Odjava</a></p>
    <h2>Prijedlozi umjetnica</h2>
    <?php if ($prijedlozi): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Ime umjetnice</th>
                <th>Opis</th>
                <th>Kontakt</th>
                <th>Status</th>
                <th>Poslano</th>
                <th>Akcije</th>
            </tr>
            <?php foreach ($prijedlozi as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['ime_umjetnice']); ?></td>
                    <td><?php echo htmlspecialchars($p['opis']); ?></td>
                    <td><?php echo htmlspecialchars($p['kontakt']); ?></td>
                    <td><?php echo $p['status']; ?></td>
                    <td><?php echo $p['poslano']; ?></td>
                    <td>
                        <?php if ($p['status'] == 'pending'): ?>
                            <a href="admin_action.php?action=approve&id=<?php echo $p['id']; ?>" class="btn">Odobri</a>
                            <a href="admin_action.php?action=reject&id=<?php echo $p['id']; ?>" class="btn">Odbij</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nema novih prijedloga.</p>
    <?php endif; ?>
    <p><a href="index.php" class="btn">Nazad na početnu</a></p>
</body>

</html>