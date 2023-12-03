<?php 
    /*//var_dump($_POST);
    echo "<h3>".$_POST["fname"]."</h3>";
    echo "<br>";
    $total = 200 + $_POST["total"];
    echo "<h4>".$total."</h4>";*/
    
    require_once 'database.php';
    // Reference: https://medoo.in/api/insert
    $database->insert("tb_users",[
        "usr"=>$_POST["usr"],
        "pwd"=>$_POST["pwd"],
        "email"=>$_POST["email"]
    ]);
?>
    