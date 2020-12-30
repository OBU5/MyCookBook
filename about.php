<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Stránka o stránce</title>
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <!--Navigation bar-->
    <div class="topnav">
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
    </div>
    <div class="aboutDiv">
        <h1> Vítejte na stránce MyCookBook </h1>
        <p><strong>Dobrý den,</strong> rád bych Vás srdečně přivítal na webové stránce věnované tvorbě receptů <strong>My cook book</strong>. Tato webová stránka vznikla jako semestrální projekt v rámci předmětu ZWA a byla napsána pomocí programovacích jazyků: PHP, HTML, CSS, Javascript, MYSQL. Aplikace umožňuje registraci a přihlášení uživatelů a přidání, případně zobrazení receptů. Pro správu dat je použita databáze MySQL, která umožňuje (pro případ potřeby) snadnou a elegantní přenositelnost naimplementovaných dat. </p>
        <br>
        <br>
        <p>Jelikož je tato webová stránka stále ve vývoji, prosím o schovívaost. V případě nalezení jakéhokoliv problému mne prosím kontaktujte na adresu: </p>
        <a href="mailto: bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>

    </div>
</body>

</html>