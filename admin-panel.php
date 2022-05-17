<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };

    if(!isAdmin()){
        header("Location: " . SITE_URL); // Redirect to Main Page
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Admin Panel · <?php echo SITE_NAME?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Admin Panel</h1>
            <h4>Special access granted *winks*</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <h3 class="mt-3 mb-3 text-center">USER <a href="insert.php"><ion-icon class="insert" name="add-outline"></ion-icon></a></h3>
    <div class="row container-fluid col-sm-12">
        <table class="table display" id="myUserTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Profile Image</th>
                    <th scope="col">Email</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getAllUserQuery = DB::query("SELECT * FROM users");
                foreach($getAllUserQuery as $getAllUserResult){
                    echo '<tr>';
                        echo '<td>' . $getAllUserResult['userID'] . '</td>';
                        if ($getAllUserResult["userImage"] == "") {
                            echo "<td>Null</td>";
                        } else {
                            echo '<td><img src="' . $getAllUserResult['userImage'] . '" width="50"></td>';
                        }
                        echo '<td>' . $getAllUserResult['userEmail'] . '</td>';
                        if($getAllUserResult['userPermission'] == 1){
                            echo '<td>Admin</td>';
                        } else if($getAllUserResult['userPermission'] == 0) {
                            echo '<td>User</td>';
                        } else {
                            echo '<td>Invalid Permission</td>';
                        }
                        echo '<td>
                            <a style="margin-right: 5px;" href="update-user-profile.php?id=' . $getAllUserResult['userID'] . '"><span title="Edit"><ion-icon name="create-outline"></ion-icon></span></a>
                            <a onclick="return confirm(\'Are you sure you want to delete this user?\')" href="delete-user.php?id=' . $getAllUserResult['userID'] . '"><span title="Delete"><ion-icon name="trash-outline"></ion-icon></span></a>
                        </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <h3 class="mt-3 mb-3 text-center">FOOD <a href="insert.php"><ion-icon class="insert" name="add-outline"></ion-icon></a></h3>
    <div class="row container-fluid col-sm-12">
        <table class="table display" id="myFoodTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getAllUserQuery = DB::query("SELECT * FROM food");
                foreach($getAllUserQuery as $getAllUserResult){
                    echo '<tr>';
                        echo '<td>' . $getAllUserResult['foodID'] . '</td>';
                        
                        if ($getAllUserResult["foodImage"] == "") {
                            echo "<td>Null</td>";
                        } else {
                            echo '<td><img src="' . $getAllUserResult['foodImage'] . '" width="50"></td>';
                        }
                        echo '<td>' . $getAllUserResult['foodName'] . '</td>';
                        echo '<td>' . $getAllUserResult['foodPrice'] . '</td>';
                        if($getAllUserResult['foodStatus'] == 1){
                            echo '<td>Available</td>';
                        } else if($getAllUserResult['foodStatus'] == 0) {
                            echo '<td>Sold out</td>';
                        } else {
                            echo '<td>Invalid Permission</td>';
                        }
                        echo '<td>
                            <a style="margin-right: 5px;" href="update-food-profile.php?id=' . $getAllUserResult['foodID'] . '"><span title="Edit"><ion-icon name="create-outline"></ion-icon></span></a>
                            <a onclick="return confirm(\'Are you sure you want to delete this food item?\')" href="delete-food.php?id=' . $getAllUserResult['foodID'] . '"><span title="Delete"><ion-icon name="trash-outline"></ion-icon></span></a>
                        </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3 text-center">
        <a class="btn btn-outline-danger" href="user-profile.php">Head Back</a>
    </div>

    <!-- Footer Template-->
    <?php include("templates/footer.php"); ?>

    <!-- Javascript Template --> 
    <?php include("templates/script.php"); ?>

</body>
</html>