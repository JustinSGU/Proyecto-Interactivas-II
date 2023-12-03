<?php
    require_once '../database.php';

    $destination_details = [];
    $r_extras = [];
    $r_tours = [];

    $registered_tours = $database->select("tb_destination_activities","*");
    $registered_extras = $database->select("tb_destination_amenities","*");

    $data = json_decode($_COOKIE['destinations'], true);
        
    $booking_details = $data;
    //var_dump($booking_details);
   
    
    
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

        if(session_status() === PHP_SESSION_ACTIVE){
            if(isset($_SESSION["isLoggedIn"])){
                echo "SESSION -> insert to DB";
            }
        }else{
            echo "NO SESSION -> redirect to forms";
        }
    ?>
    <main>
        <!-- destinations -->
        <section class="destinations-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Thank you! Your booking has been received.</h2>

        </section>
        <!-- destinations -->

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
</body>
</html>