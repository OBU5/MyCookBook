<?php
session_start();
// if the user is not logged in, redirrect him
if (!isset($_SESSION["username"])) {
     header("location:index.php?action=login");
}
$connect = mysqli_connect("localhost", "root", "", "test");
// Check connection
if (!$connect) {
     die("Connection failed: No database found");
} else {
     $connect->set_charset("UTF-8");
     session_start();
}
if ($connect) {
     $query = "SELECT * FROM users";
     $result = $connect->query($query);

     if ($result->num_rows > 0) {
          $total_pages = $result->num_rows;

          // Check if the page number is specified and check if it's a number, if not -> return the default page number which is 1.
          $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;


          // Number of results to show on each page.
          $num_results_on_page = 5;
          $query = "SELECT * FROM users LIMIT ?,?";

          if ($stmt = $connect->prepare($query)) {
               // Calculate the page to get the results we need from our table.
               $calc_page = ($page - 1) * $num_results_on_page;
               $stmt->bind_param('ii', $calc_page, $num_results_on_page);
               $stmt->execute();
               // Get the results...
               $result = $stmt->get_result();
          }
     } else {
          echo "<p>0 results</p>";
     }
}
?>
<!DOCTYPE html>
<html>


<head>

     <link rel="stylesheet" href="Styles/styles.css">
     <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>


<body>
     <!--Navigation bar-->
     <div class="topnav">
          <a href="index.php">Domů</a>
          <a href="viewAllRecipes.php">Zobrazit recepty</a>
          <a href="addRecipe.php">Přidat nový recept</a>
          <a href="about.php">About</a>
          <?php
          if (!isset($_SESSION["username"])) {
               // User is not logged in
               echo '<a class="active" href="login.php?action=login">Login</a>';
          } else {
               // User is  logged in
               echo '<a class="active" href="userInfo.php">' . $_SESSION["username"] . '</a>';
          } ?>
     </div>
     <br /><br />
     <div class="userDiv">
          <h3 align="center">Informace o Vás</h3>
          <br>
          <?php

          // output data of each row
          while ($row = $result->fetch_assoc()) {

               echo "<table class =  userInfo>
                              <tr>
                                   <th> jméno </th>
                                   <td>" . $row["name"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Příjmení </th>
                                   <td>" . $row["lastname"] . "</td>
                              <tr/>
                              <tr>
                                   <th> email </th>
                                   <td>" . $row["email"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Username </th>
                                   <td>" . $row["username"] . "</td>
                              <tr/>
                              <tr>
                                   <th> Role </th>
                                   <td>" . $row["role"] . "</td>
                              <tr/>                              
                         </table>
                         <br>
                         <button type=button onclick=location.href='editLogin.php?id=" . $row["ID"] .  "'>Upravit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-edit'></i></button>             
                         <br><br>
                          <hr>
                         ";
          }

          echo '<br><br>';
          ?><?php
               // Pagination
               if (ceil($total_pages / $num_results_on_page) > 0) : ?>

          <div class="pagination">
               <ul class="pagination">
                    <?php if ($page > 1) : ?>
                         <li class="prev"><a href="viewAllUserInfo.php?page=<?php echo $page - 1 ?>">Předchozí</a></li>
                    <?php endif; ?>

                    <?php if ($page > 3) : ?>
                         <li class="start"><a href="viewAllUserInfo.php?page=1">1</a></li>
                         <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($page - 2 > 0) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                    <?php if ($page - 1 > 0) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="viewAllUserInfo.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                    <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                    <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="viewAllUserInfo.php?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page) - 2) : ?>
                         <li class="dots">...</li>
                         <li class="end"><a href="viewAllUserInfo.php?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($page < ceil($total_pages / $num_results_on_page)) : ?>
                         <li class="next"><a href="viewAllUserInfo.php?page=<?php echo $page + 1 ?>">Další</a></li>
                    <?php endif; ?>
               </ul>
          </div>
     <?php endif; ?>
     </div>

     <!--Footer-->
     <footer>
          <p>Autor: Ondřej Bureš, Kontakt:
               <a href="mailto:bures.ondrej95@gmail.com">bures.ondrej95@gmail.com</a>
          </p>
     </footer>
</body>

</html>