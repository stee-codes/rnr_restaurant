<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "index.php"); 
    };

    session_start(); 

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_POST['addToCart'])) {
        $_SESSION['cart'][$_GET['id']] = array(
            "foodID" => $_GET["id"],
            "foodName" => $_POST["hidden_foodName"],
            "foodPrice" => $_POST["hidden_foodPrice"],
            "foodQuantity" => $_POST["foodQuantity"]
        );
    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        if(isset($_SESSION['cart'][$_GET['id']])) {
            unset($_SESSION['cart'][$_GET['id']]);
            alertWindow("Item removed");
        }
    }

    if(isset($_GET["action"])){
        if($_GET["action"] == "empty"){
            foreach($_SESSION["cart"] as $keys => $values){
                unset($_SESSION["cart"]);					
                alertRedirect("Cart cleared", SITE_URL . "order-cart.php");
            }
        }
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Your Cart · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Your Food Cart</h1>
            <h4>Look at all those wonderful items</h4>
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
                <th scope="col">Action</th>
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
                    <td><a class="text-decoration-none" href="order-cart.php?action=delete&id=<?php echo $values["foodID"]; ?>"><span class="text-danger"><ion-icon name="trash-outline"></ion-icon></span></a></td>  
                </tr>  
                <?php  
                    $total = $total + ($values["foodQuantity"] * $values["foodPrice"]);  
                    }  
                ?>  
                <tr>  
                    <td colspan="3" align="right">Total</td>  
                    <td class="fw-bold" align="left">$ <?php echo number_format($total, 2); ?></td>  
                    <td></td>  
                </tr>  
            <?php  
            } else {
            ?>
                <div class="container">
                    <h5 class="text-center my-5">Your cart is empty. Start ordering <a href="index.php">here</a>.</h5>        
                </div>
            <?php    
            } 
            ?>  
        </table>      
        <div class="mt-3 text-center">
            <a href="index.php" type="submit" name="addFood" class="btn btn-warning me-2 mt-2">Add More</a>
            <a href="order-cart.php?action=empty" class="btn btn-danger me-2 mt-2">Clear Cart</a>
            <a href="order-checkout.php"><button type="submit" name="checkOut" class="btn btn-success me-2 mt-2">Check Out</button></a>
            
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