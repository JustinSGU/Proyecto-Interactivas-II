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
            <li><a class="nav-list-link" href="./index.php">Home</a></li>
            <li><a class="nav-list-link" href="./destinations.php">Destinations</a></li>
            <li><a class="nav-list-link" href="#">Near me</a></li>
            <li><a class="nav-list-link" href="#">Events</a></li>
            <li><a class="nav-list-link" href="#">Contact us</a></li>
            <?php 
                session_start();
                if(isset($_SESSION["isLoggedIn"])){
                    echo "<li><a class='nav-list-link' href='profile.php'>".$_SESSION["fullname"]."</a></li>";
                    echo "<li><a class='nav-list-link' href='logout.php'>Logout</a></li>";
                }else{
                    echo "<li><a class='nav-list-link' href='./forms.php'>Login</a></li>";
                }
            ?>
        </ul>
    </nav>
    <h1 class="hero-title">Find Yourself Outside.</h1>
    <p class="hero-text">Book unique camping experiences on over 300,000 campsites, cabins, RV parks, public parks and more.</p>
    <div class="cta-container">
        <a class="btn nav-list-link" href="#">Discover</a>
    </div>
    
</header>