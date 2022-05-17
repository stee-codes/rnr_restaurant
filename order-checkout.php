<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "index.php"); 
    };
    
    session_start();

    $userID = $_COOKIE["userID"];

    $userQuery = DB::query("SELECT * FROM users WHERE userID = %i", $userID);
    foreach ($userQuery as $userResult) {
        $userName = $userResult["userName"];
        $userEmail = $userResult["userEmail"];
        $userPhone = $userResult["userPhoneNum"];
        $userAddress = $userResult["userAddress"];
    }

?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Order Confirmation · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Order Confirmation</h1>
            <h4>1 last step before having our delicious food 😊</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <div class="row container-fluid">
        <table class="table display table-hover">
            <thead>
            <tr>
                <th scope="col">Food Item</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <?php   
                if(!empty($_SESSION["cart"])) {  
                    $total = 0;  
                    foreach($_SESSION["cart"] as $keys => $values) {  
                ?>  
                <tr>  
                    <td><?php echo $values["foodName"]; ?></td>  
                    <td><?php echo $values["foodQuantity"]; ?></td>  
                    <td>$ <?php echo $values["foodPrice"]; ?></td>  
                    <td>$ <?php echo number_format($values["foodQuantity"] * $values["foodPrice"], 2); ?></td>  
                </tr>  
                <?php  
                    $total = $total + ($values["foodQuantity"] * $values["foodPrice"]);  
                    }  
                ?>  
                <tr>  
                    <td colspan="3" align="right">Total</td>  
                    <td class="fw-bold" align="left">$ <?php echo number_format($total, 2); ?></td>   
                </tr>  
                <tr>
                <td colspan="3" align="right">Delivery</td>
                <td class="fw-bold" align="left">$0</td>  

   
                </tr>
                <tr>
                    <td colspan="3" align="right">GST & Service Charge</td>
                    <td class="fw-bold" align="left">$0</td>
                </tr>
                <tr>
                    <td colspan="3" align="right">Grand Total</td>
                    <td class="fw-bold text-danger" align="left">$<?php echo number_format($total, 2); ?></td>
                </tr>
            <?php  
            }
            ?> 
        </table>
        <hr>
        <!-- Delivery Details-->
        <div class="text-center mt-5">
            <h3>Delivery Address</h3>
            <hr class="my-3 w-75 mx-auto">
            <p>Name: <span class="fw-bold"><?php echo $userName?></span></p>
            <p>Email: <span class="fw-bold"><?php echo $userEmail?></span></p>
            <p>Phone: <span class="fw-bold"><?php echo $userPhone?></span></p>
            <p>Address: <span class="fw-bold"><?php echo $userAddress?></span></p>
        </div>
        <?php
            $randNumber1 = rand(1000,9999); 
            $randNumber2 = rand(1000,9999); 
            $randNumber3 = rand(1000,9999);
            $foodorderNum = $randNumber1.$randNumber2.$randNumber3;
        ?>
        <div class="mt-3 text-center">
            <a href="order-process.php?order=<?php echo $foodorderNum;?>"><button type="submit" name="confirmOrder" class="btn btn-info me-2 mt-2">Confirm Order</button></a>
            <a class="btn btn-danger me-2 mt-2" href="order-cart.php">Head Back</a>
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