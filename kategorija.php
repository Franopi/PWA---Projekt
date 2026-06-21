<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal - Kategorija</title>
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
            <li><a href="kategorija.php?kategorija=Politik" <?php if(isset($_GET['kategorija']) && $_GET['kategorija']=='Politik') echo 'class="active"'; ?>>Politik</a></li>
            <li><a href="kategorija.php?kategorija=Gesundheit" <?php if(isset($_GET['kategorija']) && $_GET['kategorija']=='Gesundheit') echo 'class="active"'; ?>>Gesundheit</a></li>
            <li><a href="administracija.php">Administracija</a></li>
        </ul>
    </nav>
</header>

<div class="wrapper">
    <?php
    include 'connect.php';
    define('UPLPATH', 'img/');
 
    $dozvoljeneKategorije = ['Politik', 'Gesundheit'];
    $kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';
 
    if (!in_array($kategorija, $dozvoljeneKategorije)) {
        echo '<p>Nevažeća kategorija.</p>';
    } else {
    ?>
 
    <h2 class="category-page-title"><?php echo htmlspecialchars($kategorija); ?></h2>
 
    <div class="articles-grid" style="flex-wrap: wrap; gap: 20px;">
    <?php
        $sql  = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $kategorija);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
 
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $count++;
    ?>
        <article class="article-card" style="flex: 0 0 calc(33.333% - 14px);">
            <?php if (!empty($row['slika'])): ?>
            <a href="clanak.php?id=<?php echo $row['id']; ?>">
                <img src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" alt="<?php echo htmlspecialchars($row['naslov']); ?>">
            </a>
            <?php endif; ?>
            <p class="category-tag"><?php echo htmlspecialchars($row['naslov']); ?></p>
            <h3><a href="clanak.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['sazetak']); ?></a></h3>
        </article>
    <?php endwhile; ?>
 
    <?php if ($count === 0): ?>
        <p>Nema vijesti.</p>
    <?php endif; ?>
 
    </div>
 
    <?php } mysqli_close($dbc); ?>
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

</body>
</html>