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
    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }
    $recipeID = isset($_GET['id']) ? $_GET['id'] : 0;
    $currentUserID = 0;
    $currentUserRole = "";
    $currentUser = $_SESSION["username"];

    $recipename;
    $imgUrl;
    $directions;
    $originCountry;
    $originCountry_id;
    $ingredients = array();
    $quantities = array();
    $units = array();
    $mealCategories = array();
    $recipeAuthor_id;

    //if recipe id is valid
    if ($recipeID > 0) {
        $query = "SELECT ID, name, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE ID = '$recipeID' ";
        $result = $connect->query($query);

        // recipe found - id is valid
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $recipeAuthor_id = $row['author_id'];



            if (isset($_POST["submit"])) {
                //echo "post REQUEST";

                // get user_id of signed user
                if (!$error) {
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
                }
                //update only if current user is author, of the role of user is "Admin"
                if ($currentUserID == $recipeAuthor_id || $currentUserRole == "Admin") {

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
                    $atLeastOneIngredientExists = false;
                    if ((is_array($ingredients) || is_object($ingredients)) && (is_array($quantities) || is_object($quantities)) && (is_array($units) || is_object($units))) {
                        if (!$error && empty($ingredients)) {
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
                    $query = "SELECT ID, name FROM MealCategory";
                    $result = $connect->query($query);
                    if (!$error) {
                        $presentMealCategory = 0;
                        $i = 1;
                        while ($i <= $result->num_rows) {
                            $row = $result->fetch_assoc();
                            // check, if mealCategory index is into database
                            if (isset($_POST["mealCategory" . $i]) && $_POST["mealCategory" . $i]  == $row['ID']) {
                                $presentMealCategory++;
                                $mealCategories[$i] = $row['name'];
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
                    $imgUrlChanged = false;
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
                                    $imgUrlChanged = true;
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
                            // it is not mandatory to insert image, when we edit the recipe
                        }
                    }



                    // update Recipe
                    if (!$error) {
                        if ($imgUrlChanged) {
                            $query = "UPDATE Recipes SET  name = '$recipename', directions = '$directions', originCountry_id = '$originCountry_id', imgUrl = '$imgUrl' WHERE ID = '$recipeID'";
                        } else {
                            $query = "UPDATE Recipes SET  name = '$recipename', directions = '$directions', originCountry_id = '$originCountry_id' WHERE ID = '$recipeID'";
                        }
                        if (mysqli_query($connect, $query)) {
                            $php_errormsg = "recept byl úspěšně upraven";
                            $errorMsgType = "successMessage";
                            // remember id of stored recipe (it will be handy for "Recipe_Ingredient" table)
                        } else {
                            $php_errormsg = "Recept nebyl upraven, došlo k neočekávané chybě";
                            $errorMsgType = "errorMessage";
                            $error = true;
                        }
                    }

                    // store relationship between MealCategory and stored recipe into database


                    //update "mealCategory" elements  
                    if (!$error) {
                        $query = "DELETE FROM Recipe_MealCategory WHERE recipe_id = '$recipeID'";
                        if (mysqli_query($connect, $query)) {
                        } else {
                            $php_errormsg = "Došlo k neočekávané chybě při pokusu o smazání vztahu mezi kategorií jídla a receptem ";
                            $errorMsgType = "errorMessage";
                            $error = true;
                        }
                        // save new meal category and recipe relationship

                        $query = "SELECT ID FROM MealCategory";
                        $result = $connect->query($query);
                        $i = 1;
                        while ($i <= $result->num_rows) {
                            if (isset($_POST["mealCategory" . $i])) {
                                //echo $i;
                                $query = "INSERT INTO Recipe_MealCategory (mealCategory_id, recipe_id) VALUES ('$i', '$recipeID')";
                                if (mysqli_query($connect, $query)) {
                                } else {
                                    $php_errormsg = "Došlo k neočekávané chybě při pokusu o uložení vztahu mezi kategorií jídla a receptem ";
                                    $errorMsgType = "errorMessage";
                                    $error = true;
                                }
                            }
                            $i++;
                        }
                    }

                    //delete old ingredients
                    $ingredient_ToDelete = array();
                    $query2 = "SELECT ingredient_id FROM Recipe_Ingredients WHERE recipe_id = '$recipeID'";
                    $result2 = $connect->query($query2);
                    if ($result2->num_rows > 0) {
                        // get each ingredient by id
                        $i = 0;
                        while ($row2 = $result2->fetch_assoc()) {
                            $ingredients_ToDelete = $row2["ingredient_id"];
                            $i++;
                        }
                    }
                    $query3 = "DELETE FROM Recipe_Ingredients WHERE recipe_id = '$recipeID'";
                    if (mysqli_query($connect, $query3)) {
                    } else {
                        $php_errormsg = "Došlo k neočekávané chybě při pokusu o smazání vztahu mezi ingrediencí a receptem ";
                        $errorMsgType = "errorMessage";
                        $error = true;
                    }
                    for ($i = 0; $i < sizeof($ingredient_ToDelete); $i++) {
                        echo "ingredience ke smazani" . $ingredient_ToDelete . "<br>";

                        // delete each ingredient related to this recipe 

                        $query3 = "DELETE FROM Ingredients WHERE ID= '$ingredient_ToDelete'";
                        if (mysqli_query($connect, $query3)) {
                        } else {
                            $php_errormsg = "Došlo k neočekávané chybě při pokusu o smazání ingredience s ID " . $ingredient_ToDelete;
                            $errorMsgType = "errorMessage";
                            $error = true;
                        }
                    }

                    //store new ingredients
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
                                $query = "INSERT INTO Recipe_Ingredients(recipe_id, ingredient_id) VALUES('$recipeID', '$ingredients_ID[$i]')";
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
                } else {
                    $php_errormsg = "nemáte oprávnění na úpravu tohoto receptu";
                    $errorMsgType = "errorMessage";
                    $error = true;
                }
            }
            //if it is not submited -> load data from database
            else {
                $query = "SELECT ID, name, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE ID = '$recipeID' ";
                $result = $connect->query($query);

                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $recipename = $row["name"];
                    $imgUrl = $row["imgUrl"];
                    $directions = (!empty($row["directions"]) ? $row["directions"] : "Neznámý");
                    $originCountry = "Neznámý";
                    $originCountry_id = $row["originCountry_id"];
                    $author = "Neznámý";
                    $ingredients = array();
                    $quantities = array();
                    $units = array();
                    $mealCategories = array();

                    //get recipe author name
                    $query2 = "SELECT ID, username FROM Users";
                    $result2 = $connect->query($query2);
                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while ($row2 = $result2->fetch_assoc()) {
                            //echo $row['author_id'] ." ". $row2['ID']." ". $row2['username'];

                            if ($row['author_id'] == $row2['ID']) {
                                $author = $row2['username'];
                            }
                        }
                    }

                    // get ingredients id
                    $query2 = "SELECT ingredient_id FROM Recipe_Ingredients WHERE recipe_id = '$recipeID'";
                    $result2 = $connect->query($query2);
                    if ($result2->num_rows > 0) {
                        // get each ingredient by id
                        $i = 0;
                        while ($row2 = $result2->fetch_assoc()) {
                            $tmpIngredient_id = $row2["ingredient_id"];
                            // prepare each ingredient related to this recipe 
                            $query3 = "SELECT name, quantity, unit FROM Ingredients WHERE ID = '$tmpIngredient_id'";
                            $result3 = $connect->query($query3);
                            if ($result3->num_rows > 0) {
                                // get each ingredient by id
                                $j = 0;
                                while ($row3 = $result3->fetch_assoc()) {
                                    //echo $row['author_id'] ." ". $row2['ID']." ". $row2['username'];
                                    $ingredients[$i] =  $row3['name'];
                                    $quantities[$i] =  $row3['quantity'];
                                    $units[$i] =  $row3['unit'];
                                    $j++;
                                }
                            }
                            $i++;
                        }
                    }


                    // get origin country
                    $query2 = "SELECT name FROM OriginCountry WHERE ID = '$originCountry_id'";
                    $result2 = $connect->query($query2);
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $originCountry = $row2["name"];
                    }

                    // get MealCategory
                    $query2 = "SELECT mealCategory_id FROM Recipe_MealCategory WHERE recipe_id = '$recipeID'";
                    $result2 = $connect->query($query2);
                    $tmp_mealCategory_id = 0;
                    if ($result2->num_rows > 0) {
                        $i = 1;
                        while ($row2 = $result2->fetch_assoc()) {
                            $tmp_mealCategory_id = $row2["mealCategory_id"];
                            $query3 = "SELECT name FROM MealCategory WHERE ID = '$tmp_mealCategory_id'";
                            $result3 = $connect->query($query3);
                            if ($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                $mealCategories[$i] =  $row3["name"];
                            }
                            $i++;
                        }
                    }
                }
            }
        } else {

            $php_errormsg = "Zadané id neexistuje";
            $errorMsgType = "errorMessage";
            $error = true;
        }
    } else {

        $php_errormsg = "Zadané id neexistuje";
        $errorMsgType = "errorMessage";
        $error = true;
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


    <div class="recipeDiv">
        <form enctype="multipart/form-data" method="post">

            <label for="recipename">Název:</label>
            <input type="text" id="recipename" name="recipename" value=<?php echo isset($recipename) ? htmlspecialchars($recipename, ENT_QUOTES) : ''; ?>><br><br>




            <table name="ingredients">
                <tr>
                    <th>Pořadí</th>
                    <th>Název ingredience</th>
                    <th>Monžství</th>
                    <th>jednotky</th>
                </tr>

                <?php
                for ($i = 1; $i <= 15; $i++) {
                    $textIngredients = !empty($ingredients[$i - 1]) ? htmlspecialchars($ingredients[$i - 1], ENT_QUOTES) : '';
                    $textQuantities = !empty($quantities[$i - 1]) ? htmlspecialchars($quantities[$i - 1], ENT_QUOTES) : '';
                    $textUnits = !empty($units[$i - 1]) ? htmlspecialchars($units[$i - 1], ENT_QUOTES) : '';
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
            <textarea name="directions" rows="10" cols="50" maxlength="1000" minlength="3" required placeholder="Zadejte postup"><?php echo isset($directions) ? htmlspecialchars($directions, ENT_QUOTES) : ''; ?></textarea><br>



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
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $checked = !empty($mealCategories[$i]) ? "checked " : "";
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
                        $selected = (!empty($originCountry) && $originCountry == $row['name']) ? 'selected="selected"' : '';
                        echo "<option value=" . $row['name'] . ' ' . $selected . ">" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            <p class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>

            <input type="submit" name="submit">
        </form>
    </div>

    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a></p>
    </footer>
</body>

<script type="text/javascript" src="Scripts/checkRecipeForm.js"></script>

</html>