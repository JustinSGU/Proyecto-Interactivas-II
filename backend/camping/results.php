
<?php
    require_once '../database.php';
    // Reference: https://medoo.in/api/select
   // $items = $database->select("tb_destinations","*");

    if(isset($_GET["keyword"])){
    
      $items = $database->select("tb_destinations","*", [
           "destination_lname[~]" => $_GET["keyword"]
     ]);

  
    }else{
      
      echo "not found";
  
    }
  

    
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
            <?php
                if (count ($items) > 0) {
                echo "<p class='activity-text'>We found:  <span class= 'activity-title' >".count ($items)."</span> destinations</p>";
                 }
             ?>
            <div class="activities-container">
          
                <?php  
                         if (count ($items) > 0) {
                          foreach($items as $item){
                        echo "<section class='activity'>";
                        echo "<div class='activity-thumb'>";
                            echo "<img class='activity-image' src='./imgs/".$item["destination_image"]."' alt='".$item["destination_lname"]."'>";
                            echo "<button class='like-btn'><img src='./imgs/icons/like.svg' alt='Like'></button>";
                            echo "<span class='activity-price'>$".$item["destination_price"]."/night</span>";
                        echo "</div>";
                        echo "<h3 class='activity-title'>".$item["destination_sname"]."</h3>";
                        echo "<p class='activity-text'>".substr($item["destination_description"], 0, 70)."...</p>";
                        echo "<a class='btn read-btn' href='destination.php?id=".$item["id_destination"]."'>View Details</a>";
                        echo "</section>";
                        }
                       }else{
                        echo "<h3 class='activity-title'>No results for ".$_GET["keyword"]."</h3>";

  
                       }
                    
                ?>
                
            </div>

            <!-- view all -->
            <div class="cta-container">
                <a href="search.php" class="btn view-all-btn">Search more destinations</a>
            </div>
            <!-- view all -->

        </section>
        <!-- destinations -->

        <?php 
            include "./parts/subscribe.php";
        ?>

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
</body>
</html>

