<?php
require_once '../database.php';

$lang = "TR";
$url_params = "";

if($_GET){
       
    $item = $database->select("tb_destinations",[
        "[>]tb_us_states"=>["id_us_state" => "id_us_state"],
        "[>]tb_camping_categories"=>["id_camping_category" => "id_camping_category"]
    ],[
        "tb_destinations.id_destination",
        "tb_destinations.destination_lname",
        "tb_destinations.destination_lname_tr",
        "tb_destinations.destination_description",
        "tb_destinations.destination_description_tr",
        "tb_destinations.destination_image",
        "tb_destinations.destination_price",
        "tb_us_states.us_state_name",
        "tb_us_states.us_state_code",
        "tb_camping_categories.camping_category_name",
        "tb_camping_categories.camping_category_description",
    ],[
        "id_destination"=>$_GET["id"]
    ]);



    // Reference: https://medoo.in/api/select
    $tours = $database->select("tb_destination_activities", "*");
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
            <div class="activities-container">

                <?php
                echo "<section class='activity'>";
                echo "<div class='activity-thumb'>";
                echo "<img class='activity-image' src='./imgs/" . $item[0]["destination_image"] . "' alt='" . $item[0]["destination_lname"] . "'>";
                echo "<button class='like-btn'><img src='./imgs/icons/like.svg' alt='Like'></button>";
                echo "<span class='activity-price'>$" . $item[0]["destination_price"] . "/night</span>";
                echo "</div>";
                echo "<span id='lang' class='lang-btn' onclick='getTranslation(" . $item[0]["id_destination"] . ")'>TR</span>";
                echo "<h3 class='activity-title'><span id='destination-name'>" . $item[0]["destination_lname"] . "</span>, " . $item[0]["us_state_name"] . "</h3>";
                echo "<p class='activity-category'>" . $item[0]["camping_category_name"] . ": " . $item[0]["camping_category_description"] . "</p>";
                echo "<p id='destination-description' class='activity-text'>" . $item[0]["destination_description"] . "</p>";
                echo "<p class='activity-text'>People come to " . $item[0]["destination_lname"] . " for it's beauty and tranquillity but many more want to find out more. We're listing our tours with seats currently available below:</p>";
                echo "<ul class='activity-tours'>";
                foreach ($tours as $tour) {
                    echo "<li>" . $tour["destination_activity_name"] . "</li>";
                }
                echo "</ul>";
                echo "<p class='activity-category'>Tours with seats available, reservations are the only way to ensure a spot on a tour.*</p>";
                echo "<a class='btn read-btn' href='book.php?id=" . $item[0]["id_destination"] . "'>Book Online</a>";
                echo "</section>";
                ?>

            </div>

        </section>
        <!-- destinations -->

        <?php
        include "./parts/subscribe.php";
        ?>

    </main>
    <?php
    include "./parts/footer.php";
    ?>

    <script>

        let requestLang = "tr";

        function switchLang(){
            if(requestLang == "en") requestLang = "tr";
            else requestLang = "en";
            document.getElementById("lang").innerText = requestLang;
        }

        function getTranslation(id){

            let info = {
                id_destination: id,
                language: requestLang
            };

            //fetch
            fetch("http://localhost/interactivas_Justin/backend/camping/language.php", {
                method: "POST",
                mode: "same-origin",
                credentials: "same-origin",
                headers: {
                    'Accept': "application/json, text/plain, /", 
                    'Content-Type': "application/json"
                },
                body: JSON.stringify(info)
            })
            .then(response => response.json())
            .then(data=>{
                //console.log(data);
                switchLang();
                document.getElementById("destination-name").innerHTML=data.name;
                document.getElementById("destination-description").innerHTML=data.description;
            })
            .catch(err => console.log("error: " + err));
        }
    </script>
</body>

</html>