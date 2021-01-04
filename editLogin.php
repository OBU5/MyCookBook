<?php
$errorMsgType = "";
$php_errormsg = "";
$error = false;
$connect = mysqli_connect("localhost", "root", "", "test");
// Check connection
if (!$connect) {
     die("Connection failed: No database found");
} else {
     $connect->set_charset("UTF-8");
     session_start();
}
if ($connect) {
     $editUserID = isset($_GET['id']) ? $_GET['id'] : 0;


     $username = "";
     $email = "";
     $name  = "";
     $lastname = "";
     $password = "";
     $role = "";
     $currentUser = "";
     if (isset($_SESSION["username"])) {
          $currentUser = $_SESSION["username"];
     } else {
          header("location:index.php");
     }
     //get user_id of signed user
     $query1 = "SELECT ID, role FROM Users WHERE username = '$currentUser'";
     $result1 = $connect->query($query1);
     if (mysqli_num_rows($result1) <= 0) {
          $php_errormsg = "Nejste přihlášen";
          $errorMsgType = "errorMessage";
          $error = true;
     } else {
          $row1 = $result1->fetch_assoc();
          $currentUserID = $row1['ID'];
          $currentUserRole = $row1['role'];
     }
     //update only if current user is author, of the role of user is "Admin"
     if ($currentUserID == $editUserID || $currentUserRole == "Admin") {
          if (isset($_POST["register"])) {
               //check, if inputs are not empty
               if (empty($_POST["username"])) {
                    $php_errormsg = "Je potřeba vyplnit uživatelské jméno";
                    $errorMsgType = "errorMessage";
               } else if (empty($_POST["password"])) {
                    $php_errormsg = "Je potřeba vyplnit heslo";
                    $errorMsgType = "errorMessage";
               } else if (empty($_POST["name"])) {
                    $php_errormsg = "Je potřeba vyplnit jméno";
                    $errorMsgType = "errorMessage";
               } else if (empty($_POST["lastname"])) {
                    $php_errormsg = "Je potřeba vyplnit příjmení";
                    $errorMsgType = "errorMessage";
               } else if (empty($_POST["email"])) {
                    $php_errormsg = "Je potřeba vyplnit email";
                    $errorMsgType = "errorMessage";
               }
               // check, if inputs are within the range
               else if (strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 20) {
                    $php_errormsg = "Uživatelské jméno musí být dlouhé 3 až 20 znaků";
                    $errorMsgType = "errorMessage";
               } else if (strlen($_POST["password"]) < 3 || strlen($_POST["password"]) > 40) {
                    $php_errormsg = "Heslo musí být dlouhé 3 až 40 znaků";
                    $errorMsgType = "errorMessage";
               } else if (strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 20) {
                    $php_errormsg = "Jméno musí být dlouhé 3 až 20 znaků";
                    $errorMsgType = "errorMessage";
               } else if (strlen($_POST["lastname"]) < 3 || strlen($_POST["lastname"]) > 20) {
                    $php_errormsg = "Příjmení musí být dlouhé 3 až 20 znaků";
                    $errorMsgType = "errorMessage";
               } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $php_errormsg = "Zadaný email není platný";
                    $errorMsgType = "errorMessage";
               } else {
                    //check if ID is valid
                    $query = "SELECT * FROM users WHERE ID = '$editUserID'";
                    $result = mysqli_query($connect, $query);

                    if ($result->num_rows > 0) {
                         $row = $result->fetch_assoc();

                         $username = mysqli_real_escape_string($connect, $_POST["username"]);
                         $email = mysqli_real_escape_string($connect, $_POST["email"]);
                         $name = mysqli_real_escape_string($connect, $_POST["name"]);
                         $lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);
                         $role = isset($_POST["role"]) ? mysqli_real_escape_string($connect, $_POST["role"]) : "";
                         // check if the username really doesn't exist
                         // the username is OK
                         $password = mysqli_real_escape_string($connect, $_POST["password"]);
                         $password = password_hash($password, PASSWORD_DEFAULT);
                         $query = "UPDATE users SET  name = '$name', lastname = '$lastname', username = '$username', email = '$email' WHERE ID = '$editUserID'";
                         //only origin user can change his/her password
                         if ($row["username"] == $_SESSION["username"]) {
                              $query = "UPDATE users SET  name = '$name', lastname = '$lastname', username = '$username', email = '$email', password = '$password' WHERE ID = '$editUserID'";
                         } else if ($currentUserRole == "Admin") {
                              $query = "UPDATE users SET  name = '$name', lastname = '$lastname', username = '$username', email = '$email', role = '$role' WHERE ID = '$editUserID'";
                         }
                         if (mysqli_query($connect, $query)) {
                              $php_errormsg = "Údaje k danému účtu byly úspěšně změněny";
                              $errorMsgType = "successMessage";
                         } else {
                              $php_errormsg = "Došlo k neočekávané chybě";
                              $errorMsgType = "errorMessage";
                         }
                    } else {
                         $php_errormsg = "Dané identifikační číslo neexistuje";
                         $errorMsgType = "errorMessage";
                    }
               }
          }
          //get request
          else {

               //check if ID is valid
               $query = "SELECT * FROM users WHERE ID = '$editUserID'";
               $result = mysqli_query($connect, $query);
               if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $username = $row["username"];
                    $email = $row["email"];
                    $name = $row["name"];
                    $lastname = $row["lastname"];
                    $password = $row["password"];
                    $role = $row["role"];
               } else {
                    $php_errormsg = "Dané identifikační číslo neexistuje";
                    $errorMsgType = "errorMessage";
               }
          }
     } else {
          $php_errormsg = "Nemáte práva na tuto operaci";
          $errorMsgType = "errorMessage";
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
          <h3 align="center">Změna uživatelských údajů</h3>
          <br />
          <form method="post">
               <label>Zadejte jméno</label>
               <input type="text" name="name" class="form-control" pattern="[A-Ža-ž]{3,40}" required value=<?php echo $name; ?>>
               <br>
               <label>Zadejte příjmení </label>
               <input type="text" name="lastname" class="form-control" pattern="[A-Ža-ž]{3,40}" required value=<?php echo $lastname; ?>>
               <br>
               <label>Zadejte email</label>
               <input type="text" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required value=<?php echo $email; ?>>
               <br>
               <label>Zadejte uživatelské jméno</label>
               <input type="text" name="username" class="form-control" maxlength="40" minlength="3" required value=<?php echo $username; ?>>
               <br>
               <?php
               if ($currentUserRole == "Admin") {
                    echo '
                         <label>Zadejte Roli</label>
                              <input type="text" name="role" class="form-control" maxlength="20" minlength="3" required value=' . $role . '>
                         <br>';
               }

               ?>
               <label>Zadejte heslo</label>
               <input type="password" name="password" class="form-control" maxlength="20" minlength="3" required>
               <br>

               <p id="errorMsg" class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>
               <input type="submit" name="register" value="Změnit uživatelské údaje" class="btn btn-info" />
               <br>
          </form>
     </div>
     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
          </p>
     </footer>

     <script src="Scripts/checkLoginForm.js"></script>
</body>


</html>