<?php
session_start();
require_once 'db.php';
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$artist_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM umjetnice WHERE id = :id");
$stmt->execute([':id' => $artist_id]);
$artist = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$artist) {
    die("Umjetnica nije pronađena.");
}
$stmtAlbums = $pdo->prepare("SELECT * FROM albumi WHERE umjetnica_id = :id");
$stmtAlbums->execute([':id' => $artist_id]);
$albums = $stmtAlbums->fetchAll(PDO::FETCH_ASSOC);
$stmtReviews = $pdo->prepare("SELECT r.*, k.korisnicko_ime FROM recenzije r LEFT JOIN korisnici k ON r.korisnik_id = k.id WHERE r.umjetnica_id = :id OR r.album_id IN (SELECT id FROM albumi WHERE umjetnica_id = :id)");
$stmtReviews->execute([':id' => $artist_id]);
$reviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($artist['ime']); ?></title>
    <style>
        body {
            background-color: #EEF1E6;
            color: #333333;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #F9665E;
            margin-top: 20px;
        }

        h2 {
            color: #799FCB;
            margin-bottom: 20px;
        }

        a {
            color: #F9665E;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .artist-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .artist-card {
            background-color: #95B4CC;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .artist-card:hover {
            transform: scale(1.05);
        }

        .image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 10px;
        }

        .artist-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .artist-card h3 {
            color: #FEC9C9;
            margin-top: 10px;
        }

        .artist-card p {
            color: #333333;
        }

        .btn {
            display: inline-block;
            background-color: #799FCB;
            color: #EEF1E6;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #AFC7D0;
        }

        .top-bar {
            margin-bottom: 20px;
        }

        .top-bar p {
            margin: 5px 0;
        }

        .admin-link {
            margin-top: 20px;
            font-weight: bold;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #799FCB;
            padding: 15px 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            color: #EEF1E6;
            margin: 0;
        }

        header nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        header nav p {
            margin: 0;
            color: #EEF1E6;
        }

        header .btn {
            background-color: #F9665E;
            color: #EEF1E6;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }

        header .btn:hover {
            background-color: #FEC9C9;
        }

        .artist-profile {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .artist-profile img {
            max-width: 300px;
            border-radius: 10px;
            margin-right: 20px;
            float: left;
        }

        .artist-profile h1 {
            color: #F9665E;
        }

        .artist-profile p {
            color: #333333;
        }

        .artist-profile .btn {
            background-color: #F9665E;
            color: #EEF1E6;
        }

        .reviews-container {
            margin-top: 30px;
        }

        .review-card {
            background-color: #f7f7f7;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .review-card strong {
            color: #F9665E;
        }

        .review-card .comment {
            margin-top: 10px;
            color: #333;
        }

        .review-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            margin-top: 10px;
        }

        .review-form input[type="number"],
        .review-form input[type="submit"] {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .review-form input[type="number"] {
            width: 100px;
        }

        .review-form input[type="submit"] {
            background-color: #799FCB;
            color: white;
            border: none;
            cursor: pointer;
        }

        .review-form input[type="submit"]:hover {
            background-color: #AFC7D0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <h1><?php echo htmlspecialchars($artist['ime']); ?></h1>
    <img src="<?php echo htmlspecialchars($artist['slika_url']); ?>"
        alt="<?php echo htmlspecialchars($artist['ime']); ?>" style="max-width:300px;"><br>
    <p><?php echo nl2br(htmlspecialchars($artist['biografija'])); ?></p>
    <h2>Diskografija</h2>
    <?php if ($albums): ?>
        <ul>
            <?php foreach ($albums as $album): ?>
                <li>
                    <?php echo htmlspecialchars($album['naslov']); ?> (<?php echo $album['godina_izdanja']; ?>)
                    - <a href="<?php echo htmlspecialchars($album['genius_url']); ?>" target="_blank">Genius</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nema albuma.</p>
    <?php endif; ?>
    <h2>Recenzije</h2>
    <?php if ($reviews): ?>
        <?php foreach ($reviews as $review): ?>
            <div style="border:1px solid #ccc; padding:5px; margin-bottom:5px;">
                <strong><?php echo htmlspecialchars($review['korisnicko_ime']); ?></strong> ocjena:
                <?php echo $review['ocjena']; ?><br>
                <?php echo nl2br(htmlspecialchars($review['komentar'])); ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nema recenzija.</p>
    <?php endif; ?>


    <h2>Ostavi recenziju</h2>
    <?php if (isset($_SESSION['user'])): ?>
        <div class="form-container">
            <form method="post" action="dodaj_recenziju.php">
                <input type="hidden" name="umjetnica_id" value="<?php echo $artist['id']; ?>">
                <label>Ocjena (1-5):</label>
                <input type="number" name="ocjena" min="1" max="5" required><br>
                <label>Komentar:</label><br>
                <textarea name="komentar" required></textarea><br>
                <input type="submit" value="Pošalji recenziju">
            </form>
        </div>
    <?php else: ?>
        <p><a href="login.php">Prijavite se</a> da ostavite recenziju.</p>
    <?php endif; ?>
    <p><a href="index.php">Nazad na početnu</a></p>
</body>

</html>