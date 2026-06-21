<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal - Članak</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
    <div class="header-top">
        <div class="logo">
            <a href="index.php">
                <img src="img/logo.svg" alt="Logo" class="logo-stern">
            </a>
            <span>stern</span>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="kategorija.php?kategorija=Politik">Politik</a></li>
            <li><a href="kategorija.php?kategorija=Gesundheit">Gesundheit</a></li>
            <li><a href="administracija.php">Administracija</a></li>
        </ul>
    </nav>
</header>

<div class="wrapper">
    <?php
    include 'connect.php';
    define('UPLPATH', 'img/');

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<p>Nevažeći članak.</p>';
    } else {
        $id = (int)$_GET['id'];

        $sql  = "SELECT * FROM vijesti WHERE id = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row    = mysqli_fetch_assoc($result);
        }

        if (!$row) {
            echo '<p>Članak nije pronađen.</p>';
        } else {
    ?>

    <article class="article-single">
        <h1><?php echo htmlspecialchars($row['naslov']); ?></h1>
        <div class="article-meta">
            <span><?php echo htmlspecialchars($row['datum']); ?></span>
        </div>

        <p class="article-summary"><?php echo nl2br(htmlspecialchars($row['sazetak'])); ?></p>

        <?php if (!empty($row['slika'])): ?>
        <img src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" alt="<?php echo htmlspecialchars($row['naslov']); ?>">
        <?php endif; ?>

        <div class="article-content">
            <?php echo nl2br(htmlspecialchars($row['tekst'])); ?>
        </div>
    </article>

    <?php
        }
    }
    mysqli_close($dbc);
    ?>
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

</body>
</html>