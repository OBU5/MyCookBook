<?php
session_start();
$bodyClass = "style1";
if (isset($_COOKIE["style"])) {
    if ($_COOKIE["style"] == "1") {
        $bodyClass = "style1";
    } elseif ($_COOKIE["style"] == "2") {
        $bodyClass = "style2";
    } elseif ($_COOKIE["style"] == "3") {
        $bodyClass = "style3";
    } elseif ($_COOKIE["style"] == "4") {
        $bodyClass = "style4";
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>MyCookBook</title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/3565/3565407.svg" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body class="<?php echo $bodyClass; ?>">
    <!--Navigation bar-->
    <nav class="topnav">
        <a href="index.php">Domů</a>
        <a href="viewAllRecipes.php">Zobrazit recepty</a>
        <a href="addRecipe.php">Přidat nový recept</a>
        <a class="active" href="about.php">About</a>
        <?php
        if (!isset($_SESSION["username"])) {
            // User is not logged in
            echo '<a href="login.php?action=login">Login</a>';
        } else {
            // User is  logged in
            echo '<a href="userInfo.php">' . $_SESSION["username"] . '</a>';
        } ?>
        <select onchange="location = this.value;">
            <option hidden selected disabled>Styl</option>
            <option value="changeStyle.php?style=1">Zeleninový</option>
            <option value="changeStyle.php?style=2">Masový</option>
            <option value="changeStyle.php?style=3">Těstovinový</option>
            <option value="changeStyle.php?style=4">Ovocný</option>
        </select>
    </nav>
    <main class="aboutDiv">
        <h1> Vítejte na stránce MyCookBook </h1>
        <p><strong>Dobrý den,</strong> rád bych Vás srdečně přivítal na webové stránce věnované tvorbě receptů <strong>My cookBook</strong>. Tato webová stránka vznikla jako semestrální projekt v rámci předmětu ZWA a byla napsána pomocí programovacích jazyků: PHP, HTML, CSS, Javascript, MYSQL. Aplikace umožňuje registraci a přihlášení uživatelů a přidání, případně zobrazení receptů. Pro správu dat je použita databáze MySQL, která umožňuje (pro případ potřeby) snadnou a elegantní přenositelnost naimplementovaných dat. </p>
        <br>
        <br>
        <p>Jelikož je tato webová stránka stále ve vývoji, prosím o schovívaost. V případě nalezení jakéhokoliv problému mne prosím kontaktujte na adresu: </p>
        <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
    </main>
    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>
</body>

</html>