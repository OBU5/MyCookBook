<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
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
     <!--Content of the page -->
     <div class="homeDiv">
         <?php
                    if (isset($_SESSION["username"])) {
                         // User is not logged in
                         echo " <p>Vítejte na webové stránce MyCookBook &nbsp; <strong>" .$_SESSION['username']. "</strong>! </p>";
                         echo " <p> </p>";
                    } else {
                         // User is  logged in
                         echo " <p>Vítejte na webové stránce MyCookBook. Aby jste mohl využít tuto stránku plnohodnotně, musíte se nejprve přihlásit</p>";
                    } ?> </p>
     </div>


     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
          </p>
     </footer>
</body>

</html>