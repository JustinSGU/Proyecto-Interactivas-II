<?php 
    require_once '../../database.php';
    // Reference: https://medoo.in/api/select
    $items = $database->select("tb_destinations","*");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Destinations</title>
</head>
<body>
    <h2>Registered Destinations</h2>
    <table>
        <?php
            foreach($items as $item){
                echo "<tr>";
                echo "<td>".$item["destination_lname"]."</td>";
                echo "<td><a href='edit-destination.php?id=".$item["id_destination"]."'>Edit</a> <a href='delete-destination.php?id=".$item["id_destination"]."'>Delete</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
    
</body>
</html>