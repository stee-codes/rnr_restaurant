<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Rest & Relax Restaurant</title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Rest & Relax Restaurant</h1>
            <h4>Chill cafe for the chill people</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <!-- Menu --> 
    <div class="row menu">
        
        <div class="head">
            <h1 class="mb-3">Our Menu</h1>
            <h4>Come savour the moment with us, with our dishes specially crafted to suit your tastebuds.</h4>
        </div>
        <?php
            $FoodQuery = DB::query("SELECT * FROM food");
            foreach($FoodQuery as $foodResult) {
                $foodID = $foodResult["foodID"];
                $foodName = $foodResult["foodName"];
                $foodDescription = $foodResult["foodDescription"];
                $foodPrice = $foodResult["foodPrice"];
                $foodImage = $foodResult["foodImage"];
                $foodStatus = $foodResult["foodStatus"];
            
                if ($foodStatus == 0) {
                echo ("");
                } else {
        ?>

        <div class="col-lg-3 col-sm-6 text-center my-5">
            <div class="card h-100 box-shadow">
                <form method="POST" action="order-cart.php?action=add&id=<?php echo $foodID; ?>">
                    <div class="card-header">
                        <img src="<?php echo $foodImage?>" class="card-img-top foodImg" alt="<?php echo $foodImage?>">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title my-2"><?php echo $foodID . ". " . $foodName?></h5>
                        <p class="card-text my-2"><?php echo strtolower($foodDescription)?></p>
                        <p class="card-text my-2"><?php echo "$" . $foodPrice?></p>
                        <input type="hidden" name="hidden_foodName" value="<?php echo $foodName;?>">
                        <input type="hidden" name="hidden_foodPrice" value="<?php echo $foodPrice;?>">  
                        <h5 class="text-primary">Quantity: <input type="number" min="1" max="25" name="foodQuantity" class="form-control form-control-sm my-2" value="1" style="width: 60px; display: inline-block"> </h5>
                        <?php if (isLoggedIn()){
                            echo '<input type="submit" name="addToCart" value="Add to Cart" class="btn btn-warning w-100" />';
                            } else {
                                echo '<a class="btn btn-outline-warning w-100" href="login-signup.php">Log in to start ordering</a>';
                            } 
                        ?>
                    </div>  
                </form>
            </div>
        </div>
        <?php
        }
        }
        ?>
    </div>
    <div class="row subscribe">
        <div class="">
            <form>
            <h5>Subscribe to our newsletter</h5>
            <p>Monthly digest of whats new and exciting from us.</p>
            <div class="subscribeBox">
                <label for="newsletter1" class="visually-hidden">Email address</label>
                <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                <button class="btn btn-primary mt-3" type="button">Subscribe</button>
            </div>
            </form>
        </div>
    </div>
    
    <!-- Fixed Icons -->
    <?php include("templates/fixed-icons.php"); ?>

    <!-- Footer Template-->
    <?php include("templates/footer.php"); ?>

    <!-- Javascript Template --> 
    <?php include("templates/script.php"); ?>

</body>
</html>