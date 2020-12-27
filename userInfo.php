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
     <title>My Cook book</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

     <link rel="stylesheet" href="styles.css">
     <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>


<body>
     <!--Navigation bar-->
     <div class="topnav">
          <a href="index.php">Home</a>
          <a href="#news">News</a>
          <a href="#contact">Contact</a>
          <a href="#about">About</a>

          <?php
          if (!isset($_SESSION["username"])) {
               // User is not logged in
               echo '<a class="active" href="login.php?action=login">Login</a>';
          } else {
               // User is  logged in
               echo '<a class="active" href="userInfo.php">' . $_SESSION["username"] . '</a>';
          }
          ?> </div>
     <br /><br />
     <div class="container" style="width:500px;">
          <h3 align="center">Informace o Vás</h3>
          <br>
          <?php
          // Create connection
          $connect = mysqli_connect("localhost", "root", "", "test");

          // Check connection
          if ($connect->connect_error) {
               die("Connection failed: " . $conn->connect_error);
          }
          $query = "SELECT ID, name, lastname, email, username, role FROM users";
          $result = $connect->query($query);

          if ($result->num_rows > 0) {
               // output data of each row
               while ($row = $result->fetch_assoc()) {
                    if ($row["username"] == $_SESSION["username"])
                         echo "<table>
                              <tr>
                                   <th> jméno </th>
                                   <th>" . $row["name"] . "</th>
                              <tr/>
                              <tr>
                                   <th> Příjmení </th>
                                   <th>" . $row["lastname"] . "</th>
                              <tr/>
                              <tr>
                                   <th> email </th>
                                   <th>" . $row["email"] . "</th>
                              <tr/>
                              <tr>
                                   <th> Username </th>
                                   <th>" . $row["username"] . "</th>
                              <tr/>
                              <tr>
                                   <th> Role </th>
                                   <th>" . $row["role"] . "</th>
                              <tr/>
                              
                         <table/>";
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