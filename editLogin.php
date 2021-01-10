<?php
$bodyClass = "style1";
if (isset($_COOKIE["style"])) {
     if ($_COOKIE["style"] == "1") {
          $bodyClass = "style1";
     } elseif ($_COOKIE["style"] == "2") {
          $bodyClass = "style2";
     } elseif ($_COOKIE["style"] == "3") {
          $bodyClass = "style3";
     } elseif ($_COOKIE["style"] == "4") {
          $bodyClass = "style4";
     }
}
$errorMsgType = "";
$php_errormsg = "";
$error = false;
$connect = mysqli_connect("localhost", "bureson1", "webove aplikace", "bureson1");
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
     $currentUserID = 0;          
     $currentUserRole = "";

     if (isset($_SESSION["username"])) {
          $currentUser = $_SESSION["username"];
     } else {
          header("location:index.php");
     }
     //get user_id of signed user
     // to be able to see results even with chars like" <, >, /, ..."
     $currentUserDecoded = htmlspecialchars_decode($_SESSION["username"]);
     $query1 = "SELECT ID, role FROM users WHERE username = '$currentUserDecoded'";
     $result1 = $connect->query($query1);
     if (mysqli_num_rows($result1) <= 0) {
          $php_errormsg = "Nejste přihlášen";
          $errorMsgType = "errorMessage";
          $error = true;
     } else {
          $row1 = $result1->fetch_assoc();
          $currentUserID = $row1['ID'];
          $currentUserRole = htmlspecialchars($row1['role'],ENT_QUOTES);
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

                         $username =  htmlspecialchars(mysqli_real_escape_string($connect, $_POST["username"]),ENT_QUOTES);
                         $email =  htmlspecialchars(mysqli_real_escape_string($connect, $_POST["email"]),ENT_QUOTES);
                         $name =  htmlspecialchars(mysqli_real_escape_string($connect, $_POST["name"]),ENT_QUOTES);
                         $lastname =  htmlspecialchars(mysqli_real_escape_string($connect, $_POST["lastname"]),ENT_QUOTES);
                         $role = isset($_POST["role"]) ?  htmlspecialchars(mysqli_real_escape_string($connect, $_POST["role"]),ENT_QUOTES) : "";
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
                    $username =  htmlspecialchars($row["username"],ENT_QUOTES);
                    $email =  htmlspecialchars($row["email"],ENT_QUOTES);
                    $name =  htmlspecialchars($row["name"],ENT_QUOTES);
                    $lastname =  htmlspecialchars($row["lastname"],ENT_QUOTES);
                    $password =  htmlspecialchars($row["password"],ENT_QUOTES);
                    $role =  htmlspecialchars($row["role"],ENT_QUOTES);
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
     <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/3565/3565407.svg" type="image/gif" sizes="16x16">
     <link rel="stylesheet" href="Styles/styles.css">
     <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body class="<?php echo $bodyClass; ?>">
     <!--Navigation bar-->
     <nav class="topnav">
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
          <select onchange="location = this.value;">
               <option hidden selected disabled>Styl</option>
               <option value="changeStyle.php?style=1">Zeleninový</option>
               <option value="changeStyle.php?style=2">Masový</option>
               <option value="changeStyle.php?style=3">Těstovinový</option>
               <option value="changeStyle.php?style=4">Ovocný</option>
          </select>
     </nav>
     <br /><br />
     <main class="userDiv">
          <h1>Změna uživatelských údajů</h1>
          <br />
          <form method="post">
               <label for="name">Zadejte jméno</label>
               <input type="text" id="name" name="name" class="form-control" pattern="[A-Ža-ž]{3,40}" required value=<?php echo $name; ?>>
               <br>
               <label for="lastname">Zadejte příjmení </label>
               <input type="text" id="lastname" name="lastname" class="form-control" pattern="[A-Ža-ž]{3,40}" required value=<?php echo $lastname; ?>>
               <br>
               <label for="email">Zadejte email</label>
               <input type="text" id="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required value=<?php echo $email; ?>>
               <br>
               <label for="username">Zadejte uživatelské jméno</label>
               <input type="text" id="username" name="username" class="form-control" maxlength="40" minlength="3" required value=<?php echo $username; ?>>
               <br>
               <?php
               //show role only to admin
               if ($currentUserRole == "Admin") {
                    echo '
                         <label for="role">Zadejte Roli</label>
                              <input type="text" id="role" name="role" class="form-control" maxlength="20" minlength="3" required value=' . $role . '>
                         <br>';
               }

               //hide password of other user to admin... he shouldnt change password of other users... vale is "xxxx" just to pass all tests on filled input
               if ($currentUserRole == "Admin" && $currentUserID != $editUserID) {
                    echo '
                    <label hidden for="password">Zadejte heslo</label>
                    <input type="hidden" id="password" type="password" name="password" class="form-control" maxlength="40" minlength="3" value = "xxxx">
                    <br>';
               } else {
                    echo '
                    <label for="password">Zadejte heslo</label>
                    <input type="password" id="password" name="password" class="form-control" maxlength="40" minlength="3" value ="" required>
                    <br>';
               } ?>

               <p id="errorMsg" class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>
               <input type="submit" name="register" value="Změnit uživatelské údaje" class="btn btn-info" />
               <br>
          </form>
     </main>
     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
          </p>
     </footer>

     <script src="Scripts/checkLoginForm.js"></script>
</body>


</html>