<?php
    require_once '../database.php';
    $message = "";

    if($_POST){

        if(isset($_POST["login"])){
            //validate if user already logged in
            session_start();
            if(isset($_SESSION["isLoggedIn"])){
                header("location: book.php?id=".$_POST["login"]);
            }else{
                //validate login
                echo "validate login: ".$_POST["login"];
            }
        }

        if(isset($_POST["register"])){
            //validate if user already registered
            $validateUsername = $database->select("tb_users","*",[
                "usr"=>$_POST["username"]
            ]);

            if(count($validateUsername) > 0){
                $message = "This username is already registered";
            }else{
                $database->insert("tb_users",[
                    "fullname"=> $_POST["fullname"],
                    "usr"=> $_POST["username"],
                    "pwd"=> $_POST["password"],
                    "email"=> $_POST["email"]
                ]);

                header("location: book.php?id=".$_POST["register"]);
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
    <header class="hero-container">
        <nav class="top-nav">
            <a href="#"><img src="./imgs/logo.svg" alt="Camping logo"></a>
            <!-- mobile nav btn -->
            <input class="mobile-check" type="checkbox">
            <label class="mobile-btn">
                <span></span>
            </label>
            <!-- mobile nav btn -->
            <ul class="nav-list">
                <li><a class="nav-list-link" href="#">Home</a></li>
                <li><a class="nav-list-link" href="#">Destination</a></li>
                <li><a class="nav-list-link" href="#">Near me</a></li>
                <li><a class="nav-list-link" href="#">Events</a></li>
                <li><a class="nav-list-link" href="#">Blog</a></li>
                <li><a class="nav-list-link" href="#">Gallery</a></li>
                <li><a class="nav-list-link" href="#">About</a></li>
                <li><a class="nav-list-link" href="#">Contact us</a></li>
            </ul>
        </nav>
        <h1 class="hero-title">Find Yourself Outside.</h1>
        <p class="hero-text">Book unique camping experiences on over 300,000 campsites, cabins, RV parks, public parks and more.</p>
        <div class="cta-container">
            <a class="btn nav-list-link" href="#">Discover</a>
        </div>
        
    </header>
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
                        <input type="hidden" name="login" value="<?php echo $_GET["id"]; ?>">
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
                        <input type="hidden" name="register" value="<?php echo $_GET["id"]; ?>">
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
    <footer class="footer-container">

        <div class="footer-content">
            <section>
                <h3>Hipcamp is everywhere you want to camp.</h3>
                <p>Discover unique experiences on ranches, nature preserves, farms, vineyards, and public campgrounds across the U.S. Book tent camping, treehouses, cabins, yurts, primitive backcountry sites, car camping, airstreams, tiny houses, RV camping, glamping tents and more.</p>
            </section>
            <div class="footer-links">
                <section>
                    <h3>Get to Know Us</h3>
                    <ul class="nav-bottom-list">
                        <li><a class="nav-bottom-link" href="#">About Us</a></li>
                        <li><a class="nav-bottom-link" href="#">Rules & Reservation Policies</a></li>
                        <li><a class="nav-bottom-link" href="#">Accessibility</a></li>
                        <li><a class="nav-bottom-link" href="#">Media Center</a></li>
                        <li><a class="nav-bottom-link" href="#">Site Map</a></li>
                    </ul>
                </section>
                <section>
                    <h3>Plan with Us</h3>
                    <ul class="nav-bottom-list">
                        <li><a class="nav-bottom-link" href="#">Find Trip Inspiration</a></li>
                        <li><a class="nav-bottom-link" href="#">Build a Trip</a></li>
                        <li><a class="nav-bottom-link" href="#">Accessibility</a></li>
                        <li><a class="nav-bottom-link" href="#">Buy a Pass</a></li>
                        <li><a class="nav-bottom-link" href="#">Enter a Lottery</a></li>
                    </ul>
                </section>
                <section>
                    <h3>Let Us Help You</h3>
                    <ul class="nav-bottom-list">
                        <li><a class="nav-bottom-link" href="#">Your Account</a></li>
                        <li><a class="nav-bottom-link" href="#">Your Reservations</a></li>
                        <li><a class="nav-bottom-link" href="#">Contact Us</a></li>
                        <li><a class="nav-bottom-link" href="#">Help Center</a></li>
                        <li><a class="nav-bottom-link" href="#">Submit Feedback</a></li>
                    </ul>
                </section>
            </div>
        </div>
        <section class="download-app">
            <h3>Download our App</h3>
            <div class="cta-app-container">
                <a href=""><img src="./imgs/app-store.png" alt="Our app from App Store"></a>
                <a href=""><img src="./imgs/google-play.png" alt="Our app from Google Play"></a>
            </div>
        </section>
        <p class="footer-legal">&copy; 2023. All rights reserved.</p>
    </footer>
    
  
</body>
</html>

