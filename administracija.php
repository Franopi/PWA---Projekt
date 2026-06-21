<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = false;
$admin           = false;
$msg             = '';

if (isset($_POST['delete']) && isset($_SESSION['username']) && $_SESSION['level'] == 1) {
    $id   = (int)$_POST['id'];
    $sql  = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }
    header('Location: administracija.php');
    exit;
}

if (isset($_POST['update']) && isset($_SESSION['username']) && $_SESSION['level'] == 1) {
    $id       = (int)$_POST['id'];
    $title    = $_POST['title'];
    $about    = $_POST['about'];
    $content  = $_POST['content'];
    $category = $_POST['category'];
    $archive  = isset($_POST['archive']) ? 1 : 0;
    $picture  = $_FILES['pphoto']['name'];

    if (!empty($picture)) {
        $target_dir = 'img/' . basename($picture);
        move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
    } else {
        $sqlPic  = "SELECT slika FROM vijesti WHERE id = ?";
        $stmtPic = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmtPic, $sqlPic)) {
            mysqli_stmt_bind_param($stmtPic, 'i', $id);
            mysqli_stmt_execute($stmtPic);
            $resPic = mysqli_stmt_get_result($stmtPic);
            $rowPic = mysqli_fetch_assoc($resPic);
            $picture = $rowPic['slika'];
        }
    }

    $sql  = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssssii', $title, $about, $content, $picture, $category, $archive, $id);
        mysqli_stmt_execute($stmt);
    }
    header('Location: administracija.php');
    exit;
}

if (isset($_GET['odjava'])) {
    session_destroy();
    header('Location: administracija.php');
    exit;
}

if (isset($_POST['prijava'])) {
    $prijavaUsername = $_POST['username'];
    $prijavaLozinka  = $_POST['lozinka'];

    $sql  = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaUsername);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
        mysqli_stmt_fetch($stmt);
    }

    if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($prijavaLozinka, $lozinkaKorisnika)) {
        $uspjesnaPrijava = true;
        $_SESSION['username'] = $imeKorisnika;
        $_SESSION['level']    = $levelKorisnika;
        $admin = ($levelKorisnika == 1);
    } else {
        $msg = 'Neispravno korisničko ime ili lozinka. <a href="registracija.php">Registrirajte se</a>.';
    }
}

if (isset($_SESSION['username'])) {
    $uspjesnaPrijava = true;
    $admin = ($_SESSION['level'] == 1);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal - Administracija</title>
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
            <li><a href="administracija.php" class="active">Administracija</a></li>
        </ul>
    </nav>
</header>

<div class="wrapper">

<?php if ($uspjesnaPrijava && $admin): ?>

    <div class="admin-wrapper">
        <h2>Administracija vijesti &nbsp;
            <small style="font-size:13px; font-weight:normal;">
                Prijavljeni: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                &nbsp;|&nbsp; <a href="administracija.php?odjava=1">Odjava</a>
                &nbsp;|&nbsp; <a href="unos.php">+ Nova vijest</a>
            </small>
        </h2>

        <?php
        $query  = "SELECT * FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="admin-article-form">
            <h4><?php echo htmlspecialchars($row['naslov']); ?></h4>
            <form enctype="multipart/form-data" action="administracija.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class="form-item">
                    <label>Naslov:</label>
                    <input type="text" name="title" class="form-field-textual" maxlength="50" required value="<?php echo htmlspecialchars($row['naslov']); ?>">
                </div>

                <div class="form-item">
                    <label>Kratki sadržaj:</label>
                    <textarea name="about" cols="30" rows="3" class="form-field-textual" maxlength="50" required><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                </div>

                <div class="form-item">
                    <label>Sadržaj vijesti:</label>
                    <textarea name="content" cols="30" rows="5" class="form-field-textual" required><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                </div>

                <div class="form-item">
                    <label>Slika:</label>
                    <?php if (!empty($row['slika'])): ?>
                        <img src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" width="100" style="margin-bottom:5px;">
                    <?php endif; ?>
                    <input type="file" name="pphoto" class="input-text">
                </div>

                <div class="form-item">
                    <label>Kategorija:</label>
                    <select name="category" class="form-field-textual">
                        <option value="Politik"    <?php if($row['kategorija']=='Politik')    echo 'selected'; ?>>Politik</option>
                        <option value="Gesundheit" <?php if($row['kategorija']=='Gesundheit') echo 'selected'; ?>>Gesundheit</option>
                    </select>
                </div>

                <div class="form-item">
                    <label>
                        Arhiviraj:
                        <div class="form-item">
                            <input type="checkbox" name="archive" <?php if($row['arhiva']==1) echo 'checked'; ?>>
                        </div>
                    </label>
                </div>

                <div class="form-item">
                    <button type="submit" name="delete" class="btn-delete" onclick="return confirm('Sigurno želiš obrisati ovu vijest?')">Obriši</button>
                    <button type="submit" name="update" class="btn-update">Spremi izmjene</button>
                </div>
            </form>
        </div>
        <?php endwhile; ?>
    </div>

<?php elseif ($uspjesnaPrijava && !$admin): ?>

    <p>Bok <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>,
       nemate dovoljna prava za pristup ovoj stranici.</p>
    <p><a href="administracija.php?odjava=1">Odjava</a></p>

<?php else: ?>

    <div class="login-wrapper">
        <h2>Prijava u administraciju</h2>

        <?php if ($msg): ?>
            <p class="poruka-greska"><?php echo $msg; ?></p>
        <?php endif; ?>

        <form action="administracija.php" method="POST" name="loginForma">
            <div class="form-item">
                <label for="username">Korisničko ime</label>
                <input type="text" name="username" id="username" class="form-field-textual" autofocus autocomplete="username">
            </div>
            <div class="form-item">
                <label for="lozinka">Lozinka</label>
                <input type="password" name="lozinka" id="lozinka" class="form-field-textual" autocomplete="current-password">
            </div>
            <div class="form-item">
                <button type="submit" name="prijava" class="btn btn-submit">Prijava</button>
            </div>
        </form>
        <p style="margin-top:15px; font-size:12px;">Nemate račun? <a href="registracija.php">Registrirajte se</a></p>
    </div>

<?php endif; ?>

<?php mysqli_close($dbc); ?>
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

</body>
</html>