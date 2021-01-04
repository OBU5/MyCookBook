<?php
session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Styles/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    $connect = mysqli_connect("localhost", "root", "", "test");
   // Check connection
   if (!$connect) {
    die("Connection failed: No database found");
} else {
    $connect->set_charset("UTF-8");
}
if ($connect) {
    $sarchedOption = isset($_GET['option']) ? $_GET['option'] : "default";
    //get recipe author name
    $currentUserID = 0; // not selected
    $tmpAuthorName = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
    $query2 = "SELECT ID, username FROM Users WHERE username ='$tmpAuthorName'";
    $result2 = $connect->query($query2);
    if ($result2!=null && $result2->num_rows > 0) {
        // output data of each row
        while ($row2 = $result2->fetch_assoc()) {
            $currentUserID = $row2['ID'];
        }
    }



    if ($sarchedOption != null && $sarchedOption  == "my") {
        $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE author_id = '$currentUserID'";
    } else {
        $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM Recipes";
    }
    $result = $connect->query($query);
    // Get the total number of records from our table "students".
    $total_pages = $result != null ? $result->num_rows: 0;

    // Check if the page number is specified and check if it's a number, if not -> return the default page number which is 1.
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    echo "<div class = chooseOptionDiv>";
    echo "<button class=chooseOptionButton type=button onclick=location.href='viewAllRecipes.php?page=1&option=my'>Zobrazit pouze moje recepty</button>";
    echo "<button class=chooseOptionButton type=button onclick=location.href='viewAllRecipes.php?page=1&option=default'>Zobrazit všechny recepty</button>";
    echo "</div>";

    // Number of results to show on each page.
    $num_results_on_page = 10;

    if ($sarchedOption != null && $sarchedOption  == "my") {
        $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM Recipes WHERE author_id = '$currentUserID' LIMIT ?,?";
    } else {
        $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM Recipes LIMIT ?,?";
    }
    if ($stmt = $connect->prepare($query)) {
        // Calculate the page to get the results we need from our table.
        $calc_page = ($page - 1) * $num_results_on_page;
        $stmt->bind_param('ii', $calc_page, $num_results_on_page);
        $stmt->execute();
        // Get the results...
        $result = $stmt->get_result();

        echo "<div class=recipeDiv>";
        // for all recipes
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                $recipe_id = $row["ID"];
                $imgUrl = $row["imgUrl"];
                $originCountry = "Neznámá";
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



                //prepare meal category
                $htmlMealCategories = "<ul>";
                for ($i = 0; $i < sizeof($mealCategories); $i++) {
                    $htmlMealCategories = $htmlMealCategories . "<li>" . $mealCategories[$i] . "</li>";
                }
                $htmlMealCategories = $htmlMealCategories . "</ul>";
                //check if image url doesn't exists show default image
                if (!@getimagesize($imgUrl)) {
                    $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/Uploads/default.jpg';
                }
                // echo HTML div of 1 recipe
                echo "    
                
                <h1>" . $row["name"] . "</h1>
     
                <p> <strong>Identifikační číslo receptu:</strong> " . $recipe_id . "</p>
        
                <p><strong>Autor:</strong> " . $author . "</p>
                <p><strong>Země původu:</strong> " . $originCountry . "</p>
        
                <p margin:0px;><strong> Vhodné jako:</strong> </p>" . $htmlMealCategories . "

                <p> <strong>Náhled obrázku</strong></p><p><img class=preview src=" . $imgUrl  . " alt=Obrázek> </p>
                <button type=button onclick=location.href='viewRecipe.php?id=" . $row['ID'] . "'>Více informací&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-search'></i></button>  
                <hr>
                <br>
                <br>";
            }
        }
    } else {
        echo "0 results";
    }
}


?>


<?php
// Pagination
if (ceil($total_pages / $num_results_on_page) > 0) : ?>
    <div class="pagination">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="prev"><a href="viewAllRecipes.php?page=<?php echo $page - 1 ?>">Předchozí</a></li>
            <?php endif; ?>

            <?php if ($page > 3) : ?>
                <li class="start"><a href="viewAllRecipes.php?page=1&option=<?php echo $sarchedOption ?>">1</a></li>
                <li class="dots">...</li>
            <?php endif; ?>

            <?php if ($page - 2 > 0) : ?><li class="page"><a href="viewAllRecipes.php?page=<?php echo $page - 2 ?>&option=<?php echo $sarchedOption ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
            <?php if ($page - 1 > 0) : ?><li class="page"><a href="viewAllRecipes.php?page=<?php echo $page - 1 ?>&option=<?php echo $sarchedOption ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

            <li class="currentpage"><a href="viewAllRecipes.php?page=<?php echo $page ?>&option=<?php echo $sarchedOption ?>"><?php echo $page ?></a></li>

            <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllRecipes.php?page=<?php echo $page + 1 ?>&option=<?php echo $sarchedOption ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
            <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllRecipes.php?page=<?php echo $page + 2 ?>&option=<?php echo $sarchedOption ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
                <li class="dots">...</li>
                <li class="end"><a href="viewAllRecipes.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>&option=<?php echo $sarchedOption ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
                <li class="next"><a href="viewAllRecipes.php?page=<?php echo $page + 1 ?>&option=<?php echo $sarchedOption ?>">Další</a></li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>

</div> <br>
<!--Footer-->
<footer>
    <p>Autor: Ondřej Bureš, Kontakt:
        <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
    </p>
</footer>

</body>

</html>