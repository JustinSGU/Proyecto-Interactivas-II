<?php
    require_once '../database.php';
    // Reference: https://medoo.in/api/select
    $items = $database->select("tb_destinations","*");

    // Reference: https://medoo.in/api/select
    $states = $database->select("tb_us_states","*");

    // Reference: https://medoo.in/api/select
    $categories = $database->select("tb_camping_categories","*");
    
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
          
                <form>
                    <!--<label for="search" class="activity-title">Search</label>
                    <input id="search" class="search" type="text" name="keyword">-->
                    <select name="destination_state" id="destination_state" class="filter">
                    <?php 
                        foreach($states as $state){
                            echo "<option value='".$state["id_us_state"]."'>".$state["us_state_name"]."</option>";
                        }
                    ?>
                    </select>

                    <select name="destination_category" id="destination_category" class="filter">
                    <?php 
                        foreach($categories as $category){
                            echo "<option value='".$category["id_camping_category"]."'>".$category["camping_category_name"]."</option>";
                        }
                    ?>
                    </select>
                    <input id="search" type="button" class="btn search-btn" value="SEARCH DESTINATION" onclick="getFilters()">
                </form>            
            </div>
            <p id='found' class='activities-container'></p>
            <div id="items" class="activities-container"></div>
        </section>

    </main>
    <?php 
        include "./parts/footer.php";
    ?>
    <script>

        function getFilters(){

            items = document.getElementById("items").innerText = "";
            

            let info = {
                state: document.getElementById("destination_state").value,
                category: document.getElementById("destination_category").value
            };

            //fetch
            fetch("http://localhost/interactivas_Justin/backend/camping/response.php", {
                method: "POST",
                mode: "same-origin",
                credentials: "same-origin",
                headers: {
                    'Accept': 'application/json, text/plain, /',
                    'Content-Type': "application/json"
                },
                body: JSON.stringify(info)
            })
            .then(response => response.json())
            .then(data => {
                //console.log(data);

                let found = document.getElementById("found");
                found.innerText = "We found: " + data.length + " destination(s)";

                //if(document.getElementById("items")!==null)document.getElementById("items").remove();

                let container = document.getElementById("items");

                data.forEach(function(item) {
                    
                    let destination = document.createElement("section");
                    destination.classList.add("activity");
                    container.appendChild(destination);
                    //thumb
                    let thumb = document.createElement("div");
                    thumb.classList.add("activity-thumb");
                    destination.appendChild(thumb);
                    //create image
                    let image = document.createElement("img");
                    image.classList.add("activity-image");
                    image.setAttribute("src", './imgs/'+item.destination_image);
                    image.setAttribute("alt", item.destination_lname);
                    thumb.appendChild(image);
                    //like button
                    let button = document.createElement("button");
                    button.classList.add("like-btn");
                    thumb.appendChild(button);
                    //like button image
                    let btnImage = document.createElement("img");
                    btnImage.setAttribute("src", './imgs/icons/like.svg');
                    btnImage.setAttribute("alt", "like");
                    button.appendChild(btnImage);
                    //price
                    let price = document.createElement("span");
                    price.classList.add("activity-price");
                    price.innerText = "$"+item.destination_price + "/night";
                    thumb.appendChild(price);
                    //title
                    let title = document.createElement("h3");
                    title.innerText = item.destination_sname;
                    destination.appendChild(title);
                    //description
                    let description = document.createElement("p");
                    description.classList.add("activity-text");
                    description.innerText = item.destination_description.substr(1,70)+ "...";
                    destination.appendChild(description);
                    //link
                    let link = document.createElement("a");
                    link.classList.add("btn");
                    link.classList.add("read-btn");
                    link.setAttribute("href", "destination.php?id="+item.id_destination);
                    link.innerText = "View Details";
                    destination.appendChild(link);
                });
            })
            .catch(err => console.log("error: " + err));
        }
    </script>
</body>
</html>