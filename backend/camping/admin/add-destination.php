<?php 
    /***
     * 0. include database connection file
     * 1. receive form values from post and insert them into the table (match table field with values from name atributte)
     * 2. for the destination_image insert the value "destination-placeholder.webp"
     * 3. redirect to destinations-list. php after complete the insert into
     */

     require_once '../../database.php';

     // Reference: https://medoo.in/api/select
     $states = $database->select("tb_us_states","*");

     // Reference: https://medoo.in/api/select
     $categories = $database->select("tb_camping_categories","*");

     $message = "";

     if($_POST){

        if(isset($_FILES["destination_image"])){
            $errors = [];
            $file_name = $_FILES["destination_image"]["name"];
            $file_size = $_FILES["destination_image"]["size"];
            $file_tmp = $_FILES["destination_image"]["tmp_name"];
            $file_type = $_FILES["destination_image"]["type"];
            $file_ext_arr = explode(".", $_FILES["destination_image"]["name"]);

            $file_ext = end($file_ext_arr);
            $img_ext = ["jpeg", "png", "jpg", "webp"];

            if(!in_array($file_ext, $img_ext)){
                $errors[] = "File type is not valid";
                $message = "File type is not valid";
            }

            if(empty($errors)){
                $filename = strtolower($_POST["destination_lname"]);
                $filename = str_replace(',', '', $filename);
                $filename = str_replace('.', '', $filename);
                $filename = str_replace(' ', '-', $filename);
                $img = "location-".$filename.".".$file_ext;
                move_uploaded_file($file_tmp, "../imgs/".$img);

                $database->insert("tb_destinations",[
                    "id_us_state"=> $_POST["destination_state"],
                    "id_camping_category"=>$_POST["destination_category"],
                    "destination_lname"=>$_POST["destination_lname"],
                    "destination_sname"=>$_POST["destination_sname"],
                    "destination_description"=>$_POST["destination_description"],
                    "destination_image"=> $img,
                    "destination_price"=>$_POST["destination_price"]
                ]);
            }
        }
        
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Destination</title>
    <link rel="stylesheet" href="../css/themes/admin.css">
</head>
<body>
    <div class="container">
        <h2>Add New Destination</h2>
        <?php 
            echo $message;
        ?>
        <form method="post" action="add-destination.php" enctype="multipart/form-data">
            <div class="form-items">
                <label for="destination_lname">Destination Name</label>
                <input id="destination_lname" class="textfield" name="destination_lname" type="text">
            </div>
            <div class="form-items">
                <label for="destination_sname">Destination Short Name</label>
                <input id="destination_sname" class="textfield" name="destination_sname" type="text">
            </div>
            <div class="form-items">
                <label for="destination_state">Destination State</label>
                <select name="destination_state" id="destination_state">
                    <?php 
                        foreach($states as $state){
                            echo "<option value='".$state["id_us_state"]."'>".$state["us_state_name"]."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-items">
                <label for="destination_category">Destination Category</label>
                <select name="destination_category" id="destination_category">
                    <?php 
                        foreach($categories as $category){
                            echo "<option value='".$category["id_camping_category"]."'>".$category["camping_category_name"]."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-items">
                <label for="destination_description">Destination Description</label>
                <textarea id="destination_description" name="destination_description" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-items">
                <label for="destination_image">Destination Image</label>
                <img id="preview" src="../imgs/destination-placeholder.webp" alt="Preview">
                <input id="destination_image" type="file" name="destination_image" onchange="readURL(this)">
            </div>
            <div class="form-items">
                <label for="destination_price">Destination Price</label>
                <input id="destination_price" class="textfield" name="destination_price" type="text">
            </div>
            <div class="form-items">
                <input class="submit-btn" type="submit" value="Add New Destination">
            </div>
        </form>
    </div>

    <script>
        function readURL(input) {
            if(input.files && input.files[0]){
                let reader = new FileReader();

                reader.onload = function(e) {
                    let preview = document.getElementById('preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
    </script>
    
</body>
</html>