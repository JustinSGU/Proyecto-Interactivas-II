<?php 
    require_once 'database.php';
    // Reference: https://medoo.in/api/select
    if($_GET){
    $data = $database->select("tb_users","*",[
        "id_user"=> $_GET["id"]
    ]);
}

if($_POST){
    // Reference: https://medoo.in/api/delete
    $database->delete("tb_users",[
        "id_user"=>$_POST["id"]
    ]);
    header("location:list-users.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Delete user: <?php echo $data[0]["usr"]?></h2>
    <form method="post" aciton="delete.php">
        <input type="button" value="cancel" onclick="history.back();">
        <input type="hidden" name="id" value="<?php echo $data[0]["id_user"]?> ">
        <input type="submit" value="SUBMIT">
    </form>
    
</body>
</html>