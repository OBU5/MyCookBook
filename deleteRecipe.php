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

    $query = "SELECT ID, name, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE ID = '$recipeID' ";
    $result = $connect->query($query);

    // recipe found - id is valid
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recipeAuthor_id = $row['author_id'];
        $currentUser = $_SESSION["username"];
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
        }else {
            $php_errormsg = "Recept nebyl smazán,nemáte dostatečná práva";
            $errorMsgType = "errorMessage";
            $error = true;
        }
    } else {
        $php_errormsg = "Recept který chete smazat neexistuje";
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

        <p class=<?php echo $errorMsgType; ?>><?php echo $php_errormsg; ?></p>

    </div>
</body>

<script type="text/javascript" src="Scripts/checkRecipeForm.js"></script>

</html>