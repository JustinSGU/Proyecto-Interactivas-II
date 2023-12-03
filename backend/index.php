<?php

    $title = "PHP - Backend";
    $status = true;
    $total = 10;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-End</title>
    <style>
        body{
            font-family: Arial;
            margin: 0;
            padding: 0;
        }
        .title{
            font-size: 6rem;
        }
        .content{
            font-size: 4rem;
        }
    </style>
</head>
<body>
    <h1 class="title"><?php echo $title; ?></h1>
    <?php

        if($status){
            echo "<p class='content'>content goes here: ".$total."</p>";
        }

    ?>

    <form method="post" action="response.php">
        <label for="">Name</label>
        <input name="fname" type="text" >
        <label for="">Total</label>
        <input name="total" type="text" >
        <input type="submit" value="SUBMIT">
    </form>
    
</body>
</html>