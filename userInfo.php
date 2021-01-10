<?php
session_start();
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
?>
<!DOCTYPE html>
<html lang="cs">


<head>
    <title>My CookBook</title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/3565/3565407.svg" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <h2>Informace o Vás</h2>
        <?php
        if (isset($_SESSION["username"])) {

            // Create connection
            $connect = mysqli_connect("localhost", "bureson1", "webove aplikace", "bureson1");
            // Check connection
            if (!$connect) {
                die("Connection failed: No database found");
            } else {
                $connect->set_charset("UTF-8");
            }
            if ($connect) {
                $currentUser = $_SESSION["username"];
                // Check connection
                if ($connect->connect_error) {
                    die("Connection failed: " . $connect->connect_error);
                }                
                // to be able to see results even with chars like" <, >, /, ..."
                $currentUserDecoded = htmlspecialchars_decode($_SESSION["username"]);
                $query = "SELECT ID, name, lastname, email, username, role FROM users WHERE username = '$currentUserDecoded'";
                $result = $connect->query($query);

                if ($result->num_rows > 0) {
                    // output data of each row

                    $row = $result->fetch_assoc();
                    $adminButton  = "";

                    if ($row["role"] == "Admin") {
                        $adminButton = "<button type=button onclick=location.href='viewAllUserInfo.php'>Zobrazit všechny &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-search'></i></button>";
                    }
                    echo '<table class = "userInfo">
                              <tr>
                                   <th> jméno </th>
                                   <td>' . htmlspecialchars($row["name"],ENT_QUOTES) . '</td>
                              <tr/>
                              <tr>
                                   <th> Příjmení </th>
                                   <td>' . htmlspecialchars($row["lastname"],ENT_QUOTES) . '</td>
                              <tr/>
                              <tr>
                                   <th> email </th>
                                   <td>' . htmlspecialchars($row["email"],ENT_QUOTES) . '</td>
                              <tr/>
                              <tr>
                                   <th> Username </th>
                                   <td>' . htmlspecialchars($row["username"],ENT_QUOTES) . '</td>
                              <tr/>
                              <tr>
                                   <th> Role </th>
                                   <td>' . htmlspecialchars($row["role"],ENT_QUOTES) . '</td>
                              <tr/>                              
                         </table>
                         <br><br>
                         <button type=button onclick=location.href="editLogin.php?id=' . $row["ID"] .  '">Upravit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-edit"></i></button>    
                         ' . $adminButton . '         
                         ';
                } else {
                    echo "0 results";
                }

                echo '<br><br>';
                echo '<label><a href="logout.php">Logout</a></label>';
            } else {
                echo '<p class=errorMessage>Nejste přihlášen</p>';
            }
        }
        ?>

    </main>
    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>
</body>

</html>