<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    $userID = $_COOKIE["userID"];
    $userQuery = DB::query("SELECT * FROM users WHERE userID = %i", $userID);
    foreach ($userQuery as $userResult) {
        $userName = $userResult["userName"];
    }
    $orderQuery = DB::query("SELECT * FROM foodorder WHERE foodorderNum = %i", $_GET["order"]);
    foreach ($orderQuery as $orderResult) {
        $foodorderNum = $orderResult["foodorderNum"];
    }

?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Order Summary · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Order Summary</h1>
            <h4>We are done!</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <div class="row container-fluid">
        <div class="text-center my-5">
            <h3>Dear <?php echo name($userName)?>,</h3>
            <h3>Thank you for your confirmation, your order has been processed.</h3>
            <h3>Sit back and relax, the items will be sent to you soon!</h3>
            <h3>Your order number is: <?php echo $foodorderNum?></h3>
        </div>
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