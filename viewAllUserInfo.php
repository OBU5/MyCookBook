<?php
$allowed = true;
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
// if the user is not logged in, redirrect him
if (!isset($_SESSION["username"])) {
    header("location:index.php?action=login");
}
$connect = mysqli_connect("localhost", "bureson1", "webove aplikace", "bureson1");
// Check connection
if (!$connect) {
    die("Connection failed: No database found");
} else {
    $connect->set_charset("UTF-8");
}
if ($connect) {
    $query = "SELECT * FROM users";
    $result = $connect->query($query);

    $currentUser = "";
    $currentUserID = "";
    $currentUserRole = "";
    if (isset($_SESSION["username"])) {
        $currentUser = $_SESSION["username"];
    }
    //get user_id of signed user
    $query1 = "SELECT ID, role FROM users WHERE username = '$currentUser'";
    $result1 = $connect->query($query1);
    if (mysqli_num_rows($result1) <= 0) {
        // user is not logged in
        header("location:index.php?action=login");
    } else {
        $row1 = $result1->fetch_assoc();
        $currentUserID = $row1['ID'];
        $currentUserRole = $row1['role'];
    }
    // only admin should be allowed to see all users
    if ($currentUserRole == "Admin") {
        if ($result->num_rows > 0) {
            $total_pages = $result->num_rows;

            // Check if the page number is specified and check if it's a number, if not -> return the default page number which is 1.
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;


            // Number of results to show on each page.
            $num_results_on_page = 5;
            $query = "SELECT * FROM users LIMIT ?,?";

            if ($stmt = $connect->prepare($query)) {
                // Calculate the page to get the results we need from our table.
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                $stmt->execute();
                // Get the results...
                $result = $stmt->get_result();
            }
        } else {
            echo "<p>0 results</p>";
        }
    } else {
        $allowed = false;
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
        <h3>Informace o Vás</h3>
        <br>
        <?php
        // output data of each row
        if ($allowed) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["ID"]; ?>
                <table class=userInfo>
                    <tr>
                        <th> jméno </th>
                        <td><?php echo $row["name"]; ?></td>
                    </tr>
                    <tr>
                        <th> Příjmení </th>
                        <td><?php echo $row["lastname"]; ?></td>
                    </tr>
                    <tr>
                        <th> email </th>
                        <td><?php echo $row["email"]; ?></td>
                    </tr>
                    <tr>
                        <th> Username </th>
                        <td><?php echo $row["username"]; ?></td>
                    </tr>
                    <tr>
                        <th> Role </th>
                        <td><?php echo $row["role"]; ?></td>
                    </tr>
                </table>
                <br>
                <button type=button onclick="location.href='editLogin.php?id=<?php echo  $id; ?> '">Upravit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-edit'></i></button>
                <br><br>
                <hr>
                <?php
            }
        }
        if (!$allowed) {
            echo '<p class="errorText">Na tuto akci nemáte oprávnění</p>';
        }
        echo '<br><br>';
                ?><?php
                    // Pagination
                    if ($allowed && ceil($total_pages / $num_results_on_page) > 0) : ?>

                <div class="pagination">
                    <ul class="pagination">
                        <?php if ($page > 1) : ?>
                            <li class="prev"><a href="viewAllUserInfo.php?page=<?php echo $page - 1 ?>">Předchozí</a></li>
                        <?php endif; ?>

                        <?php if ($page > 3) : ?>
                            <li class="start"><a href="viewAllUserInfo.php?page=1">1</a></li>
                            <li class="dots">...</li>
                        <?php endif; ?>

                        <?php if ($page - 2 > 0) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                        <?php if ($page - 1 > 0) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                        <li class="currentpage"><a href="viewAllUserInfo.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
                            <li class="dots">...</li>
                            <li class="end"><a href="viewAllUserInfo.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                        <?php endif; ?>

                        <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
                            <li class="next"><a href="viewAllUserInfo.php?page=<?php echo $page + 1 ?>">Další</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
    </main>

    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>
</body>

</html>