<?php
$connect = mysqli_connect("localhost", "root", "", "test");
session_start();
// user must be logged in
if (!isset($_SESSION["username"])) {
    header("location:login.php");
} else {
    $recipeAuthor = $_SESSION["username"];
    // check if the fields are filled
    if (empty($_POST["recipename"])) {
        echo '<script>alert("Nevplnil jste všechna políčka")</script>';
    } else {
        $recipename = mysqli_real_escape_string($connect, $_POST["recipename"]);
        // get user_id of signed user
        $query = "SELECT user_id FROM Users WHERE username = '$recipeAuthor'";
        $result = $connect->query($query);
        if (mysqli_num_rows($result) <= 0) {
            echo '<script>alert("you are not signed in!")</script>';
        } else {
            $row = $result->fetch_assoc();
            $query = "INSERT INTO recipes(user_id, recipename, date) VALUES('$row[user_id]', '$recipename', curdate())";
            if (mysqli_query($connect, $query)) {
                echo '<script>alert("recept byl úspěšně přidán")</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <!--Navigation bar-->
    <div class="topnav">

        <a class="active" href="index.php">Home</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
        <?php
        if (!isset($_SESSION["username"])) {
            // User is not logged in
            echo '<a href="login.php?action=login">Login</a>';
        } else {
            // User is  logged in
            echo '<a href="userInfo.php">' . $_SESSION["username"] . '</a>';
        }
        ?>
    </div>

    <div style="padding-left:16px">
        <h2>Top Navigation Example</h2>
        <p>Some content..</p>
    </div>

    <div class="recipeDiv">
        <form  method="post">

            <label for="recipename">Název:</label>
            <input type="text" id="recipename" name="recipename"><br><br>

            <label for="img">Obrázek:</label>
            <input type="file" id="img" name="img" accept="image/*"><br><br>

            <label for="author">Autor</label>
            <input type="text" id="author" name="author"><br><br>

            <label for="creationDate">Datum přidání:</label>
            <input type="date" id="creationDate" name="creationDate"><br><br>

            <!-- meal category -->
            <label for="mealCategoryDiv">kategorie jídla</label>
            <div name="mealCategoryDiv" class="mealCategoryDiv">
                <input type="checkbox" name="mealCategory" id="mealCategory1" value="mainDish">
                <label for="mealCategory1"> Hlavní chod</label><br>
                <input type="checkbox" name="mealCategory" id="mealCategory2" value="starter">
                <label for="mealCategory2"> Předkrm</label><br>
                <input type="checkbox" name="mealCategory" id="mealCategory3" value="desert">
                <label for="mealCategory3"> Dezert</label><br><br>
            </div>


            <!-- origin country -->

            <label for="originCountry">Země původu:</label>
            <select name="originCountry" id="originCountry">
                <option value="Vietnam">Vietnam</option>
                <option value="Italy">Italy</option>
                <option value="Czechia">Czechia</option>
            </select><br><br>


            <label for="tags">Tagy:</label>
            <textarea name="tags" id="tags" rows="10" cols="50" placeholder="tagy oddělta čárkou"></textarea><br>
            <label for="tags">Ingredience:</label>
            <textarea name="ingredients" id="ingredients" rows="10" cols="50" placeholder="Zadejte ingredience"></textarea><br>
            <label for="process">Postu přípravy:</label>
            <textarea name="process" id="process" rows="10" cols="50" placeholder="Zadejte postup"></textarea><br>


            <label for="originalURL">Odkaz na originální recept</label>
            <input type="url" id="originalURL" name="originalURL"><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>

</body>

<script type="text/javascript" src="checkRecipeForm.js"></script>

</html>