<?php
$connect = mysqli_connect("localhost", "root", "", "test");
$connect->set_charset("UTF-8");
$error = false;
session_start();
// user must be logged in
if (!isset($_SESSION["username"])) {
    header("location:login.php");
} else {
    if (isset($_POST["submit"])) {

        $recipeAuthor = $_SESSION["username"];

        //get recipename
        if (!$error) {
            if (empty($_POST["recipename"])) {
                echo '<script>alert("Není vyplněno jméno receptu")</script>';
                $error = true;
            } else {
                $recipename = mysqli_real_escape_string($connect, $_POST["recipename"]);
            }
        }

        //get directions
        if (!$error) {

            if (empty($_POST["directions"])) {
                echo '<script>alert("Není vyplněn postup")</script>';
                $error = true;
            } else {
                $directions = mysqli_real_escape_string($connect, $_POST["directions"]);
            }
        }

        // get user_id of signed user
        if (!$error) {
            $query = "SELECT ID FROM Users WHERE username = '$recipeAuthor'";
            $result = $connect->query($query);
            if (mysqli_num_rows($result) <= 0) {
                echo '<script>alert("you are not signed in!")</script>';
                $error = true;
            } else {
                $row = $result->fetch_assoc();
                $recipeAuthor_id = $row['ID'];
            }
        }


        // get originCountry_id of selected origin country 
        if (!$error) {

            if (empty($_POST["originCountry"])) {
                echo '<script>alert("Není zvolena země původu")</script>';
                $error = true;
            } else {
                $originCountry = mysqli_real_escape_string($connect, $_POST["originCountry"]);

                $query = "SELECT ID FROM OriginCountry WHERE name = '$originCountry'";
                $result = $connect->query($query);
                if (mysqli_num_rows($result) > 0) {
                    $row = $result->fetch_assoc();
                    $originCountry_id = $row['ID'];
                }
            }
        }

        // store image on server and get created URL if present
        if (!$error) {
            $imgUrl = "";
            if (isset($_FILES['img']) && ($_FILES['img']['size'] > 0)) {
                $uploaddir = 'Uploads/';
                $uploadfile = basename($_FILES['img']['name']);
                $uploadfile = str_replace(' ', '-', $uploadfile);
                // check if the image doesn't exists... if it does, change name in order to keep existing one
                $i = '';
                while (file_exists($uploaddir . $i . $uploadfile)) {
                    $i++;
                }
                $uploadfile = $uploaddir . $i . $uploadfile;
                //echo $uploadfile;
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $uploadfile)) {
                    $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/' . $uploadfile;
                } else {
                    echo '<script>alert("byl zvolen soubor v chybném formátu")</script>';
                }
                /*
            echo '<pre>';
            echo 'Here is some more debugging info:';
            print_r($_FILES);
            print "</pre>";*/
            } else {
                echo '<script>alert("Není vložen obrázek")</script>';
                $error = true;
            }
        }


        // store Recipe into database
        if (!$error) {

            $query = "INSERT INTO Recipes(author_id, name, date, directions, originCountry_id, imgUrl) VALUES('$recipeAuthor_id', '$recipename', curdate(), '$directions', '$originCountry_id', '$imgUrl')";
            if (mysqli_query($connect, $query)) {
                echo '<script>alert("recept byl úspěšně přidán")</script>';
                // remember id of stored recipe (it will be handy for "Recipe_Ingredient" table)
                $currentRecipeID = $connect->insert_id;
            } else {
                echo '<script>alert("Recept nebyl přidán, došlo k neočekávané chybě")</script>';
                $error = true;
            }
        }

        // store relationship between MealCategory and stored recipe into database


        //get "mealCategory" elements  
        if (!$error) {

            $query = "SELECT ID FROM MealCategory";
            $result = $connect->query($query);
            $i = 1;
            while ($i <= $result->num_rows) {
                // output data of each row
                if (isset($_POST["mealCategory" . $i])) {
                    //echo $i;
                    $query = "INSERT INTO Recipe_MealCategory(recipe_id, mealCategory_id) VALUES('$currentRecipeID', '$i')";
                    if (mysqli_query($connect, $query)) {
                    } else {
                        echo '<script>alert("Došlo k neočekávané chybě při pokusu o uložení vztahu mezi ingrediencí a receptem ")</script>';
                        $error = true;
                    }
                }
                $i++;
            }
        }

        if (!$error) {

            //store ingredients into database
            $ingredients = $_POST['ingredients'];
            $quantities = $_POST['quantities'];
            $units = $_POST['units'];
            $ingredients_ID = array();

            // check, if ingredients, quantities and units are really arrays
            if ((is_array($ingredients) || is_object($ingredients)) && (is_array($quantities) || is_object($quantities)) && (is_array($units) || is_object($units))) {
                // store each ingredient and relationship between ingredient and recipe
                for ($i = 0; $i < sizeof($ingredients); $i++) {
                    if (!empty($ingredients[$i])) {
                        // store ingredient
                        $query = "INSERT INTO Ingredients(name, quantity, unit) VALUES('$ingredients[$i]', '$quantities[$i]', '$units[$i]')";
                        if (mysqli_query($connect, $query)) {
                            // remember id of stored ingredient (it will be handy for "Recipe_Ingredient" table)
                            $ingredients_ID[$i] = $connect->insert_id;
                        } else {
                            echo '<script>alert("Došlo k neočekávané chybě při pokusu o uložení ingredience ")</script>';
                        }

                        // store relationship between ingredients and stored recipe into database

                        $query = "INSERT INTO Recipe_Ingredients(recipe_id, ingredient_id) VALUES('$currentRecipeID', '$ingredients_ID[$i]')";
                        if (mysqli_query($connect, $query)) {
                        } else {
                            echo '<script>alert("Došlo k neočekávané chybě při pokusu o uložení vztahu mezi ingrediencí a receptem ")</script>';
                        }
                    }
                }
            } else {
                echo '<script>alert("Došlo k neočekávané chybě")</script>';
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
            <input type="text" id="recipename" name="recipename" value=<?php echo isset($_POST['recipename']) ? htmlspecialchars($_POST['recipename'], ENT_QUOTES) : ''; ?>><br><br>




            <table>
                <tr>
                    <th>Pořadí</th>
                    <th>Název ingredience</th>
                    <th>Monžství</th>
                    <th>jednotky</th>
                </tr>
                <tr>
                    <td> 1 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][0]) ? htmlspecialchars($_POST['ingredients'][0], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][0]) ? htmlspecialchars($_POST['quantities'][0], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][0]) ? htmlspecialchars($_POST['units'][0], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 2 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][1]) ? htmlspecialchars($_POST['ingredients'][1], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][1]) ? htmlspecialchars($_POST['quantities'][1], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][1]) ? htmlspecialchars($_POST['units'][1], ENT_QUOTES) : ''; ?>> </td>
                </tr>

                <tr>
                    <td> 3 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][2]) ? htmlspecialchars($_POST['ingredients'][2], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][2]) ? htmlspecialchars($_POST['quantities'][2], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][2]) ? htmlspecialchars($_POST['units'][2], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 4 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][3]) ? htmlspecialchars($_POST['ingredients'][3], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][3]) ? htmlspecialchars($_POST['quantities'][3], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][3]) ? htmlspecialchars($_POST['units'][3], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 5 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][4]) ? htmlspecialchars($_POST['ingredients'][4], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][4]) ? htmlspecialchars($_POST['quantities'][4], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][4]) ? htmlspecialchars($_POST['units'][4], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 6 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][5]) ? htmlspecialchars($_POST['ingredients'][5], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][5]) ? htmlspecialchars($_POST['quantities'][5], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][5]) ? htmlspecialchars($_POST['units'][5], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 7 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][6]) ? htmlspecialchars($_POST['ingredients'][6], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][6]) ? htmlspecialchars($_POST['quantities'][6], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][6]) ? htmlspecialchars($_POST['units'][6], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 8 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][7]) ? htmlspecialchars($_POST['ingredients'][7], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][7]) ? htmlspecialchars($_POST['quantities'][7], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][7]) ? htmlspecialchars($_POST['units'][7], ENT_QUOTES) : ''; ?>> </td>
                </tr>

                <tr>
                    <td> 9 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][8]) ? htmlspecialchars($_POST['ingredients'][8], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][8]) ? htmlspecialchars($_POST['quantities'][8], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][8]) ? htmlspecialchars($_POST['units'][8], ENT_QUOTES) : ''; ?>> </td>
                </tr>
                <tr>
                    <td> 10 </td>
                    <td> <input type="text" name="ingredients[]" value=<?php echo isset($_POST['ingredients'][9]) ? htmlspecialchars($_POST['ingredients'][9], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="quantities[]" value=<?php echo isset($_POST['quantities'][9]) ? htmlspecialchars($_POST['quantities'][9], ENT_QUOTES) : ''; ?>> </td>
                    <td> <input type="text" name="units[]" value=<?php echo isset($_POST['units'][9]) ? htmlspecialchars($_POST['units'][9], ENT_QUOTES) : ''; ?>> </td>
                </tr>
            </table>



            <label for="process">Postu přípravy:</label>
            <textarea name="directions" rows="10" cols="50" placeholder="Zadejte postup"><?php echo isset($_POST['directions']) ? htmlspecialchars($_POST['directions'], ENT_QUOTES) : ''; ?></textarea><br>



            <label for="img">Obrázek:</label>
            <input type="file" name="img" accept="image/*"><br><br>

            <!-- meal category -->


            <label for="mealCategoryDiv">kategorie jídla</label>
            <div name="mealCategoryDiv" class="mealCategoryDiv">

                <?php
                $query = "SELECT ID, name FROM MealCategory";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $checked = isset($_POST["mealCategory" . $i]) ? "checked " : "";
                        echo '<input type="checkbox" name="mealCategory' . $i . '"' . $checked . ' value =' . $row['ID'] . '>' . $row['name'] . '<br>';
                        $i++;
                    }
                }
                ?>
            </div>


            <!-- origin country -->

            <label for="originCountry">Země původu:</label>
            <select name="originCountry" id="originCountry">
                <?php
                $query = "SELECT name FROM OriginCountry";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    // output data of each row

                    while ($row = $result->fetch_assoc()) {
                        $selected = (isset($_POST['originCountry']) && $_POST['originCountry'] == $row['name']) ? 'selected="selected"' : '';
                        echo "<option value=" . $row['name'] . ' ' . $selected . ">" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <input type="submit" name="submit">
        </form>
    </div>

</body>

<script type="text/javascript" src="checkRecipeForm.js"></script>

</html>