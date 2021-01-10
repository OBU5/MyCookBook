<?php
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

$connect = mysqli_connect("localhost", "bureson1", "webove aplikace", "bureson1");
// Check connection
if (!$connect) {
    die("Connection failed: No database found");
} else {
    $connect->set_charset("UTF-8");
    session_start();
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
    <nav class="topnav">
        <a href="index.php">Domů</a>
        <a class="active" href="viewAllRecipes.php">Zobrazit recepty</a>
        <a href="addRecipe.php">Přidat nový recept</a>
        <a href="about.php">About</a>
        <?php
        if ($connect) {
            if (!isset($_SESSION["username"])) {
                // User is not logged in
                echo '<a href="login.php?action=login">Login</a>';
            } else {
                // User is  logged in
                echo '<a href="userInfo.php">' . $_SESSION["username"] . '</a>';
            }
        } ?>
        <select onchange="location = this.value;">
            <option hidden selected disabled>Styl</option>
            <option value="changeStyle.php?style=1">Zeleninový</option>
            <option value="changeStyle.php?style=2">Masový</option>
            <option value="changeStyle.php?style=3">Těstovinový</option>
            <option value="changeStyle.php?style=4">Ovocný</option>
        </select>
    </nav>

    <?php
    if ($connect) {
        $recipeID = $_GET['id'];
        $currentUserID = 0;
        $currentUserRole = "";
        if (isset($_SESSION["username"])) {
            $currentUser = $_SESSION["username"];
        } else {
            $currentUser = "mrNobody";
        }


        $query = "SELECT ID, name, date, directions, author_id, originCountry_id, time, imgUrl FROM recipes WHERE ID = '$recipeID' ";
        $result = $connect->query($query);

        // for all recipes
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $recipe_id = htmlspecialchars($row["ID"], ENT_QUOTES);
                $creation_date = htmlspecialchars($row["date"], ENT_QUOTES);
                $imgUrl = htmlspecialchars($row["imgUrl"], ENT_QUOTES);
                $directions = (!empty($row["directions"]) ? htmlspecialchars($row["directions"], ENT_QUOTES) : "Neznámý");
                $time = (!empty($row["time"]) ? htmlspecialchars($row["time"], ENT_QUOTES) : "Neznámý");
                $originCountry = "Neznámý";
                $originCountry_id = htmlspecialchars($row["originCountry_id"], ENT_QUOTES);
                $author = "Neznámý";
                $recipeAuthor_id = "Neznámý";
                $ingredients = array();
                $quantities = array();
                $units = array();
                $mealCategories = array();

                //get recipe author name
                $query2 = "SELECT ID, username FROM users";
                $result2 = $connect->query($query2);
                if ($result2->num_rows > 0) {
                    // output data of each row
                    while ($row2 = $result2->fetch_assoc()) {
                        //echo $row['author_id'] ." ". $row2['ID']." ". $row2['username'];

                        if ($row['author_id'] == $row2['ID']) {
                            $author = htmlspecialchars($row2['username'], ENT_QUOTES);
                            $recipeAuthor_id = htmlspecialchars($row2['ID'], ENT_QUOTES);
                        }
                    }
                }

                // get ingredients id
                $query2 = "SELECT ingredient_id FROM recipe_ingredients WHERE recipe_id = '$recipe_id'";
                $result2 = $connect->query($query2);
                if ($result2->num_rows > 0) {
                    // get each ingredient by id
                    $i = 0;
                    while ($row2 = $result2->fetch_assoc()) {
                        $tmpIngredient_id = $row2["ingredient_id"];
                        // prepare each ingredient related to this recipe
                        $query3 = "SELECT name, quantity, unit FROM ingredients WHERE ID = '$tmpIngredient_id'";
                        $result3 = $connect->query($query3);
                        if ($result3->num_rows > 0) {
                            // get each ingredient by id
                            $j = 0;
                            while ($row3 = $result3->fetch_assoc()) {
                                //echo $row['author_id'] ." ". $row2['ID']." ". $row2['username'];
                                $ingredients[$i] =  htmlspecialchars($row3['name'], ENT_QUOTES);
                                $quantities[$i] =  htmlspecialchars($row3['quantity'], ENT_QUOTES);
                                $units[$i] =  htmlspecialchars($row3['unit'], ENT_QUOTES);
                                $j++;
                            }
                        }
                        $i++;
                    }
                }


                // get origin country
                $query2 = "SELECT name FROM origincountry WHERE ID = '$originCountry_id'";
                $result2 = $connect->query($query2);
                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $originCountry = htmlspecialchars($row2["name"], ENT_QUOTES);
                }

                // get MealCategory
                $query2 = "SELECT mealCategory_id FROM recipe_mealcategory WHERE recipe_id = '$recipe_id'";
                $result2 = $connect->query($query2);
                $tmp_mealCategory_id = 0;
                if ($result2->num_rows > 0) {
                    $i = 0;
                    while ($row2 = $result2->fetch_assoc()) {
                        $tmp_mealCategory_id = $row2["mealCategory_id"];
                        $query3 = "SELECT name FROM mealcategory WHERE ID = '$tmp_mealCategory_id'";
                        $result3 = $connect->query($query3);
                        if ($result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                            $mealCategories[$i] =  htmlspecialchars($row3["name"], ENT_QUOTES);
                        }
                        $i++;
                    }
                }


                // prepre table of ingredients
                $htmlIngredients = "<h2>Ingredience</h2> 
            <table class=ingredients>
                <tr>
                    <th>Ingredience</th>
                    <th>Množství</th>
                </tr>";
                for ($i = 0; $i < sizeof($ingredients); $i++) {
                    $htmlIngredients = $htmlIngredients . "<tr><td>" . $ingredients[$i] . "</td><td> " . $quantities[$i] . " " . $units[$i] .   "</td></tr>";
                }
                $htmlIngredients = $htmlIngredients . "</table>";

                //prepare meal category
                $htmlMealCategories = "<ul>";
                for ($i = 0; $i < sizeof($mealCategories); $i++) {
                    $htmlMealCategories = $htmlMealCategories . "<li>" . $mealCategories[$i] . "</li>";
                }
                $htmlMealCategories = $htmlMealCategories . "</ul>";
                if (!@getimagesize($imgUrl)) {
                    $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/Uploads/default.jpg';
                }

                $htmlButtonText = "";
                // get user_id of signed user
                $currentUserDecoded = htmlspecialchars_decode($_SESSION["username"]);

                $query1 = "SELECT ID, role FROM users WHERE username = '$currentUserDecoded'";
                $result1 = $connect->query($query1);
                if (mysqli_num_rows($result1) <= 0) {
                } else {
                    $row1 = $result1->fetch_assoc();
                    $currentUserID = htmlspecialchars($row1['ID'], ENT_QUOTES);
                    $currentUserRole = htmlspecialchars($row1['role'], ENT_QUOTES);
                    //show buttons only if current user is author, of the role of user is "Admin"
                    if ($currentUserID == $recipeAuthor_id || $currentUserRole == "Admin") {
                        $htmlButtonText = "<button type=button onclick=location.href='editRecipe.php?id=" . $recipe_id . "'>Upravit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-edit'></i></button>             
                    <button type=button onclick=location.href='deleteRecipe.php?id=" . $recipe_id . "'>Odstranit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-remove'></i></button>";
                    }
                }


                // echo HTML div of 1 recipe
                echo "    
                    <main class=fullRecipeDiv>
                    <h1>" . htmlspecialchars($row["name"], ENT_QUOTES) . "</h1>
         
                    <p> <strong>identifikační číslo receptu:</strong> " . $recipe_id . "</p>
                                        
                    <p><strong>Přidáno dne:</strong> " . $creation_date . "</p>
                    <p><strong>Doba vaření:</strong> " . $time . " minut</p>
                    <p><strong>Autor:</strong> " . $author . "</p>
                    <p><strong>Země původu:</strong> " . $originCountry . "</p>
            
                    " . $htmlIngredients . "
                    <h2>Postup</h2>
                    <p> " . nl2br($directions) . "</p>
                    <h3> Vhodné jako:</h3> " . $htmlMealCategories . "

                    <p> <img class=full src=https://wa.toad.cz/~bureson1/" . $imgUrl . " alt=Obrázek> </p>
                    
                    " . $htmlButtonText . "
                    <button onclick='window.print();'>
                    Vytisknout&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-print'></i>
                    </button>
                   </main> <br><br>";
            }
        } else {
            echo "                    
            <main class=fullRecipeDiv>
                <p> Recept s požadovaným identifikačním číslem neexistuje<p>
            </main> <br><br>";
        }
    }
    ?>
    <!--Footer-->
    <footer>
        <p>Autor: Ondřej Bureš, Kontakt:
            <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
        </p>
    </footer>

</body>

</html>