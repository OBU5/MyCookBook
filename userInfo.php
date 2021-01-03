<?php
session_start();
?>
<!DOCTYPE html>
<html>


<head>

     <link rel="stylesheet" href="Styles/styles.css">
     <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
          if (isset($_SESSION["username"])) {

               // Create connection
               $connect = mysqli_connect("localhost", "root", "", "test");
               $currentUser = $_SESSION["username"];
               // Check connection
               if ($connect->connect_error) {
                    die("Connection failed: " . $connect->connect_error);
               }
               $query = "SELECT ID, name, lastname, email, username, role FROM users WHERE username = '$currentUser'";
               $result = $connect->query($query);

               if ($result->num_rows > 0) {
                    // output data of each row

                    $row = $result->fetch_assoc();
                    $adminButton  = "";

                    if ($row["role"] == "Admin") {
                         $adminButton = "<button type=button onclick=location.href='viewAllUserInfo.php'>Zobrazit všechny uživatele&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-edit'></i></button>";
                    }
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
                         </table>
                         <br><br>
                         <button type=button onclick=location.href='editLogin.php?id=" . $row["ID"] .  "'>Upravit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-edit'></i></button>    
                         " . $adminButton . "         
                         ";
               } else {
                    echo "0 results";
               }



               echo '<br><br>';
               echo '<label><a href="logout.php">Logout</a></label>';
          } else {
               echo '<p class=errorMessage>Nejste přihlášen</p>';
          }
          ?>

     </div>
     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a></p>
     </footer>
</body>

</html>