<?php

$errorMsgType = "";
$php_errormsg = "";
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
                $php_errormsg = "Není vyplněno jméno receptu";
                $errorMsgType = "errorMessage";
                $error = true;
            } else if (strlen($_POST["recipename"]) > 39) {
                $php_errormsg = "Překročili jste maximální počet znaků pro název receptu";
                $error = true;
            } else {
                $recipename = mysqli_real_escape_string($connect, $_POST["recipename"]);
            }
        }

        //get directions
        if (!$error) {
            if (empty($_POST["directions"])) {
                $php_errormsg = "Není vyplněn postup";
                $errorMsgType = "errorMessage";
                $error = true;
            } else if (strlen($_POST["directions"]) > 999) {
                $php_errormsg = "Překročili jste maximální počet znaků pro postup receptu";
                $errorMsgType = "errorMessage";
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
                $php_errormsg = "Nejste přihlášen";
                $errorMsgType = "errorMessage";
                $error = true;
            } else {
                $row = $result->fetch_assoc();
                $recipeAuthor_id = $row['ID'];
            }
        }


        // get originCountry_id of selected origin country 
        if (!$error) {

            if (empty($_POST["originCountry"])) {
                $php_errormsg = "Není zvolena země původu";
                $errorMsgType = "errorMessage";
                $error = true;
            } else {
                $originCountry = mysqli_real_escape_string($connect, $_POST["originCountry"]);

                $query = "SELECT ID FROM OriginCountry WHERE name = '$originCountry'";
                $result = $connect->query($query);
                if (mysqli_num_rows($result) > 0) {
                    $row = $result->fetch_assoc();
                    $originCountry_id = $row['ID'];
                }
                //check, if the originCountry is into database
                else {
                    $php_errormsg = "Není zvolena země původu";
                    $errorMsgType = "errorMessage";
                    $error = true;
                }
            }
        }



        //check if ingredients are ok
        $ingredients = $_POST['ingredients'];
        $quantities = $_POST['quantities'];
        $units = $_POST['units'];
        $ingredients_ID = array();
        $atLeastOneIngredientExists = false;
        if ((is_array($ingredients) || is_object($ingredients)) && (is_array($quantities) || is_object($quantities)) && (is_array($units) || is_object($units))) {
            if (!$error && empty($ingredients)) {
                echo $ingredients;
                //to do not repeat this part
                $php_errormsg = "Přidejte alespoň jednu ingredienci";
                $errorMsgType = "errorMessage";
                $error = true;
            } else if (!$error) {
                // check strlen of ingredients, quantities and units
                for ($i = 0; $i < sizeof($ingredients) && !$error; $i++) {
                    // check if there is at least 1 ingredient
                    if (strlen($ingredients[$i]) > 0  && strlen($ingredients[$i]) < 40) {
                        $atLeastOneIngredientExists = true;
                    }
                    if (strlen($ingredients[$i]) > 39) {
                        $php_errormsg = "Překročili jste maximální počet znaků pro název ingredience";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    } else if (strlen($quantities[$i]) > 39) {
                        $php_errormsg = "Překročili jste maximální počet znaků pro množství ingredience";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    } else if (strlen($units[$i]) > 39) {
                        $php_errormsg = "Překročili jste maximální počet znaků pro jednotku ingredience";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }
                }
                if (!$atLeastOneIngredientExists) {
                    $php_errormsg = "Přidejte alespoň jednu ingredienci";
                    $errorMsgType = "errorMessage";
                    $error = true;
                }
            }
        } else {
            $php_errormsg = "Recept nebyl přidán, došlo k neočekávané chybě";
            $error = true;
        }


        //check, if at least one meal category was set
        $query = "SELECT ID FROM MealCategory";
        $result = $connect->query($query);
        if (!$error) {
            $presentMealCategory = 0;
            $i = 0;
            while ($i <= $result->num_rows) {
                $row = $result->fetch_assoc();
                // check, if mealCategory index is into database
                if (isset($_POST["mealCategory" . $i]) && $_POST["mealCategory" . $i]  == $row['ID']) {
                    $presentMealCategory++;
                }
                $i++;
            }
            if ($presentMealCategory < 1) {
                $php_errormsg = "Zvolte alespoň jednu kategorii jídla";
                $errorMsgType = "errorMessage";
                $error = true;
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

                $type = $_FILES['img']['type'];
                $extensions = array('image/jpeg', 'image/png', 'image/gif');
                if (in_array($type, $extensions)) {
                    if (move_uploaded_file($_FILES["img"]["tmp_name"], $uploadfile)) {
                        $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/' . $uploadfile;
                    } else {
                        $php_errormsg = "byl zvolen soubor v chybném formátu";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }
                } else {
                    $php_errormsg = "byl zvolen soubor v chybném formátu";
                    $errorMsgType = "errorMessage";
                    $error = true;
                }

                /*
                echo '<pre>';
                echo 'Here is some more debugging info:';
                print_r($_FILES);
                print "</pre>";*/
            } else {
                $php_errormsg = "Není vložen obrázek";
                $errorMsgType = "errorMessage";
                $error = true;
            }
        }



        // store Recipe into database
        if (!$error) {
            $query = "INSERT INTO Recipes(author_id, name, date, directions, originCountry_id, imgUrl) VALUES('$recipeAuthor_id', '$recipename', curdate(), '$directions', '$originCountry_id', '$imgUrl')";
            if (mysqli_query($connect, $query)) {
                $php_errormsg = "recept byl úspěšně přidán";
                $errorMsgType = "successMessage";
                // remember id of stored recipe (it will be handy for "Recipe_Ingredient" table)
                $currentRecipeID = $connect->insert_id;
            } else {
                $php_errormsg = "Recept nebyl přidán, došlo k neočekávané chybě";
                $errorMsgType = "errorMessage";
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
                        $php_errormsg = "Došlo k neočekávané chybě při pokusu o uložení vztahu mezi ingrediencí a receptem ";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }
                }
                $i++;
            }
        }

        //store ingredients into database
        if (!$error) {
            // check, if ingredients, quantities and units are really arrays
            // store each ingredient and relationship between ingredient and recipe
            for ($i = 0; $i < sizeof($ingredients); $i++) {
                // store ingredient if is not empty
                if (!empty($ingredients[$i])) {
                    $query = "INSERT INTO Ingredients(name, quantity, unit) VALUES('$ingredients[$i]', '$quantities[$i]', '$units[$i]')";
                    if (mysqli_query($connect, $query)) {
                        // remember id of stored ingredient (it will be handy for "Recipe_Ingredient" table)
                        $ingredients_ID[$i] = $connect->insert_id;
                    } else {
                        $php_errormsg = "Došlo k neočekávané chybě při pokusu o uložení ingredience ";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }

                    // store relationship between ingredients and stored recipe into database
                    $query = "INSERT INTO Recipe_Ingredients(recipe_id, ingredient_id) VALUES('$currentRecipeID', '$ingredients_ID[$i]')";
                    if (mysqli_query($connect, $query)) {
                    } else {
                        $php_errormsg = "Došlo k neočekávané chybě při pokusu o uložení vztahu mezi ingrediencí a receptem ";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }
                }
            }
        } else {
            if (!$error) {
                $php_errormsg = "Došlo k neočekávané chybě";
                $errorMsgType = "errorMessage";
            }
            $error = true;
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
        <a href="index.php">Domů</a>
        <a href="viewAllRecipes.php">Zobrazit recepty</a>
        <a class="active" href="addRecipe.php">Přidat nový recept</a>
        <a href="about.php">About</a>
        <?php
        if (!isset($_SESSION["username"])) {
            // User is not logged in
            echo '<a href="login.php?action=login">Login</a>';
        } else {
            // User is  logged in
            echo '<a href="userInfo.php">' . $_SESSION["username"] . '</a>';
        } ?>
    </div>

    <div style="padding-left:16px">
        <h2>Top Navigation Example</h2>
        <p>Some content..</p>
    </div>

    <div class="recipeDiv">
        <form enctype="multipart/form-data" method="post">

            <label for="recipename">Název:</label>
            <input type="text" id="recipename" name="recipename" value=<?php echo isset($_POST['recipename']) ? htmlspecialchars($_POST['recipename'], ENT_QUOTES) : ''; ?>><br><br>




            <table name="ingredients">
                <tr>
                    <th>Pořadí</th>
                    <th>Název ingredience</th>
                    <th>Monžství</th>
                    <th>jednotky</th>
                </tr>

                <?php
                for ($i = 1; $i <= 15; $i++) {
                    $textIngredients = isset($_POST['ingredients'][$i]) ? htmlspecialchars($_POST['ingredients'][$i], ENT_QUOTES) : '';
                    $textQuantities = isset($_POST['quantities'][$i]) ? htmlspecialchars($_POST['quantities'][$i], ENT_QUOTES) : '';
                    $textUnits = isset($_POST['units'][$i]) ? htmlspecialchars($_POST['units'][$i], ENT_QUOTES) : '';
                    echo
                        '<tr>
                        <td> ' . $i . ' </td>
                        <td> <input type="text" maxlength = "40" id="ingredients' . $i . '" name="ingredients[]" value=' . $textIngredients . '> </td>
                        <td> <input type="text" maxlength = "40" id="quantities' . $i . '" name="quantities[]" value=' . $textQuantities . '> </td>
                        <td> <input type="text" maxlength = "40" id="units' . $i . '" name="units[]" value=' . $textUnits . '> </td>
                    </tr>';
                }
                ?>
            </table>



            <label for="directions">Postu přípravy:</label>
            <textarea name="directions" rows="10" cols="50" maxlength="1000" minlength="3" required placeholder="Zadejte postup"><?php echo isset($_POST['directions']) ? htmlspecialchars($_POST['directions'], ENT_QUOTES) : ''; ?></textarea><br>



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
                        echo '<input type="checkbox" id="mealCategory' . $i . '"name="mealCategory' . $i . '"' . $checked . ' value =' . $row['ID'] . '>' . $row['name'] . '<br>';
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
            <p class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>

            <input type="submit" name="submit">
        </form>
    </div>

</body>

<script type="text/javascript" src="Scripts/checkRecipeForm.js"></script>

</html>