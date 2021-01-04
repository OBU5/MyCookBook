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
          $query = "DELETE FROM Users WHERE ID = '$currentUserID'";
          if (mysqli_query($connect, $query)) {
               $php_errormsg = "Uživatel" . $currentUserID . " byl smazán";
               $errorMsgType = "successMessage";
               if ($currentUserID == $editUserID) {
                    session_destroy();
               }
          } else {
               $php_errormsg = "Tento účet nelze smazat, jelikož se k němu pojí existující recepty";
               $errorMsgType = "errorMessage";
               $error = true;
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
          <p id="errorMsg" class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>

          </form>
     </div>
     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
          </p>
     </footer>
</body>


</html>