<?php
$connect = mysqli_connect("localhost", "root", "", "test");
session_start();
if (isset($_SESSION["username"])) {
     header("location:entry.php");
}
if (isset($_POST["register"])) {

     //check, if inputs are not empty
     if (empty($_POST["username"])) {
          echo '<script>alert("Je potřeba vyplnit uživatelské jméno")</script>';
     } else if (empty($_POST["password"])) {
          echo '<script>alert("Je potřeba vyplnit heslo")</script>';
     } else if (empty($_POST["name"])) {
          echo '<script>alert("Je potřeba vyplnit jméno")</script>';
     } else if (empty($_POST["lastname"])) {
          echo '<script>alert("Je potřeba vyplnit příjmení")</script>';
     } else if (empty($_POST["email"])) {
          echo '<script>alert("Je potřeba vyplnit email")</script>';
     }
     // check, if inputs are within the range
     else if (strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 12) {
          echo '<script>alert("Uživatelské jméno musí být dlouhé 3 až 12 znaků")</script>';
     } else if (strlen($_POST["password"]) < 3 || strlen($_POST["password"]) > 20) {
          echo '<script>alert("Heslo musí být dlouhé 3 až 20 znaků")</script>';
     } else if (strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 12) {
          echo '<script>alert("Jméno musí být dlouhé 3 až 12 znaků")</script>';
     } else if (strlen($_POST["lastname"]) < 3 || strlen($_POST["lastname"]) > 12) {
          echo '<script>alert("Příjmení musí být dlouhé 3 až 12 znaků")</script>';
     } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
          echo '<script>alert("Zadaný email není platný")</script>';
     } else {

          $username = mysqli_real_escape_string($connect, $_POST["username"]);
          $email = mysqli_real_escape_string($connect, $_POST["email"]);
          $name = mysqli_real_escape_string($connect, $_POST["name"]);
          $lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);
          // check if the username really doesn't exist
          $query = "SELECT * FROM users WHERE username = '$username'";
          $result = mysqli_query($connect, $query);
          if (mysqli_num_rows($result) > 0) {
               echo '<script>alert("Musíte zvolit jiné uživatelské jméno. Toto již existuje")</script>';
          } else {
               // the username is OK
               $password = mysqli_real_escape_string($connect, $_POST["password"]);
               $password = password_hash($password, PASSWORD_DEFAULT);
               $query = "INSERT INTO users(name, lastname, email, username, password, role) VALUES('$name', '$lastname', '$email', '$username', '$password', 'Regular user')";
               if (mysqli_query($connect, $query)) {
                    echo '<script>alert("Registration Done")</script>';
               }
          }
     }
}
if (isset($_POST["login"])) {
     //check, if inputs are not empty
     if (empty($_POST["username"])) {
          echo '<script>alert("Je potřeba zadat uživatelské jméno")</script>';
     } else if (empty($_POST["password"])) {
          echo '<script>alert("Je potřeba zadat heslo")</script>';
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
                         echo '<script>alert("Zadali jste špatně uživatelské jméno nebo heslo")</script>';
                    }
               }
          } else {
               echo '<script>alert("Zadané uživatelské jméno neexistuje")</script>';
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
          <?php
          if (isset($_GET["action"]) == "login") {
          ?>
               <h3 align="center">Přihlášení</h3>
               <br>
               <form method="post">
                    <label>Enter Username</label>
                    <input type="text" name="username" class="form-control" value=<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <label>Enter Password</label>
                    <input type="password" name="password" class="form-control" >
                    <br>
                    <input type="submit" name="login" value="Login" class="btn btn-info" >
                    <br>
                    <p align="center"><a href="login.php">Register</a></p>
               </form>
          <?php
          } else {
          ?>
               <h3 align="center">Registrace</h3>
               <br />
               <form method="post">
                    <label>Zadejte jméno</label>
                    <input type="text" name="name" class="form-control" value=<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <label>Zadejte příjmení </label>
                    <input type="text" name="lastname" class="form-control" value=<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <label>Zadejte email</label>
                    <input type="text" name="email" class="form-control" value=<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <label>Zadejte uživatelské jméno</label>
                    <input type="text" name="username" class="form-control" value=<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <label>Zadejte heslo</label>
                    <input type="password" name="password" class="form-control" value=<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>>
                    <br>
                    <input type="submit" name="register" value="Register" class="btn btn-info" />
                    <br>
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

     <script src="Scripts/checkLoginForm.js"></script>
</body>


</html>