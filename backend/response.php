<?php
    //var_dump($_POST);
    /*

    */
    require_once 'database.php';
    // Reference: https://medoo.in/api/insert
    if($_POST){
        $database->insert("tb_users",[
            "usr"=> $_POST["usr"],
            "pwd"=> $_POST["pwd"],
            "email"=> $_POST["email"]
        ]);
    }
    
?>