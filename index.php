<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
     <link rel="stylesheet" href="styles.css">
     <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
     <!--Navigation bar-->
     <div class="topnav">
          <a class="active" href="#home">Home</a>
          <a href="#news">News</a>
          <a href="#contact">Contact</a>
          <a href="#about">About</a>
          <?php
          if (!isset($_SESSION["username"])) {
               // User is not logged in
               echo '<a href="login.php?action=login">Login</a>';
          } else {
               // User is  logged in
               echo '<a href="userInfo.php">' . $_SESSION["username"] . '</a>';
          }
          ?>
     </div>
     <!--Content of the page -->
     <div style="padding-left:16px">
          <h2>Top Navigation Example</h2>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p><br>
          <p>Some content..</p>
     </div>

     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a></p>
     </footer>
</body>

</html>