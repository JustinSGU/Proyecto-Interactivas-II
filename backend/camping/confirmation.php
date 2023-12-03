<?php
    require_once '../database.php';

    $destination_details = [];
    $r_extras = [];
    $r_tours = [];
    
    if($_POST){

        //var_dump($_POST);
        
        // Reference: https://medoo.in/api/select
        // Note: don't delete the [>] 
        $item = $database->select("tb_destinations",[
            "[>]tb_us_states"=>["id_us_state" => "id_us_state"],
            "[>]tb_camping_categories"=>["id_camping_category" => "id_camping_category"]
        ],[
            "tb_destinations.id_destination",
            "tb_destinations.destination_lname",
            "tb_destinations.destination_description",
            "tb_destinations.destination_image",
            "tb_destinations.destination_price",
            "tb_us_states.us_state_name",
            "tb_us_states.us_state_code",
            "tb_camping_categories.camping_category_name",
            "tb_camping_categories.camping_category_description",
        ],[
            "id_destination"=>$_POST["id_destination"]
        ]);

        //get destination cost total
        $destination_cost = ($item[0]["destination_price"] * $_POST["people"]) * $_POST["checkout"];

        // Reference: https://medoo.in/api/select
        $registered_tours = $database->select("tb_destination_activities","*");
        $registered_extras = $database->select("tb_destination_amenities","*");

        //register requested extras
        $extras = $_POST["extras"];
        $no_extras = 0;
        $no_tours = 0;
        foreach ($extras as $index=>$extra){
            if($extra > 0){
                // Reference: https://medoo.in/api/insert
                /*$database->insert("tb_reservation_extras",[
                    "id_reservation"=> $id_reservation,
                    "id_destination_amenity"=> $registered_extras[$index]["id_destination_amenity"],
                    "requested_extras"=> $extra
                ]);*/
                
                $selected_extras["name"] = $registered_extras[$index]["destination_amenity"];
                $selected_extras["price"] = $registered_extras[$index]["destination_amenity_price"];
                $selected_extras["qty"] = $extra;
                $r_extras[] = $selected_extras;

            }else{
                $no_extras++;
            }
        }

        //register requested tours
        $tours = $_POST["tours"];
        foreach ($tours as $index=>$tour){
            if($tour > 0){
                // Reference: https://medoo.in/api/insert
                /*$database->insert("tb_reservation_tours",[
                    "id_reservation"=> $id_reservation,
                    "id_destination_activity"=> $registered_tours[$index]["id_destination_activity"],
                    "requested_tours"=> $tour
                ]);*/

                $selected_tours["name"] = $registered_tours[$index]["destination_activity_name"];
                $selected_tours["price"] = $registered_tours[$index]["destination_activity_price"];
                $selected_tours["qty"] = $tour;
                $r_tours[] = $selected_tours;

            }else{
                $no_tours++;
            }
        }

        $booking_details = [];

        if (isset($_COOKIE['destinations'])) {
            /* delete/remove a cookie
            unset($_COOKIE['destinations']);
            setcookie('destinations', '', time() - 3600);*/
            $data = json_decode($_COOKIE['destinations'], true);
            
            $booking_details = $data;
            var_dump($data);
        }

        $destination_details["id"] = $_POST["id_destination"];
        $destination_details["checkin"] = $_POST["checkin"];
        $destination_details["checkout"] = $_POST["date-out"];
        $destination_details["days"] = $_POST["checkout"];
        $destination_details["people"] = $_POST["people"];
        $destination_details["cost"] = $destination_cost;
        
        if(count($r_extras) > 0) $destination_details["extras"] = $r_extras;
        else $destination_details["extras"] = [];

        if(count($r_tours) > 0) $destination_details["tours"] = $r_tours;
        else $destination_details["tours"] = [];
        
        //check if this is a booked destionation to update the array
        if($_POST["index"] >= 0){
            $booking_details[$_POST["index"]] = $destination_details;
        }else{
            $booking_details[] = $destination_details;
        }
        

        //expire in 1 hour
        setcookie('destinations', json_encode($booking_details), time()+72000);
        
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
    
    <main>
        <!-- destinations -->
        <section class="destinations-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Booking details</h2>
            <div class="activities-container">
          
                <?php
                    echo "<section class='activity'>";
                        echo"<div class='activity-thumb'>"
                            ."<img class='activity-image' src='./imgs/".$item[0]["destination_image"]."' alt='".$item[0]["destination_lname"]."'>"
                            ."<button class='like-btn'><img src='./imgs/icons/like.svg' alt='Like'></button>"
                            ."<span class='activity-price'>$".$item[0]["destination_price"]."/night</span>"
                        ."</div>"
                        ."<h3 class='activity-title'>".$item[0]["destination_lname"].", ".$item[0]["us_state_name"]."</h3>"
                        ."<table style='margin-top: 2rem;'>"
                            ."<tr class='activity-title'>"
                                ."<td>Days <br><h5>".$destination_details["days"]."</td>"
                                ."<td>Check-in <br><h5>".$destination_details["checkin"]."</td>"
                                ."<td>Check-out <br><h5>".$destination_details["checkout"]."</td>"
                                ."<td>People <br><h5>".$destination_details["people"]."</td>"
                                ."<td>Total <br><h5>".$destination_cost."</td>"
                            ."</tr>"
                        ."</table>"
                        ."<hr class='divider'>"
                        ."<h3>Selected Extras</h3>";
                        if($no_extras == count($extras)){
                            echo "<tr><td class='extra-item'>No Extras</td></tr>";
                        }else{
                            foreach ($r_extras as $extra){
                                echo"<table style='margin-top: 2rem;>"
                                    ."<tr class='activity-title'>"
                                        ."<td>Extra <br><h5>".$extra["name"]."</td>"
                                        ."<td>Price <br><h5>".$extra["price"]."</td>"
                                        ."<td>Requested <br><h5>".$extra["qty"]."</td>"
                                        ."<td>Total <br><h5>".$extra["price"]*$extra["qty"]."</td>"
                                    ."</tr>"
                                ."</table>";
                            }
                        }
                        echo "<hr class='divider'>";
                        echo "<h3>Selected Tours</h3>";
                        
                        if($no_tours == count($tours)){
                            echo "<tr><td class='extra-item'>No Tours</td></tr>";
                        }else{
                            foreach ($r_tours as $tour){
                                echo"<table style='margin-top: 2rem;>"
                                    ."<tr class='activity-title'>"
                                        ."<td>Tour<br><h5>".$tour["name"]."</td>"
                                        ."<td>Price<br><h5>".$tour["price"]."</td>"
                                        ."<td>Requested<br><h5>".$tour["qty"]."</td>"
                                        ."<td>Total<br><h5>".$tour["price"]*$tour["qty"]."</td>"
                                    ."</tr>"
                                ."</table>";    
                            }
                        }
                    echo "</section>";
                ?>
                
            </div>
            <div class='activities-container'>
                <div><a class='btn read-btn' href='cart.php'>Confirm your booking</a></div>
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