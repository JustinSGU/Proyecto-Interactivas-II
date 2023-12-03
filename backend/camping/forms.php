<?php
    require_once '../database.php';
    $message = "";
    $messageLogin = "";

    if($_POST){

        if(isset($_POST["login"])){
            $user = $database->select("tb_users","*",[
                "usr"=>$_POST["username"]
            ]);
            if(count($user) > 0){
                if(password_verify($_POST["password"], $user[0]["pwd"])){
                    session_start();
                    $_SESSION["isLoggedIn"] = true;
                    $_SESSION["fullname"] = $user[0]["fullname"];
                    header("location: index.php");
                }else{
                    $messageLogin = "wrong username or password";
                }
            }else{
                $messageLogin = "wrong username or password";
            }
            //validate if user already logged in
            /*session_start();
            if(isset($_SESSION["isLoggedIn"])){
                header("location: book.php?id=".$_POST["login"]);
            }else{
                //validate login
                echo "validate login: ".$_POST["login"];
            }*/
        }

        if(isset($_POST["register"])){
            //validate if user already registered
            $validateUsername = $database->select("tb_users","*",[
                "usr"=>$_POST["username"]
            ]);

            if(count($validateUsername) > 0){
                $message = "This username is already registered";
            }else{
                $pass = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 12]);
                $database->insert("tb_users",[
                    "fullname"=> $_POST["fullname"],
                    "usr"=> $_POST["username"],
                    "pwd"=> $pass,
                    "email"=> $_POST["email"]
                ]);

                //header("location: book.php?id=".$_POST["register"]);
            }
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
        include "./parts/header.php";
    ?>
    <main>
        <!-- destinations -->
        <section class="destinations-container booking-container">
            <img src="./imgs/icons/destinations.svg" alt="Explore Destinations & Activities">
            <h2 class="destinations-title">Book Online</h2>
            <div class="activities-container">
                <section class='activity'>
                    <h3 class='activity-title'>Login</h3>
                    <p>Enter your registered username and password in the designated fields.</p>
                    <form method="post" action="forms.php">
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='username'>Username</label>
                            </div>
                            <div>
                                <input id='username' class='form-input' type='text' name='username'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='password'>Password</label>
                            </div>
                            <div>
                                <input id='password' class='form-input' type='password' name='password'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <input class='form-input login-btn' type='submit' value="LOGIN">
                            </div>
                        </div>
                        <p><?php echo $messageLogin; ?></p>
                        <input type="hidden" name="login" value="1">
                    </form>
                </section>
                <section class='activity'>
                    <h3 class='activity-title'>Sign In</h3>
                    <p>Complete the registration process to enjoy our destinations.</p>
                    <form method="post" action="forms.php">
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='fullname'>Fullname</label>
                            </div>
                            <div>
                                <input id='fullname' class='form-input' type='text' name='fullname'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='email'>Email Address</label>
                            </div>
                            <div>
                                <input id='email' class='form-input' type='text' name='email'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='username'>Username</label>
                            </div>
                            <div>
                                <input id='username' class='form-input' type='text' name='username'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <label class='form-label destination-extra' for='password'>Password</label>
                            </div>
                            <div>
                                <input id='password' class='form-input' type='password' name='password'>
                            </div>
                        </div>
                        <div class='form-items'>
                            <div>
                                <input class='form-input login-btn' type='submit' value="REGISTER">
                            </div>
                        </div>
                        <p><?php echo $message; ?></p>
                        <input type="hidden" name="register" value="1">
                    </form>
                </section>
                
                
                
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
</body>
</html>

