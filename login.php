<?php
$connect = mysqli_connect("localhost", "root", "", "test");
session_start();
if (isset($_SESSION["username"])) {
     header("location:entry.php");
}
if (isset($_POST["register"])) {

     if (empty($_POST["username"]) || empty($_POST["password"])) {
          echo '<script>alert("Both Fields are required")</script>';
     } else {

          $username = mysqli_real_escape_string($connect, $_POST["username"]);
          // check if the username really doesn't exist
          $query = "SELECT * FROM users WHERE username = '$username'";
          $result = mysqli_query($connect, $query);
          if (mysqli_num_rows($result) > 0) {
               echo '<script>alert("this username already exists")</script>';
          } else {
               // the username is OK
               $password = mysqli_real_escape_string($connect, $_POST["password"]);
               $password = password_hash($password, PASSWORD_DEFAULT);
               $query = "INSERT INTO users(username, password, role) VALUES('$username', '$password', 'Regular user')";
               if (mysqli_query($connect, $query)) {
                    echo '<script>alert("Registration Done")</script>';
               }
          }
     }
}
if (isset($_POST["login"])) {
     if (empty($_POST["username"]) || empty($_POST["password"])) {
          echo '<script>alert("Both Fields are required")</script>';
     } else {
          $username = mysqli_real_escape_string($connect, $_POST["username"]);
          $password = mysqli_real_escape_string($connect, $_POST["password"]);
          $query = "SELECT * FROM users WHERE username = '$username'";
          $result = mysqli_query($connect, $query);
          if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_array($result)) {
                    if (password_verify($password, $row["password"])) {
                         //return true;  
                         $_SESSION["username"] = $username;
                         header("location:index.php");
                    } else {
                         //return false;  
                         echo '<script>alert("Wrong User Details")</script>';
                    }
               }
          } else {
               echo '<script>alert("Wrong User Details")</script>';
          }
     }
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
          <a href="#home">Home</a>
          <a href="#news">News</a>
          <a href="#contact">Contact</a>
          <a href="#about">About</a>
          <?php
          if (!isset($_SESSION["username"])) {
               // User is not logged in
               echo '<a class="active" href="login.php?action=login">Login</a>';

          }
          else {
               // User is  logged in
               echo '<a class="active" href="userInfo.php">'.$_SESSION["username"].'</a>';
          }
          ?>
     </div>
     <br /><br />
     <div class="container" style="width:500px;">
          <?php
          if (isset($_GET["action"]) == "login") {
          ?>
               <h3 align="center">Přihlášení</h3>
               <br />
               <form method="post">
                    <label>Enter Username</label>
                    <input type="text" name="username" class="form-control" />
                    <br />
                    <label>Enter Password</label>
                    <input type="text" name="password" class="form-control" />
                    <br />
                    <input type="submit" name="login" value="Login" class="btn btn-info" />
                    <br />
                    <p align="center"><a href="login.php">Register</a></p>
               </form>
          <?php
          } else {
          ?>
               <h3 align="center">Registrace</h3>
               <br />
               <form method="post">
                    <label>Enter Username</label>
                    <input type="text" name="username" class="form-control" />
                    <br />
                    <label>Enter Password</label>
                    <input type="text" name="password" class="form-control" />
                    <br />
                    <input type="submit" name="register" value="Register" class="btn btn-info" />
                    <br />
                    <p align="center"><a href="login.php?action=login">Login</a></p>
               </form>
          <?php
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