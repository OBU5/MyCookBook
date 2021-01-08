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
    <title>My CookBook</title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/3565/3565407.svg" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body class="<?php echo $bodyClass; ?>">
    <!--Navigation bar-->
    <nav class="topnav">
        <a class="active" href="index.php">Domů</a>
        <a href="viewAllRecipes.php">Zobrazit recepty</a>
        <a href="addRecipe.php">Přidat nový recept</a>
        <a href="about.php">About</a>
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
    <!--Content of the page -->
    <main class="homeDiv">
        <article>
            <?php
            if (isset($_SESSION["username"])) {
                // User is not logged in
                echo " <p>Vítejte na webové stránce MyCookBook &nbsp; <strong>" . $_SESSION['username'] . "</strong>! </p>";
                echo " <p> </p>";
            } else {
                // User is  logged in
                echo " <p>Vítejte na webové stránce MyCookBook. Aby jste mohli využít tuto stránku plnohodnotně, musíte se nejprve přihlásit</p>";
            }
            ?>
            <h2>Nevíte co na této stránce dělat? Zde je uvedeno pár typů</h2>
            <p>Pokud nevíte co zrovna uvařit nebo jen přemýšlíte, co byste si někdy v budoucnu rádi dali, klikněte v navigačním menu na <strong>Zobrazit recepty</strong></p>
            <p>Máte oblíbený pokrm a rádi byste se podělili o jeho tajemství? Pokud ano, klikněte v navigačním menu na <strong>Přidat nový recept</strong></p>
            <p>Zajímáte li se o informace o této stránce, například za jakým účelem vznikla, klikněte v navigačním menu na <strong>About</strong></p>
            <?php
            if (isset($_SESSION["username"])) {
                // User is not logged in
                echo "<p>Pokud chcete vidět případně upravit vaše informace, klikněte v navigačním menu na <strong>" . $_SESSION['username'] . "</strong></p>";
            } else {
                // User is  logged in
                echo "<p>Pokud se chcete zaregistrovat, případně přihlásti, klikněte v navigačním menu na <strong>Login</strong></p>";
            }
            ?>
        </article>
    </main>


    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>
</body>

</html>