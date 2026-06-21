<?php
session_start();
include 'connect.php';

$msg              = '';
$registriranKorisnik = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime      = $_POST['ime'];
    $prezime  = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka  = $_POST['pass'];
    $lozinka2 = $_POST['passRep'];
    $razina   = 0;

    if ($lozinka !== $lozinka2) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {
        $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

        $sql  = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            $sql  = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                if (mysqli_stmt_execute($stmt)) {
                    $registriranKorisnik = true;
                } else {
                    $msg = 'Greška pri registraciji. Pokušajte ponovo.';
                }
            }
        }
    }
    mysqli_close($dbc);
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stern Portal - Registracija</title>
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

    <?php if ($registriranKorisnik): ?>
        <div class="login-wrapper">
            <p class="poruka-uspjeh">&#10003; Korisnik je uspješno registriran!</p>
            <p><a href="administracija.php">Prijava u administraciju</a></p>
        </div>
    <?php else: ?>

        <div class="login-wrapper" style="max-width:500px;">
            <h2>Registracija</h2>

            <?php if ($msg): ?>
                <p class="poruka-greska"><?php echo htmlspecialchars($msg); ?></p>
            <?php endif; ?>

            <form action="registracija.php" method="POST" name="registracijaForma" enctype="multipart/form-data">

                <div class="form-item">
                    <span id="porukaIme" class="bojaPoruke"></span>
                    <label for="ime">Ime</label>
                    <input type="text" name="ime" id="ime" class="form-field-textual">
                </div>

                <div class="form-item">
                    <span id="porukaPrezime" class="bojaPoruke"></span>
                    <label for="prezime">Prezime</label>
                    <input type="text" name="prezime" id="prezime" class="form-field-textual">
                </div>

                <div class="form-item">
                    <span id="porukaUsername" class="bojaPoruke"></span>
                    <label for="username">Korisničko ime</label>
                    <input type="text" name="username" id="username" class="form-field-textual" autocomplete="username">
                </div>

                <div class="form-item">
                    <span id="porukaPass" class="bojaPoruke"></span>
                    <label for="pass">Lozinka</label>
                    <input type="password" name="pass" id="pass" class="form-field-textual" autocomplete="new-password">
                </div>

                <div class="form-item">
                    <span id="porukaPassRep" class="bojaPoruke"></span>
                    <label for="passRep">Ponovite lozinku</label>
                    <input type="password" name="passRep" id="passRep" class="form-field-textual" autocomplete="new-password">
                </div>

                <div class="form-item">
                    <button type="submit" id="slanje" class="btn btn-submit">Registriraj se</button>
                </div>

            </form>
        </div>

    <?php endif; ?>
    </section>
</div>

<footer>
    <p>Nachrichten vom <?php echo date('d.m.Y'); ?> | &copy; stern.de GmbH | <a href="index.php">Home</a></p>
    <p>Autor: Fran Pilija | fran.pilija@gmail.com | 2026</p>
</footer>

<script type="text/javascript">
document.getElementById("slanje").addEventListener("click", function(event) {
    var ok = true;

    function provjeri(idPolja, idPoruka, poruka) {
        var polje = document.getElementById(idPolja);
        var span  = document.getElementById(idPoruka);
        if (polje.value.trim().length === 0) {
            ok = false;
            polje.style.border = "1px solid red";
            span.innerHTML = poruka;
        } else {
            polje.style.border = "1px solid green";
            span.innerHTML = "";
        }
    }

    provjeri("ime",      "porukaIme",      "Unesite ime!");
    provjeri("prezime",  "porukaPrezime",  "Unesite prezime!");
    provjeri("username", "porukaUsername", "Unesite korisničko ime!");

    var pass    = document.getElementById("pass");
    var passRep = document.getElementById("passRep");
    var sp1     = document.getElementById("porukaPass");
    var sp2     = document.getElementById("porukaPassRep");

    if (pass.value.length === 0 || passRep.value.length === 0 || pass.value !== passRep.value) {
        ok = false;
        sp1.innerHTML = "Lozinke nisu iste!";
        sp2.innerHTML = "Lozinke nisu iste!";
    } else {
        pass.style.border    = "1px solid green";
        passRep.style.border = "1px solid green";
        sp1.innerHTML = "";
        sp2.innerHTML = "";
    }

    if (!ok) event.preventDefault();
});
</script>

</body>
</html>