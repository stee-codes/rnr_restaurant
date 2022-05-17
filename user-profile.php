<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };

    $userID = $_COOKIE["userID"];

    # Pull information from DB 
    $userQuery = DB::query("SELECT * FROM users WHERE userID = %i", $userID);
    foreach ($userQuery as $userResult) {
        $userID = $userResult["userID"];
        $userName = $userResult["userName"];
        $userEmail = $userResult["userEmail"];
        $userPhone = $userResult["userPhoneNum"];
        $userAddress = $userResult["userAddress"];
        $userImage = $userResult["userImage"];
        $userPermission = $userResult["userPermission"];
    }

    $userPermissionText = $userPermission == 1 ? "Admin" : "User";

    if ($userImage == "") {
        $userImage = "assets/img/default_profile_img.jpg";
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Your Profile · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">User Profile</h1>
            <h4>Hi <?php echo name($userName)?>, welcome back!</h4>
        </div>

        <!-- Carousel -->
        <?php include("templates/carousel.php") ?>

        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-end">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5 mb-3" width="150px" src="<?php echo $userImage?>">
                        <span class="font-weight-bold mb-2"><?php echo $userName ?></span>
                        <span class="font-weight-bold mb-2"><?php echo $userPermissionText ?></span>
                        <span class="text-black-50 mb-2"><?php echo $userEmail ?></span>
                    </div>
                </div>
                <div class="col-md-3 border-end">
                    <div class="profilePage mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 text-center mb-5">
                                    <h4>Your Profile</h4>
                                </div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $userName ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $userEmail ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $userPhone ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $userAddress ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <?php if(isAdmin()){
                                    echo '<div class="col-sm-12 mb-3">
                                    <a class="btn btn-outline-success w-100" href="admin-panel.php">Admin Panel</a>
                                </div>';}?>
                                <div class="col-sm-12 mb-3">
                                    <a class="btn btn-outline-warning w-100" href="index.php">Start Order</a>
                                </div>                                
                                <div class="col-sm-12 mb-3">
                                    <a class="btn btn-outline-primary w-100" href="<?php echo 'update-user-profile.php?id=' . $userID?>">Edit Profile</a>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <a class="btn btn-outline-danger w-100" href="logout.php">Sign Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 border-end">
                    <div class="mb-3 orderHistory">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-sm-12 mb-5">
                                    <h4 class="">Order History</h4>
                                </div>
                                <table class="table display table-hover">
                                    <thead>
                                        <th scope="col">Date</th>
                                        <th scope="col">Order Number</th>
                                        <th scope="col">Name</th> 
                                        <th scope="col">Quantity</th>                            
                                    </thead>
                                    <tbody>
                                        <?php
                                        $getOrderQuery = DB::query("SELECT * FROM foodorder INNER JOIN users ON foodorder.userID = users.userID WHERE foodorder.userID = %i", $userID);
                                        foreach ($getOrderQuery as $getOrderResult){
                                            echo '<tr>';
                                                echo '<td>' . $getOrderResult['foodorderDateTime'] . '</td>';
                                                echo '<td>' . $getOrderResult['foodorderNum'] . '</td>';
                                                echo '<td>' . $getOrderResult['foodorderName'] . '</td>';
                                                echo '<td>' . $getOrderResult['foodorderQuantity'] . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>    
            </div>
        </div>

        <!-- Footer Template-->
        <?php include("templates/footer.php"); ?>

        <!-- Javascript Template -->
        <?php include("templates/script.php"); ?>

</body>

</html>