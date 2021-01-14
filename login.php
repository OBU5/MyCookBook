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
$connect = mysqli_connect("localhost", "root", "", "myCookBook");
// Check connection
if (!$connect) {
    die("Connection failed: No database found");
} else {
    $connect->set_charset("UTF-8");
    session_start();
}
if ($connect) {
    if (isset($_SESSION["username"])) {
        header("location:index.php");
    }
    if (isset($_POST["register"])) {

        //check, if inputs are not empty
        if (empty($_POST["username"])) {
            $php_errormsg = "Je potřeba vyplnit uživatelské jméno";
            $errorMsgType = "errorMessage";
        } elseif (empty($_POST["password"])) {
            $php_errormsg = "Je potřeba vyplnit heslo";
            $errorMsgType = "errorMessage";
        } elseif (empty($_POST["name"])) {
            $php_errormsg = "Je potřeba vyplnit jméno";
            $errorMsgType = "errorMessage";
        } elseif (empty($_POST["lastname"])) {
            $php_errormsg = "Je potřeba vyplnit příjmení";
            $errorMsgType = "errorMessage";
        } elseif (empty($_POST["email"])) {
            $php_errormsg = "Je potřeba vyplnit email";
            $errorMsgType = "errorMessage";
        }
        // check, if inputs are within the range
        elseif (strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 20) {
            $php_errormsg = "Uživatelské jméno musí být dlouhé 3 až 20 znaků";
            $errorMsgType = "errorMessage";
        } elseif (strlen($_POST["password"]) < 3 || strlen($_POST["password"]) > 40) {
            $php_errormsg = "Heslo musí být dlouhé 3 až 40 znaků";
            $errorMsgType = "errorMessage";
        } elseif (strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 20) {
            $php_errormsg = "Jméno musí být dlouhé 3 až 20 znaků";
            $errorMsgType = "errorMessage";
        } elseif (strlen($_POST["lastname"]) < 3 || strlen($_POST["lastname"]) > 20) {
            $php_errormsg = "Příjmení musí být dlouhé 3 až 20 znaků";
            $errorMsgType = "errorMessage";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $php_errormsg = "Zadaný email není platný";
            $errorMsgType = "errorMessage";
        } elseif (strlen($_POST["email"]) < 3 || strlen($_POST["email"]) > 40) {
            $php_errormsg = "Zadaný email není platný";
            $errorMsgType = "errorMessage";
        } else {
            $username = mysqli_real_escape_string($connect, $_POST["username"]);
            $email = mysqli_real_escape_string($connect, $_POST["email"]);
            $name = mysqli_real_escape_string($connect, $_POST["name"]);
            $lastname = mysqli_real_escape_string($connect, $_POST["lastname"]);
            // check if the username really doesn't exist
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                $php_errormsg = "Musíte zvolit jiné uživatelské jméno. Toto již existuje";
                $errorMsgType = "errorMessage";
            } else {
                // the username is OK
                $password = mysqli_real_escape_string($connect, $_POST["password"]);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users(name, lastname, email, username, password, role) VALUES('$name', '$lastname', '$email', '$username', '$password', 'Regular user')";
                if (mysqli_query($connect, $query)) {
                    $php_errormsg = "Registration Done";
                    $errorMsgType = "successMessage";
                }
            }
        }
    }
    if (isset($_POST["login"])) {
        //check, if inputs are not empty
        if (empty($_POST["username"])) {
            $php_errormsg = "Je potřeba zadat uživatelské jméno";
        } elseif (empty($_POST["password"])) {
            $php_errormsg = "Je potřeba zadat heslo";
        } else {
            $username = mysqli_real_escape_string($connect, $_POST["username"]);
            $password = mysqli_real_escape_string($connect, $_POST["password"]);
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if (password_verify($password, $row["password"])) {
                        //return true;
                        $_SESSION["username"] = htmlspecialchars($username,ENT_QUOTES);
                        header("location:index.php");
                    } else {
                        //return false;
                        $php_errormsg = "Zadali jste špatně uživatelské jméno nebo heslo";
                        $errorMsgType = "errorMessage";
                    }
                }
            } else {
                $php_errormsg = "Zadané uživatelské jméno neexistuje";
                $errorMsgType = "errorMessage";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <title>My CookBook</title>
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
    <br><br>
    <main class="userDiv">
        <?php
        if (isset($_GET["action"]) == "login") {
        ?>
            <h3>Přihlášení</h3>
            <br>
            <form method="post">
                <label for="username">Enter Username</label>
                <input type="text" id="username" name="username" class="form-control" maxlength="20" minlength="3" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                <br>
                <label for="password">Enter Password</label>
                <input type="password" id="password" name="password" maxlength="40" minlength="3" required class="form-control">
                <br>
                <p id="errorMsg" class="<?php echo $errorMsgType; ?>"><?php echo $php_errormsg; ?></p>

                <input type="submit" name="login" value="Login" class="btn btn-info">
                <br>
                <p><a href="login.php">Registrace</a></p>
            </form>
        <?php
        } else {
        ?>
            <h3>Registrace</h3>
            <br>
            <form method="post">
                <label for="name">Zadejte jméno</label>
                <input type="text" id="name" name="name" class="form-control" maxlength="20" minlength="3" pattern="[A-Ža-ž]{3,20}" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : ''; ?>">
                <br>
                <label for="lastname">Zadejte příjmení </label>
                <input type="text" id="lastname" name="lastname" class="form-control" maxlength="20" minlength="3" pattern="[A-Ža-ž]{3,20}" required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : ''; ?>">
                <br>
                <label for="email">Zadejte email</label>
                <input type="text" id="email" name="email" class="form-control" maxlength="40" minlength="3" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,40}$" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
                <br>
                <label for="username">Zadejte uživatelské jméno</label>
                <input type="text" id="username" name="username" class="form-control" maxlength="20" minlength="3" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                <br>
                <label for="password">Zadejte heslo</label>
                <input type="password" id="password" name="password" class="form-control" maxlength="40" minlength="3" required>
                <br>
                <p id="errorMsg" class="<?php echo $errorMsgType; ?>"><?php echo $php_errormsg; ?></p>
                <input type="submit" name="register" value="Register" class="btn btn-info" />
                <br>
                <p><a href="login.php?action=login">Přihlášení</a></p>
            </form>
        <?php
        }
        ?>
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