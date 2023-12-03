<?php
    require_once '../database.php';

    $people = 1;
    $days = 1;
    $checkin = "";
    $pos_array = -1;

    if($_GET){
       
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
            "tb_camping_categories.camping_max_people"
        ],[
            "id_destination"=>$_GET["id"]
        ]);

        // Reference: https://medoo.in/api/select
        $tours = $database->select("tb_destination_activities","*");

        // Reference: https://medoo.in/api/select
        $amenities = $database->select("tb_destination_amenities","*");

        $booking_details = [];
        if(isset($_GET["index"])){
            $data = json_decode($_COOKIE['destinations'], true);
            $booking_details = $data[$_GET["index"]];
            var_dump($booking_details);

            $people = $booking_details["people"];
            $days = $booking_details["days"];
            $checkin = $booking_details["checkin"];
            $pos_array = $_GET["index"];
        }
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
        //include "./parts/header.php";
    ?>
    <main>
        <!-- destinations -->
        <section id="booking" class="destinations-container booking-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Book Online</h2>
            <div class="activities-container">
          
                <?php
                    echo "<section class='activity'>";
                        echo "<div class='activity-thumb'>";
                            echo "<img class='activity-image' src='./imgs/".$item[0]["destination_image"]."' alt='".$item[0]["destination_lname"]."'>";
                        echo "</div>";
                        echo "<h3 class='activity-title'>".$item[0]["destination_lname"].", ".$item[0]["us_state_name"]."</h3>";
                        echo "<p class='activity-category'>".$item[0]["camping_category_name"].": ".$item[0]["camping_category_description"]."</p>";
                        echo "<p class='activity-text'>".$item[0]["destination_description"]."</p>";
                        echo "<p class='destination-price'>$".$item[0]["destination_price"]." per night</p>";
                        
                        echo "<p class='activity-category'>Tours with seats available, reservations are the only way to ensure a spot on a tour.*</p>";
                        echo "<h3 class='activity-title'>Cancellation Terms</h3>";
                        echo "<ul class='terms'>"
                            ."<li>Under 'Cancellation policies', you can choose between a fully flexible or a customised policy - or apply different policies to different room types."
                            ."<li>With a fully flexible policy, your guests will only pay when they stay at your property, and can cancel free of charge during a time frame of your choice prior to check-in."
                            ."<li>With a customised policy, you can choose how long before check-in guests can cancel for free, and how much they'll be charged if they do cancel after that point. You can also set up a prepayment before check-in, and define how and when you'd like to receive that payment. On top of that, you can apply different policies to different room types."
                            ."<li>With pre-authorisation preferences, you can show guests whether you'll pre-authorise their card or not, as well as how much you'll pre-authorise and when. Pre-authorisation can be applied to specific policy types, too."
                            ."<li>With a deposit, you can make sure you're covered financially if a guest cancels a booking. If the guest does end up staying, you can give them back the money afterwards, or simply deduct it from the overall price of the reservation. Deposits are usually paid by bank transfer, so this is particularly useful if you aren't able to charge credit cards.";
                        echo "</ul>";
                    echo "</section>";
                    //booking details
                    echo "<div class='activity'>";
                        echo "<form class='form-container' action='confirmation.php' method='post'>"
                            ."<h3 class='activity-title'>Days</h3>"
                            ."<hr>"
                            ."<div class='form-items'>"
                                ."<div>"
                                    ."<label class='form-label' for='checkin'>Check-In</label>"
                                ."</div>"
                                ."<div>"
                                    ."<input id='checkin' class='form-input' class='form-input' type='date' name='checkin' min='' max='2024-06-30' data-check='".$checkin."'>"
                                ."</div>"
                            ."</div>"
                            ."<div class='form-items'>"
                                ."<div>"
                                    ."<label class='form-label' for='people'>Number of people</label>"
                                ."</div>"
                                ."<div>"
                                    ."<input id='people' class='form-input' type='number' name='people' min='1' max='".$item[0]["camping_max_people"]."' value='".$people."'>"
                                ."</div>"
                            ."</div>"
                            ."<div class='form-items'>"
                                ."<div>"
                                    ."<label class='form-label' for='checkout'>Days to stay (min. 1)</label>"
                                ."</div>"
                                ."<div>"
                                    ."<input id='checkout' class='form-input' type='number' name='checkout' min='1' max='50' value='".$days."'>"
                                ."</div>"
                            ."</div>";
                            echo "<p class='checkout'>Check out: <span id='day-out' class='price-small'></span></p>";
                            echo "<h3 class='activity-title'>Extras</h3>"
                            ."<hr>";
                            foreach($amenities as $index=>$amenity){
                                $extra_price = 0;

                                if(count($booking_details) > 0){
                                    foreach($booking_details["extras"] as $extra){
                                        if(in_array($amenity["destination_amenity"], $extra)) $extra_price = $extra["qty"];
                                    }
                                }

                                echo "<div class='form-items'>"
                                    ."<div>"
                                        ."<label class='form-label destination-extra' for='am".$index."'>".$amenity["destination_amenity"]."<span class='price-small'>($".$amenity["destination_amenity_price"].")</span></label>"
                                    ."</div>"
                                    ."<div>"
                                        ."<input id='am".$index."' data-index='".$index."' data-price='".$amenity["destination_amenity_price"]."' class='form-input' type='number' oninput='updateSubtotal(this)' name='extras[]' step='1' value='".$extra_price."' min='0' max='50'>"
                                    ."</div>"
                                    ."<div>"
                                        ."<p id='amenity".$index."'>$0</p>"
                                    ."</div>"
                                ."</div>";
                            }
                            echo "<h3 class='activity-title'>Tours</h3>"
                            ."<hr>";
                            foreach($tours as $index=>$tour){
                                $tour_price = 0;

                                if(count($booking_details) > 0){
                                    foreach($booking_details["tours"] as $r_tour){
                                        if(in_array($tour["destination_activity_name"], $r_tour)) $tour_price = $r_tour["qty"];
                                    }
                                }
                                
                                echo "<div class='form-items'>"
                                    ."<div>"
                                        ."<label class='form-label destination-extra' for='".$tour["destination_activity_name"]."'>".$tour["destination_activity_name"]."<span class='price-small'>($".$tour["destination_activity_price"].")</span></label>"
                                    ."</div>"
                                    ."<div>"
                                        ."<input id='tr".$index."' data-index='".$index."' data-price='".$tour["destination_activity_price"]."' class='form-input' type='number' oninput='updateToursTotal(this)' name='tours[]' min='0' max='".$item[0]["camping_max_people"]."' step='1' value='".$tour_price."'>"
                                    ."</div>"
                                    ."<div>"
                                        ."<p id='tour".$index."'>$0</p>"
                                    ."</div>"
                                ."</div>";
                            }
                            echo "<input type='hidden' name='id_destination' value='".$item[0]["id_destination"]."'>";
                            echo "<input type='hidden' id='destination_price' value='".$item[0]["destination_price"]."'>";
                            echo "<input type='hidden' id='confirmed_day_out' value='' name='date-out'>";
                            echo "<input type='hidden' value='".$pos_array."' name='index'>";
                            echo "<input type='submit' class='btn read-btn booking-btn' value='Add to cart'>";
                        echo "</form>";
                        echo "<h3 class='activity-title'>Total: $<span id='total'></span></h3>";
                    echo "</div>"
                ?>
                
                
            </div>

        </section>
        <!-- destinations -->

        <!-- subscribe -->
        <div class="activities-container subscribe">
            <section class="in-touch">
                <h2 class="destinations-title margin-none subscribe-title">Let's Stay in Touch</h2>
                <p>Get travel planning ideas, helpful tips, and stories from our visitors delivered right to your inbox.</p>
                <form class="subscribe-form" action="">
                    <img src="./imgs/icons/email.svg" alt="email address">
                    <input class="email" type="text" placeholder="Email Address">
                    <input class="submit-btn" type="submit" value="">
                </form>
            </section>
            <div>
                <img class="subscribe-image" src="./imgs/camping-graphic.webp" alt="Let's Stay in Touch">
            </div>
        </div>
        <!-- subscribe -->

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.3/build/global/luxon.min.js"></script>
    <script>
        let total = 0;
        let itemsSubTotal = 0;
        let toursSubTotal = 0;
        let destination_price = document.getElementById("destination_price").value;

        let DateTime = luxon.DateTime;

        function updateToursTotal(obj){
            let totalTours = 0;
            
            let subtotal = obj.getAttribute("data-price") * obj.value;
            document.getElementById("tour"+obj.getAttribute("data-index")).innerHTML = "$ "+subtotal;

            for(let i=0; i<6; i++){
                totalTours += document.getElementById("tr"+i).getAttribute("data-price") * document.getElementById("tr"+i).value;
            }
            toursSubTotal = totalTours;
            updateTotal();
        }

        function updateSubtotal(obj){
            let totalExtras = 0;
            
            let subtotal = obj.getAttribute("data-price") * obj.value;
            document.getElementById("amenity"+obj.getAttribute("data-index")).innerHTML = "$ "+subtotal;

            for(let i=0; i<11; i++){
                totalExtras += document.getElementById("am"+i).getAttribute("data-price") * document.getElementById("am"+i).value;
            }
            itemsSubTotal = totalExtras;
            updateTotal();
        }

        function updateTotal(){
            total = toursSubTotal + itemsSubTotal + (destination_price * people.value) * checkout.value;
            document.getElementById("total").innerHTML = total;
        }

        function updateCheckOut(){
            let dateIn = DateTime.fromISO(checkin.value);
            let dateOut = dateIn.plus({days: checkout.value})
            document.getElementById("day-out").innerHTML = dateOut.weekdayShort+" "+dateOut.day+" "+dateOut.monthShort+", "+dateOut.year;
            //date value to checkout
            document.getElementById("confirmed_day_out").setAttribute('value', dateOut.year+"-"+dateOut.month+"-"+dateOut.day);
        }

        document.addEventListener("DOMContentLoaded", function(){
            const now = DateTime.now();
            let currentDate = now.year+"-"+now.month+"-"+now.day;

            let checkin = document.getElementById("checkin");
            checkin.setAttribute("min", currentDate);
            if(checkin.getAttribute("data-check") == "") checkin.setAttribute("value", currentDate);
            else checkin.setAttribute("value", checkin.getAttribute("data-check"));
            

            let people = document.getElementById("people");
            
            checkin.addEventListener("change", function(){
                updateCheckOut();
                updateTotal();
            });

            people.addEventListener("change", function(){
                updateTotal();
            });

            checkout.addEventListener("input", function(){
                updateCheckOut();
                updateTotal();
            });

            updateCheckOut()
            updateTotal();

        });

    </script>
  
</body>
</html>

