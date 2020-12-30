<?php
session_start();
// if the user is not logged in, redirrect him
if (!isset($_SESSION["username"])) {
     header("location:index.php?action=login");
}
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
          <a href="index.php">Domů</a>
          <a href="viewAllRecipes.php">Zobrazit recepty</a>
          <a href="addRecipe.php">Přidat nový recept</a>
          <a href="about.php">About</a>
          <?php
          if (!isset($_SESSION["username"])) {
               // User is not logged in
               echo '<a class="active" href="login.php?action=login">Login</a>';
          } else {
               // User is  logged in
               echo '<a class="active" href="userInfo.php">' . $_SESSION["username"] . '</a>';
          } ?>
     </div>
     <br /><br />
     <div class="userDiv">
          <h3 align="center">Informace o Vás</h3>
          <br>
          <?php
          // Create connection
          $connect = mysqli_connect("localhost", "root", "", "test");

          // Check connection
          if ($connect->connect_error) {
               die("Connection failed: " . $connect->connect_error);
          }
          $query = "SELECT ID, name, lastname, email, username, role FROM users";
          $result = $connect->query($query);

          if ($result->num_rows > 0) {
               // output data of each row
               while ($row = $result->fetch_assoc()) {
                    if ($row["username"] == $_SESSION["username"])
                         echo "<table class =  userInfo>
                              <tr>
                                   <th> jméno </th>
                                   <td>" . $row["name"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Příjmení </th>
                                   <td>" . $row["lastname"] . "</td>
                              <tr/>
                              <tr>
                                   <th> email </th>
                                   <td>" . $row["email"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Username </th>
                                   <td>" . $row["username"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Role </th>
                                   <td>" . $row["role"] . "</td>
                              <tr/>
                              
                         </table>";
               }
          } else {
               echo "0 results";
          }



          echo '<br><br>';
          echo '<label><a href="logout.php">Logout</a></label>';
          ?>
     </div>
     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a></p>
     </footer>
</body>

</html>