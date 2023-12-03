<?php
    require_once '../database.php';

    $destination_details = [];
    $r_extras = [];
    $r_tours = [];
    $updateCookie = false;

    $registered_tours = $database->select("tb_destination_activities","*");
    $registered_extras = $database->select("tb_destination_amenities","*");

    $data = json_decode($_COOKIE['destinations'], true);

    if(isset($_GET["booking"]) && $_GET["booking"] >= 0 && $data != null){
        array_splice($data, $_GET["booking"], 1);
        $updateCookie = true;
    }
        
    $booking_details = $data;
    
    if($updateCookie) setcookie('destinations', json_encode($booking_details), time()+72000);
    
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
    
    <main>
        <!-- destinations -->
        <section class="destinations-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Review your cart</h2>
           
            <div class="activities-container">
                
            <?php
                if($booking_details == null){
                    echo "<p>You need to book a destination first.</p>";
                }else{

                    echo "<table style='margin-top: 2rem;'>"
                        ."<tr class='activity-title'>"
                            ."<td>Destination</td>"
                            ."<td>Days</td>"
                            ."<td>Check-in</td>"
                            ."<td>Check-out</td>"
                            ."<td>People</td>"
                            ."<td>Total</td>"
                        ."</tr>";

                    foreach ($booking_details as $index=>$booking){
                        //$subtotal_destination = ($booking["days"] * $booking["cost"]) * $booking["people"];
                        $subtotal_destination = $booking["cost"];
                        $subtotal_extras = 0;
                        $subtotal_tours = 0;
                        $data = $database->select("tb_destinations","*",["id_destination" => $booking["id"]]);
                        echo "<tr><td></td></tr>";
                        echo "<tr>"
                                ."<td class='activity-title'>".$data[0]["destination_lname"]."</td>"
                                ."<td>".$booking["days"]."</td>"
                                ."<td>".$booking["checkin"]."</td>"
                                ."<td>".$booking["checkout"]."</td>"
                                ."<td>".$booking["people"]."</td>"
                                ."<td> $".$subtotal_destination."</td>"
                            ."</tr>";
                            echo"<tr><td class='extra-title'>Selected Extras</td></tr>";
                                if(count($booking["extras"]) == 0){
                                    echo "<tr><td class='extra-item'>No Extras</td></tr>";
                                }else{
                                    foreach ($booking["extras"] as $extra){
                                        echo "<tr><td class='extra-item'>".$extra["name"]." - $".$extra["price"]." each - ".$extra["qty"]." (requested) - Total: $".$extra["price"]*$extra["qty"]."</td></tr>";
                                        $subtotal_extras += $extra["price"]*$extra["qty"];
                                    }
                                }
                            echo "<tr><td>Total - Extras: $".$subtotal_extras."</td></tr>"
                            ."<tr><td></td></tr>"
                            ."<tr><td class='extra-title'>Selected Tours</td></tr>";
                            if(count($booking["tours"]) == 0){
                                echo "<tr><td class='extra-item'>No Tours</td></tr>";
                            }else{
                                foreach ($booking["tours"] as $tour){
                                    echo "<tr><td class='extra-item'>".$tour["name"]." - $".$tour["price"]." - ".$tour["qty"]." (requested) - Total: $".$tour["price"]*$tour["qty"]."</td></tr>";
                                    $subtotal_tours += $tour["price"]*$tour["qty"];
                                }
                            }
                            echo "<tr><td>Total - Tours: $".$subtotal_tours."</td></tr>"
                            ."<tr><td></td></tr>"
                            ."<tr><td class='total-destination'>Total to pay for this destination: $".($subtotal_destination + $subtotal_extras + $subtotal_tours)."</td><td></td><td></td><td></td><td><a href='cart.php?booking=".$index."'>Delete this booking</a></td><td><a href='book.php?id=".$booking["id"]."&index=".$index."'>Edit this booking</a></td></tr>"
                            ."<tr><td></td></tr>";
                        }
                        echo "</table>";
                    }
            ?>
            </div>
            <div class='activities-container'>
                <?php 
                    if($booking_details != null) echo "<div><a class='btn read-btn' href='submit-confirmation.php'>I'm ready for booking</a></div>";
                    //unset($_COOKIE['destinations']);
                    //setcookie('destinations', '', time() - 3600);
                ?>
                <div><a class='btn read-btn' href='index.php'>Continue exploring destinations</a></div>
            </div>

        </section>
        <!-- destinations -->

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
</body>
</html>