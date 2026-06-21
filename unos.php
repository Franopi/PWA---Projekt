<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal - Unos</title>
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
    <section role="main">
        <div class="form-wrapper">
            <h2>Unos nove vijesti</h2>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include 'connect.php';

                $picture  = isset($_FILES['pphoto']['name']) ? $_FILES['pphoto']['name'] : '';
                $title    = isset($_POST['title'])    ? $_POST['title']    : '';
                $about    = isset($_POST['about'])    ? $_POST['about']    : '';
                $content  = isset($_POST['content'])  ? $_POST['content']  : '';
                $category = isset($_POST['category']) ? $_POST['category'] : '';
                $date     = date('d.m.Y.');
                $archive  = isset($_POST['archive'])  ? 1 : 0;

                if (!empty($picture)) {
                    $target_dir = 'img/' . basename($picture);
                    move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
                }

                $sql  = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($dbc);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ssssssi', $date, $title, $about, $content, $picture, $category, $archive);
                    if (mysqli_stmt_execute($stmt)) {
                        echo '<p class="poruka-uspjeh">Vijest je uspješno dodana.</p>';
                    } else {
                        echo '<p class="poruka-greska">Greška pri unosu.</p>';
                    }
                }
                mysqli_close($dbc);
            }
            ?>

            <form enctype="multipart/form-data" action="unos.php" method="POST" name="unosVijesti">

                <div class="form-item">
                    <label for="title">Naslov vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <input type="text" name="title" id="title" class="form-field-textual" autofocus autocomplete="off" maxlength="50" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" id="about" cols="30" rows="4" class="form-field-textual" maxlength="50" required></textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual" required></textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label for="pphoto">Slika</label>
                    <div class="form-field">
                        <input type="file" accept="image/jpg,image/jpeg,image/gif,image/png" class="input-text" name="pphoto" id="pphoto" required>
                    </div>
                </div>

                <div class="form-item">
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" id="category" class="form-field-textual">
                            <option value="Politik">Politik</option>
                            <option value="Gesundheit">Gesundheit</option>
                        </select>
                    </div>
                </div>

                <div class="form-item">
                    <label>
                        Arhiviraj
                        <div class="form-item">
                            <input type="checkbox" name="archive" id="archive">
                        </div>
                    </label>
                </div>

                <div class="form-item">
                    <button type="reset" class="btn btn-reset">Resetiraj</button>
                    <button type="submit" class="btn btn-submit">Spremi</button>
                </div>

            </form>
        </div>
    </section>
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

</body>
</html>