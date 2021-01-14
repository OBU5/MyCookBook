<?php
$bodyClass = "style1";
session_start();
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

    <?php

    $connect = mysqli_connect("localhost", "root", "", "myCookBook");
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
        $query2 = "SELECT ID, username FROM users WHERE username ='$tmpAuthorName'";
        $result2 = $connect->query($query2);
        if ($result2 != null && $result2->num_rows > 0) {
            // output data of each row
            while ($row2 = $result2->fetch_assoc()) {
                $currentUserID = $row2['ID'];
            }
        }



        if ($sarchedOption != null && $sarchedOption  == "my") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE author_id = '$currentUserID'";
        }
        else if ($sarchedOption != null && $sarchedOption  == "starterOnly") {
            //get recipe id on selected meal category
            $sqlCondition = "WHERE ";
            $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '1'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                    if($i < $result->num_rows){
                        $sqlCondition = $sqlCondition . "OR ";
                    }
                    $i++;
                }
            }

            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition;
            //echo $query;
        }
        else if ($sarchedOption != null && $sarchedOption  == "soupOnly") {
            //get recipe id on selected meal category
            $sqlCondition = "WHERE ";
            $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '2'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                    if($i < $result->num_rows){
                        $sqlCondition = $sqlCondition . "OR ";
                    }
                    $i++;
                }
            }

            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition;
            //echo $query;
        }
        else if ($sarchedOption != null && $sarchedOption  == "mainOnly") {
            //get recipe id on selected meal category
            $sqlCondition = "WHERE ";
            $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '3'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                    if($i < $result->num_rows){
                        $sqlCondition = $sqlCondition . "OR ";
                    }
                    $i++;
                }
            }

            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition;
            //echo $query;
        }
        else if ($sarchedOption != null && $sarchedOption  == "dessertOnly") {
            //get recipe id on selected meal category
            $sqlCondition = "WHERE ";
            $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '4'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                    if($i < $result->num_rows){
                        $sqlCondition = $sqlCondition . "OR ";
                    }
                    $i++;
                }
            }

            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition;
            //echo $query;
        }
        else if ($sarchedOption != null && $sarchedOption  == "snackOnly") {
            //get recipe id on selected meal category
            $sqlCondition = "WHERE ";
            $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '5'";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                    if($i < $result->num_rows){
                        $sqlCondition = $sqlCondition . "OR ";
                    }
                    $i++;
                }
            }

            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition;
            //echo $query;
        }else if ($sarchedOption != null && $sarchedOption  == "notKnownOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '1'";
        }else if ($sarchedOption != null && $sarchedOption  == "czOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '2'";
        }else if ($sarchedOption != null && $sarchedOption  == "vietOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '3'";
        }else if ($sarchedOption != null && $sarchedOption  == "itOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '4'";
        }else if ($sarchedOption != null && $sarchedOption  == "hungOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '5'";
        }else if ($sarchedOption != null && $sarchedOption  == "spainOnly") {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '6'";
        }else {
            $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes";
        }
        $result = $connect->query($query);
        // Get the total number of records from our table "students".
        $total_pages = $result != null ? $result->num_rows : 0;

        // Check if the page number is specified and check if it's a number, if not -> return the default page number which is 1.
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; ?>

        <main class="recipeDiv">
            <div class="chooseOptionDiv">
                <button class="chooseOption" type="button" onclick="location.href='viewAllRecipes.php?page=1&option=my'">Pouze moje recepty</button>
                <button class="chooseOption" type="button" onclick="location.href='viewAllRecipes.php?page=1&option=default'">Všechny recepty</button>
                <select class="chooseOption" onchange="location = this.value;">
                    <option hidden selected disabled>Podle kategorie ...</option>
                    <option value="viewAllRecipes.php?page=1&option=starterOnly">Předkrmy</option>
                    <option value="viewAllRecipes.php?page=1&option=soupOnly">Polévky</option>
                    <option value="viewAllRecipes.php?page=1&option=mainOnly">Hlavní jídla</option>
                    <option value="viewAllRecipes.php?page=1&option=dessertOnly">dezerty</option>
                    <option value="viewAllRecipes.php?page=1&option=snackOnly">svačiny</option>
                </select>
                <select class="chooseOption" onchange="location = this.value;">
                    <option hidden selected disabled>Podle země původu ...</option>
                    <option value="viewAllRecipes.php?page=1&option=notKnownOnly">Neznámá</option>
                    <option value="viewAllRecipes.php?page=1&option=czOnly">Čechy</option>
                    <option value="viewAllRecipes.php?page=1&option=vietOnly">Vietnam</option>
                    <option value="viewAllRecipes.php?page=1&option=itOnly">Itálie</option>
                    <option value="viewAllRecipes.php?page=1&option=hungOnly">Maďarsko</option>
                    <option value="viewAllRecipes.php?page=1&option=spainOnly">Španělsko</option>
                </select>
            </div>
            <hr>

            <?php
            // Number of results to show on each page.
            $num_results_on_page = 5;

            if ($sarchedOption != null && $sarchedOption  == "my") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE author_id = '$currentUserID' LIMIT ?,?";
            }
            else if ($sarchedOption != null && $sarchedOption  == "starterOnly") {
                //get recipe id on selected meal category
                $sqlCondition = "WHERE ";
                $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '1'";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                        if($i < $result->num_rows){
                            $sqlCondition = $sqlCondition . "OR ";
                        }
                        $i++;
                    }
                }
    
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition. "LIMIT ?,?";
                //echo $query;
            }
            else if ($sarchedOption != null && $sarchedOption  == "soupOnly") {
                //get recipe id on selected meal category
                $sqlCondition = "WHERE ";
                $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '2'";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                        if($i < $result->num_rows){
                            $sqlCondition = $sqlCondition . "OR ";
                        }
                        $i++;
                    }
                }
    
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition. "LIMIT ?,?";
                //echo $query;
            }
            else if ($sarchedOption != null && $sarchedOption  == "mainOnly") {
                //get recipe id on selected meal category
                $sqlCondition = "WHERE ";
                $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '3'";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                        if($i < $result->num_rows){
                            $sqlCondition = $sqlCondition . "OR ";
                        }
                        $i++;
                    }
                }
    
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition. "LIMIT ?,?";
                //echo $query;
            }
            else if ($sarchedOption != null && $sarchedOption  == "dessertOnly") {
                //get recipe id on selected meal category
                $sqlCondition = "WHERE ";
                $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '4'";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                        if($i < $result->num_rows){
                            $sqlCondition = $sqlCondition . "OR ";
                        }
                        $i++;
                    }
                }
    
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition. "LIMIT ?,?";
                //echo $query;
            }
            else if ($sarchedOption != null && $sarchedOption  == "snackOnly") {
                //get recipe id on selected meal category
                $sqlCondition = "WHERE ";
                $query = "SELECT recipe_id FROM recipe_mealcategory WHERE mealCategory_id = '5'";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $sqlCondition = $sqlCondition . "ID = '".$row['recipe_id']."' ";
                        if($i < $result->num_rows){
                            $sqlCondition = $sqlCondition . "OR ";
                        }
                        $i++;
                    }
                }
    
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes ".$sqlCondition. "LIMIT ?,?";
                //echo $query;
            } else if ($sarchedOption != null && $sarchedOption  == "notKnownOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '1' LIMIT ?,?";
            }else if ($sarchedOption != null && $sarchedOption  == "czOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '2' LIMIT ?,?";
            }else if ($sarchedOption != null && $sarchedOption  == "vietOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '3' LIMIT ?,?";
            }else if ($sarchedOption != null && $sarchedOption  == "itOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '4' LIMIT ?,?";
            }else if ($sarchedOption != null && $sarchedOption  == "hungOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '5' LIMIT ?,?";
            }else if ($sarchedOption != null && $sarchedOption  == "spainOnly") {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes WHERE originCountry_id = '6' LIMIT ?,?";
            } else {
                $query = "SELECT ID, name, date, directions, author_id, originCountry_id, imgUrl FROM recipes LIMIT ?,?";
            }
            if ($stmt = $connect->prepare($query)) {
                // Calculate the page to get the results we need from our table.
                $calc_page = ($page - 1) * $num_results_on_page;
                $stmt->bind_param('ii', $calc_page, $num_results_on_page);
                $stmt->execute();
                // Get the results...
                $result = $stmt->get_result();

                // for all recipes
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $recipe_id = htmlspecialchars($row["ID"], ENT_QUOTES);
                        $imgUrl = htmlspecialchars($row["imgUrl"], ENT_QUOTES);
                        $originCountry = "Neznámá";
                        $originCountry_id = htmlspecialchars($row["originCountry_id"], ENT_QUOTES);
                        $author = "Neznámý";
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
                                }
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



                        //prepare meal category
                        $htmlMealCategories = "<ul>";
                        for ($i = 0; $i < sizeof($mealCategories); $i++) {
                            $htmlMealCategories = $htmlMealCategories . "<li>" . $mealCategories[$i] . "</li>";
                        }
                        $htmlMealCategories = $htmlMealCategories . "</ul>";
                        //check if image url doesn't exists show default image
                        if (!@getimagesize($imgUrl)) {
                            $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/Uploads/default.jpg';
                        } else {
                            $imgUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/MyCookBook/' . $imgUrl;
                        }
                        // echo HTML div of 1 recipe
            ?>

                        <h1><?php echo htmlspecialchars($row["name"], ENT_QUOTES); ?> </h1>

                        <p> <strong>Identifikační číslo receptu:</strong> <?php echo $recipe_id; ?></p>

                        <p><strong>Autor:</strong> <?php echo $author; ?></p>
                        <p><strong>Země původu:</strong> <?php echo $originCountry; ?></p>

                        <p class="margin0"><strong> Vhodné jako:</strong> </p> <?php echo $htmlMealCategories; ?>

                        <p> <strong>Náhled obrázku</strong></p>
                        <p><img class=preview src=" <?php echo $imgUrl  ?>" alt=Obrázek> </p>
                        <button type=button onclick="location.href='viewRecipe.php?id=<?php echo htmlspecialchars($row['ID'], ENT_QUOTES)    ?>'">Více informací&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-search'></i></button>
                        <hr>
        <?php
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

        </main> <br>
        <!--Footer-->
        <footer>
            <p>Autor: Ondřej Bureš, Kontakt:
                <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
            </p>
        </footer>

</body>

</html>