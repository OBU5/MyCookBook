<?php
//entry.php  
session_start();
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
          <a class="active" href="#home">Home</a>
          <a href="#news">News</a>
          <a href="#contact">Contact</a>
          <a href="#about">About</a>
     </div>
     <br /><br />
     <div class="container" style="width:500px;">
          <h3 align="center">Welcome</h3>
          <br />
          <?php
          // Create connection
          $connect = mysqli_connect("localhost", "root", "", "test");

          // Check connection
          if ($connect->connect_error) {
               die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT id, username, role FROM users";
          $result = $connect->query($sql);

          if ($result->num_rows > 0) {
               // output data of each row
               while ($row = $result->fetch_assoc()) {
                    if($row["username"] == $_SESSION["username"])
                    echo "id: " . $row["id"] . " - username: " . $row["username"] . " " . $row["role"] . "<br>";
               }
          } else {
               echo "0 results";
          }



          echo '<h1>Welcome - ' . $_SESSION["username"] . '</h1>';
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