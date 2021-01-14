<?php

// i pro multi-byte (napr. UTF-8)
$prevodni_tabulka = Array(
    'ä'=>'a',
    'Ä'=>'A',
    'á'=>'a',
    'Á'=>'A',
    'à'=>'a',
    'À'=>'A',
    'ã'=>'a',
    'Ã'=>'A',
    'â'=>'a',
    'Â'=>'A',
    'č'=>'c',
    'Č'=>'C',
    'ć'=>'c',
    'Ć'=>'C',
    'ď'=>'d',
    'Ď'=>'D',
    'ě'=>'e',
    'Ě'=>'E',
    'é'=>'e',
    'É'=>'E',
    'ë'=>'e',
    'Ë'=>'E',
    'è'=>'e',
    'È'=>'E',
    'ê'=>'e',
    'Ê'=>'E',
    'í'=>'i',
    'Í'=>'I',
    'ï'=>'i',
    'Ï'=>'I',
    'ì'=>'i',
    'Ì'=>'I',
    'î'=>'i',
    'Î'=>'I',
    'ľ'=>'l',
    'Ľ'=>'L',
    'ĺ'=>'l',
    'Ĺ'=>'L',
    'ń'=>'n',
    'Ń'=>'N',
    'ň'=>'n',
    'Ň'=>'N',
    'ñ'=>'n',
    'Ñ'=>'N',
    'ó'=>'o',
    'Ó'=>'O',
    'ö'=>'o',
    'Ö'=>'O',
    'ô'=>'o',
    'Ô'=>'O',
    'ò'=>'o',
    'Ò'=>'O',
    'õ'=>'o',
    'Õ'=>'O',
    'ő'=>'o',
    'Ő'=>'O',
    'ř'=>'r',
    'Ř'=>'R',
    'ŕ'=>'r',
    'Ŕ'=>'R',
    'š'=>'s',
    'Š'=>'S',
    'ś'=>'s',
    'Ś'=>'S',
    'ť'=>'t',
    'Ť'=>'T',
    'ú'=>'u',
    'Ú'=>'U',
    'ů'=>'u',
    'Ů'=>'U',
    'ü'=>'u',
    'Ü'=>'U',
    'ù'=>'u',
    'Ù'=>'U',
    'ũ'=>'u',
    'Ũ'=>'U',
    'û'=>'u',
    'Û'=>'U',
    'ý'=>'y',
    'Ý'=>'Y',
    'ž'=>'z',
    'Ž'=>'Z',
    'ź'=>'z',
    'Ź'=>'Z'
  );

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
$time = 60;
$connect = mysqli_connect("localhost", "root", "", "myCookBook");
// Check connection
if (!$connect) {
    die("Connection failed: No database found");
} else {
    $connect->set_charset("UTF-8");
    session_start();
}
if ($connect) {
    $error = false;
    // user must be logged in
    if (!isset($_SESSION["username"])) {
        $php_errormsg = "Abyste mohl přidat recept, musíte se přihlásit";
        $errorMsgType = "errorMessage";
        $error = true;
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
            // check if recipeName is unique
            if (!$error) {
                $query = "SELECT * FROM recipes WHERE name = '$recipename'";
                $result = $connect->query($query);
                if (mysqli_num_rows($result) > 0) {
                    $php_errormsg = "Recept s tímto jménem již existuje";
                    $errorMsgType = "errorMessage";
                    $error = true;
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
                $currentUserDecoded = htmlspecialchars_decode($_SESSION["username"]);
                $query = "SELECT ID FROM users WHERE username = '$currentUserDecoded'";
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

                    $query = "SELECT ID FROM origincountry WHERE name = '$originCountry'";
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
                    //echo $ingredients;
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

            //check if filled time is number
            $atLeastOneIngredientExists = false;
            if (isset($_POST['time']) && is_numeric($_POST['time']) && ($_POST['time'] > 1) && ($_POST['time'] < 1000)) {
                $time = $_POST['time'];
            }
            else{                    
                $php_errormsg = "Počet minut musí být mezi 1 až 1000 minutami";
                $errorMsgType = "errorMessage";
                $error = true;
            }
            //check, if at least one meal category was set
            $query = "SELECT ID FROM mealcategory";
            $result = $connect->query($query);
            if (!$error) {
                $presentMealCategory = 0;
                $i = 1;
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
                    $uploadfile =strtr($uploadfile, $prevodni_tabulka);

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
                            $imgUrl = $uploadfile;
                            //echo $imgUrl;
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
                $query = "INSERT INTO recipes(author_id, name, date, directions, originCountry_id, time, imgUrl) VALUES('$recipeAuthor_id', '$recipename', curdate(), '$directions', '$originCountry_id', '$time', '$imgUrl')";
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

                $query = "SELECT ID FROM mealcategory";
                $result = $connect->query($query);
                $i = 1;
                while ($i <= $result->num_rows) {
                    // output data of each row
                    if (isset($_POST["mealCategory" . $i])) {
                        //echo $i;
                        $query = "INSERT INTO recipe_mealcategory(recipe_id, mealCategory_id) VALUES('$currentRecipeID', '$i')";
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
                        $query = "INSERT INTO ingredients(name, quantity, unit) VALUES('$ingredients[$i]', '$quantities[$i]', '$units[$i]')";
                        if (mysqli_query($connect, $query)) {
                            // remember id of stored ingredient (it will be handy for "Recipe_Ingredient" table)
                            $ingredients_ID[$i] = $connect->insert_id;
                        } else {
                            $php_errormsg = "Došlo k neočekávané chybě při pokusu o uložení ingredience ";
                            $errorMsgType = "errorMessage";
                            $error = true;
                        }

                        // store relationship between ingredients and stored recipe into database
                        $query = "INSERT INTO recipe_ingredients(recipe_id, ingredient_id) VALUES('$currentRecipeID', '$ingredients_ID[$i]')";
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
}

?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>MyCookBook</title>
    <link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/3565/3565407.svg" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body class="<?php echo $bodyClass; ?>">
    <!--Navigation bar-->
    <nav class="topnav">
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
        <select onchange="location = this.value;">
            <option hidden selected disabled>Styl</option>
            <option value="changeStyle.php?style=1">Zeleninový</option>
            <option value="changeStyle.php?style=2">Masový</option>
            <option value="changeStyle.php?style=3">Těstovinový</option>
            <option value="changeStyle.php?style=4">Ovocný</option>
        </select>
    </nav>
    <main class="recipeDiv">
        <form enctype="multipart/form-data" method="post">

            <label for="recipename">Název:</label>
            <input type="text" id="recipename" name="recipename" value="<?php echo isset($_POST['recipename']) ? htmlspecialchars($_POST['recipename'], ENT_QUOTES ) : ''; ?>"><br><br>



            <p>Ingredience:</p>
            <table id="tableIngredients" class="ingredients">
                <tr>
                    <th>Pořadí</th>
                    <th>Název ingredience</th>
                    <th>Monžství</th>
                    <th>jednotky</th>
                </tr>

                <?php
                for ($i = 1; $i <= 5; $i++) {
                    $textIngredients = isset($_POST['ingredients'][$i - 1]) ? htmlspecialchars($_POST['ingredients'][$i - 1], ENT_QUOTES) : '';
                    $textQuantities = isset($_POST['quantities'][$i - 1]) ? htmlspecialchars($_POST['quantities'][$i - 1], ENT_QUOTES) : '';
                    $textUnits = isset($_POST['units'][$i - 1]) ? htmlspecialchars($_POST['units'][$i - 1], ENT_QUOTES) : '';
                    echo
                        '<tr>
                        <td> ' . $i . ' </td>
                        <td><label hidden for="ingredients' . $i . '">Ingredience:</label> <input type="text" maxlength = "40" id="ingredients' . $i . '" name="ingredients[]" value="' . $textIngredients . '"> </td>
                        <td><label hidden for="quantities' . $i . '">množství:</label>  <input type="text" maxlength = "40" id="quantities' . $i . '" name="quantities[]" value="' . $textQuantities . '"> </td>
                        <td><label hidden for="units' . $i . '">jednotky:</label>  <input type="text" maxlength = "40" id="units' . $i . '" name="units[]" value="' . $textUnits . '"> </td>
                    </tr>';
                }
                ?>
            </table>
            <button type="button" class="addIngredient" onclick="addRow()">Přidat další ingredienci</button>
            <br>


            <label for="directions">Postup přípravy:</label>
            <textarea id="directions" name="directions" rows="10" cols="50" maxlength="1000" minlength="3" required placeholder="Zadejte postup"><?php echo stripcslashes(isset($_POST['directions']) ? htmlspecialchars($_POST['directions'], ENT_QUOTES) : ''); ?></textarea><br>
            
            <label for="time">Doba vaření v minutách (1 až 1000):</label>
            <input type="number" name="time" id="time" min="1" max="1000" value = "<?php echo stripcslashes(isset($_POST['time']) ? htmlspecialchars($_POST['time'], ENT_QUOTES) : ''); ?>"><br><br>


            <label for="img">Obrázek:</label>
            <input type="file" name="img" id="img" accept="image/*"><br><br>

            <!-- meal category -->

            <p>Kategorie jídla:</p>
            <div class="mealCategoryDiv">

                <?php
                $query = "SELECT ID, name FROM mealcategory";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    // output data of each row
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $checked = isset($_POST["mealCategory" . $i]) ? "checked " : "";
                        echo '<label hidden for="mealCategory' . $i . '">kategorie:</label> <input type="checkbox" id="mealCategory' . $i . '" name="mealCategory' . $i . '" ' . $checked . ' value =' . $row['ID'] . '>' . $row['name'] . '<br>';
                        $i++;
                    }
                }
                ?>
            </div>


            <!-- origin country -->

            <label for="originCountry">Země původu:</label>
            <select name="originCountry" id="originCountry">
                <?php
                $query = "SELECT name FROM origincountry";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $selected = (isset($_POST['originCountry']) && $_POST['originCountry'] == $row['name']) ? 'selected="selected"' : '';
                        echo "<option value='" . $row['name'] . "'" . $selected . ">" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            <p id="errorMsg" class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>

            <input type="submit" name="submit">
        </form>
    </main>

    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>
    <script src="Scripts/checkRecipeForm.js"></script>
</body>


</html>