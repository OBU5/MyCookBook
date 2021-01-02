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
    $recipeID = $_GET['id'];

    $query = "SELECT ID, name, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE ID = '$recipeID' ";
    $result = $connect->query($query);

    // recipe found - id is valid
    if ($result->num_rows > 0) {





        //delete "mealCategory" elements  
        if (!$error) {
            $query = "DELETE FROM Recipe_MealCategory WHERE recipe_id = '$recipeID'";
            if (mysqli_query($connect, $query)) {
            } else {
                $php_errormsg = "Došlo k neočekávané chybě při pokusu o smazání vztahu mezi kategorií jídla a receptem ";
                $errorMsgType = "errorMessage";
                $error = true;
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

        

        // delete Recipe
        if (!$error) {
            $query = "DELETE FROM Recipes WHERE ID = '$recipeID'";
            if (mysqli_query($connect, $query)) {
                $php_errormsg = "recept byl úspěšně smazán";
                $errorMsgType = "successMessage";
                // remember id of stored recipe (it will be handy for "Recipe_Ingredient" table)
            } else {
                $php_errormsg = "Recept nebyl smazán, došlo k neočekávané chybě";
                $errorMsgType = "errorMessage";
                $error = true;
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
</body>

<script type="text/javascript" src="Scripts/checkRecipeForm.js"></script>

</html>