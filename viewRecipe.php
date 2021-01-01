<?php
$connect = mysqli_connect("localhost", "root", "", "test");
$connect->set_charset("UTF-8");
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <div class="topnav">
        <a href="index.php">Domů</a>
        <a class="active" href="viewAllRecipes.php">Zobrazit recepty</a>
        <a href="addRecipe.php">Přidat nový recept</a>
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

    <?php
    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }
    $recipeID = $_GET['id'];


    $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE ID = '$recipeID' ";
    $result = $connect->query($query);

    // for all recipes
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            $recipe_id = $row["ID"];
            $creation_date = $row["date"];
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
            $query2 = "SELECT ingredient_id FROM Recipe_Ingredients WHERE recipe_id = '$recipe_id'";
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
            $query2 = "SELECT mealCategory_id FROM Recipe_MealCategory WHERE recipe_id = '$recipe_id'";
            $result2 = $connect->query($query2);
            $tmp_mealCategory_id = 0;
            if ($result2->num_rows > 0) {
                $i = 0;
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


            // prepre table of ingredients
            $htmlIngredients = "<h3>Ingredience</h3> 
            <table class=ingredients>
                <tr>
                    <th>Ingredience</th>
                    <th>Množství</th>
                </tr>";
            for ($i = 0; $i < sizeof($ingredients); $i++) {
                $htmlIngredients = $htmlIngredients . "<tr><td>" . $ingredients[$i] . "</td><td> " . $quantities[$i] ." " . $units[$i] .   "</td></tr>";
            }
            $htmlIngredients = $htmlIngredients . "</table>";

            //prepare meal category
            $htmlMealCategories = "<ul>";
            for ($i = 0; $i < sizeof($mealCategories); $i++) {
                $htmlMealCategories = $htmlMealCategories . "<li>" . $mealCategories[$i] . "</li>";
            }
            $htmlMealCategories = $htmlMealCategories . "</ul>";

            // echo HTML div of 1 recipe
            echo "    
                    <div style= cursor:pointer; class=recipeDiv  onclick=location.href='viewRecipe.php?id=" . $row['ID'] . "'>
                    <h1>" . $row["name"] . "</h1>
         
                    <p> <strong>identifikační číslo receptu:</strong> " . $recipe_id . "</p>
                                        
                    <p><strong>Přidáno dne:</strong> " . $creation_date . "</p>
            
                    <p><strong>Autor:</strong> " . $author . "</p>
                    <p><strong>Země původu:</strong> " . $originCountry . "</p>
            
                    " . $htmlIngredients . "
                    <h3>Postup</h3>
                    <p> " . $directions . "</p>
                    <p margin:0px;><strong> Vhodné jako:</strong> </p>" . $htmlMealCategories . "

                    <p> <img class=preview src=" . $imgUrl . " alt=Obrázek> </p>
                                              
                   </div> <br><br>";
        }
    } else {
        echo "0 results";
    }

    ?>

</body>

</html>