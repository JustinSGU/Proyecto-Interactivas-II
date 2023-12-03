<?php
    require_once '../database.php';
    // Reference: https://medoo.in/api/select
    $items = $database->select("tb_destinations","*");
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping Website</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@900&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <!-- google fonts -->
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <?php 
        include "./parts/header.php";
    ?>
    <main>
        <?php 
            include "./parts/activities.php";
        ?>
        <!-- destinations -->
        <section class="destinations-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Explore Destinations & Activities</h2>
            <div class="activities-container">
          
                <form method="get" action="results.php">
                    <label for="search" class="activity-title">Search</label>
                    <input id="search" class="search" type="text" name="keyword">
             <select name="filter" id="filter" class= "filter">
                      <option value="camping_category_name">Camping Category</option>
                      <option value="us_state_name">US State</option>


             </select>
                    <input type="submit" class= "btn search-btn" value="SEARCH DESTINATION" >
                </form>
                
            </div>


        </section>

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
</body>
</html>
