<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal</title>
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
            <li><a href="index.php" class="active">Home</a></li>
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
 
    $kategorije = ['Politik', 'Gesundheit'];
 
    foreach ($kategorije as $kat):
        $query = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = ? LIMIT 3";
        $stmt  = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, 's', $kat);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
    ?>
 
    <section>
        <h2 class="section-title">
            <a href="kategorija.php?kategorija=<?php echo urlencode($kat); ?>"><?php echo htmlspecialchars($kat); echo " >" ?></a>
        </h2>
 
        <div class="articles-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <article class="article-card">
                <?php if (!empty($row['slika'])): ?>
                <a href="clanak.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" alt="<?php echo htmlspecialchars($row['naslov']); ?>">
                </a>
                <?php endif; ?>
                <p class="category-tag"><?php echo htmlspecialchars($row['naslov']); ?></p>
                <h3><a href="clanak.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['sazetak']); ?></a></h3>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
 
    <?php endforeach; ?>
 
    <?php mysqli_close($dbc); ?>
 
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

</body>
</html>