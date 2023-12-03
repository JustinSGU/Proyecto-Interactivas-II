<?php 
    /***
     * 0. include database connection file
     * 1. receive form values from post and insert them into the table (match table field with values from name atributte)
     * 2. for the destination_image insert the value "destination-placeholder.webp"
     * 3. redirect to destinations-list. php after complete the insert into
     */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Destination</title>
    <link rel="stylesheet" href="./css/themes/admin.css">
</head>
<body>
    <div class="container">
        <h2>Add New Destination</h2>
        <form method="post" action="add-destination.php">
            <div class="form-items">
                <label for="destination_lname">Destination Name</label>
                <input id="destination_lname" class="textfield" name="destination_lname" type="text">
            </div>
            <div class="form-items">
                <label for="destination_sname">Destination Short Name</label>
                <input id="destination_sname" class="textfield" name="destination_sname" type="text">
            </div>
            <div class="form-items">
                <label for="destination_description">Destination Description</label>
                <textarea id="destination_description" name="destination_description" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="form-items">
                <label for="destination_image">Destination Image</label>
                <img id="preview" src="./imgs/destination-placeholder.webp" alt="Preview">
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