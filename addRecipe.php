<?php
$connect = mysqli_connect("localhost", "root", "", "test");
session_start();
// user must be logged in
if (!isset($_SESSION["username"])) {
    header("location:login.php");
} else {
    if (isset($_POST["submit"])) {

        $recipeAuthor = $_SESSION["username"];
        // check if the fields are filled
        if (empty($_POST["recipename"])) {
            echo '<script>alert("Nevplnil jste všechna políčka")</script>';
        } else {
            $recipename = mysqli_real_escape_string($connect, $_POST["recipename"]);
            // get user_id of signed user
            $query = "SELECT ID FROM Users WHERE username = '$recipeAuthor'";
            $result = $connect->query($query);
            if (mysqli_num_rows($result) <= 0) {
                echo '<script>alert("you are not signed in!")</script>';
            } else {
                $row = $result->fetch_assoc();
                $query = "INSERT INTO Recipes(user_id, name, date) VALUES('$row[ID]', '$recipename', curdate())";
                if (mysqli_query($connect, $query)) {

                    $ingredients = $_POST['ingredients'];
                    if (is_array($ingredients) || is_object($ingredients)) {

                        foreach ($ingredients as $ingredient) :
                            echo $ingredient . "<br>";
                        endforeach;
                    }
                    echo '<script>alert("recept byl úspěšně přidán")</script>';
                } else {
                    echo '<script>alert("Recept nebyl přidán, došlo k neočekávané chybě")</script>';
                }
            }
            if (isset($_FILES['img'])) {
                $uploaddir = 'Uploads/';
                $uploadfile = $uploaddir . basename($_FILES['img']['name']);
                $uploadfile = str_replace(' ', '-', $uploadfile);
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $uploadfile)) {
                    echo "File is valid, and was successfully uploaded.\n";
                    echo ' <a href = http://' . $_SERVER['SERVER_NAME'].'/MyCookBook/' .$uploadfile.'> Zobrazit obrázek </a>';
                } else {
                    echo "<p> Upload failed </p>";
                }

                echo '<pre>';
                echo 'Here is some more debugging info:';
                print_r($_FILES);
                print "</pre>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Styles/styles.css">
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
        <form enctype="multipart/form-data" method="post">

            <label for="recipename">Název:</label>
            <input type="text" id="recipename" name="recipename"><br><br>



            
            <table>
                <tr>
                    <th>Pořadí</th>
                    <th>Název ingredience</th>
                    <th>Monžství</th>
                    <th>jednotky</th>
                </tr>
                <tr>
                    <td> 1 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 2 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 3 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 4 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 5 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 6 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 7 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 8 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 9 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
                <tr>
                    <td> 10 </td>
                    <td> <input type="text" name="ingredients[]"> </td>
                    <td> <input type="text" name="quantities[]"> </td>
                    <td> <input type="text" name="units[]"> </td>
                </tr>
            </table>

            

            <label for="process">Postu přípravy:</label>
            <textarea name="directions" id="directions" rows="10" cols="50" placeholder="Zadejte postup"></textarea><br>



            <label for="img">Obrázek:</label>
            <input type="file" id="img" name="img" accept="image/*"><br><br>

            <!-- meal category -->
            <label for="mealCategoryDiv">kategorie jídla</label>
            <div name="mealCategoryDiv" class="mealCategoryDiv">
                <input type="checkbox" name="mealCategory[]" value="mainDish">
                <label for="mealCategory1"> Hlavní chod</label><br>
                <input type="checkbox" name="mealCategory[]" value="starter">
                <label for="mealCategory2"> Předkrm</label><br>
                <input type="checkbox" name="mealCategory[]" value="desert">
                <label for="mealCategory3"> Dezert</label><br><br>
            </div>


            <!-- origin country -->

            <label for="originCountry">Země původu:</label>
            <select name="originCountry" id="originCountry">
                <option value="Vietnam">Vietnam</option>
                <option value="Italy">Italy</option>
                <option value="Czechia">Česko</option>
                <option value="Czechia">Není jasné</option>
            </select><br><br>

            <input type="submit" name="submit">
        </form>
    </div>

</body>

<script type="text/javascript" src="checkRecipeForm.js"></script>

</html>