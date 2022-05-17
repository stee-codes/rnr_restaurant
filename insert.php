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

    $name = $email = $password = $confirmPassword = $phone = $address = $postalCode = $profileImg = $permission = $foodName = $foodDescription = $foodPrice = $foodImage = "";

    if (isset($_POST["addUser"])) {
        if (isset($_POST["name"])) {
            $name = test_input($_POST["name"]);
        }
        if (isset($_POST["email"])) {
            $email = test_input($_POST["email"]);
        }
        if (isset($_POST["password"])) {
            $password = test_input($_POST["password"]);
        }
        if (isset($_POST["confirmPassword"])) {
            $confirmPassword = test_input($_POST["confirmPassword"]);
        }
        if (isset($_POST["phone"])) {
            $phone = test_input($_POST["phone"]);
        }
        if (isset($_POST["address"])) {
            $address = test_input($_POST["address"]);
        }
        if (isset($_POST["postalCode"])) {
            $postalCode = test_input($_POST["postalCode"]);
        }
        if (isset($_POST["permission"])) {
            $permission = test_input($_POST["permission"]);
        }

        if($name == "" || $email == "" || $password == "" || $phone == "" || $address == "" || $postalCode == "" || $permission == "") {
            alertWindow("Please input all required fields");
        } else {
            if (preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($password == $confirmPassword) {
                        if (preg_match('/^[0-9]{8}+$/', $phone)) {
                            if ($address !== "") {
                                if (preg_match('/^[S0-9]{7}+$/', $postalCode)) {
                                    $fullAddress = $address . " " . $postalCode;
                                    
                                    $userQuery = DB::query("SELECT * FROM users WHERE userEmail = %s", $email);
                                    $userCount = DB::count();

                                    # If user does not exist 
                                    if ($userCount == 0) {
                                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                                        DB::startTransaction();

                                        # If no image selected 
                                        if ($_FILES['profileImg']['error'] == 4) {
                                            DB::insert("users", [
                                                "userName" => $name,
                                                "userEmail" => $email,
                                                "userPassword" => $hashedPassword,
                                                "userPhoneNum" => $phone, 
                                                "userAddress" => $fullAddress,
                                                "userPermission" => $permission
                                            ]);
                                        } else {
                                            # If image selected 
                                            $imageUpload = uploadImage("profileImg");
                                            # If image is invalid
                                            if ($imageUpload["uploadedFile"] == "") {
                                                alertWindow($imageUpload["returnMsg"]);
                                            } else {
                                                # If image is accepted 
                                                DB::insert("users", [
                                                    "userName" => $name,
                                                    "userEmail" => $email,
                                                    "userPassword" => $hashedPassword,
                                                    "userPhoneNum" => $phone, 
                                                    "userAddress" => $fullAddress,
                                                    "userImage" => $imageUpload["uploadedFile"],
                                                    "userPermission" => $permission
                                                ]);
                                            }
                                        } 

                                        $isSuccess = DB::affectedRows();

                                        if ($isSuccess) {
                                            DB::commit();
                                            # Redirect admin back to Admin Panel
                                            header("Location: " . SITE_URL . "admin-panel.php" . "?insertUserSuccess=1"); 
                                            exit();
                                        } else {
                                            DB::rollback();
                                            alertWindow("An error has occurred. Please try again.");
                                        }

                                    } else {
                                        # If user exists, redirect to Login Page
                                        alertRedirect("The user already exists. Please proceed to login.", SITE_URL . "login.php");
                                        exit();
                                    }
                                    
                                } else {
                                    alertWindow("Please enter a valid postal code");
                                }
                            } else {
                                alertWindow("Please enter the user's address");
                            }
                        } else {
                            alertWindow("Please enter a valid phone number");
                        }        
                    } else {
                        alertWindow("Please re-enter your password");
                    }
                } else {
                    alertWindow("Please enter a valid email");
                }
            } else {
                alertWindow("Please enter a valid name");
            }
        }
    }


    if (isset($_POST["addFood"])) {
        if (isset($_POST["foodName"])) {
            $foodName = test_input($_POST["foodName"]);
        }
        if (isset($_POST["foodDescription"])) {
            $foodDescription = test_input($_POST["foodDescription"]);
        }
        if (isset($_POST["foodPrice"])) {
            $foodPrice = test_input($_POST["foodPrice"]);
        }

        if ($foodName == "" || $foodDescription == "" || $foodPrice == "") {
            alertWindow("Please ensure all fields are filled up");
        } else {
            if ($foodName !== "") {
                if ($foodDescription !== "") {
                    if ($foodPrice !== "") {
                        $foodQuery = DB::query("SELECT * FROM food WHERE foodName = %s", $foodName);
                        $foodCount = DB::count();

                        if ($foodCount == 0) {

                            DB::startTransaction();

                            if ($_FILES['foodImage']['error'] == 4) {
                                DB::insert("food", [
                                    "foodName" => $foodName,
                                    "foodDescription" => $foodDescription,
                                    "foodPrice" => $foodPrice
                                ]);
                            } else {
                                $imageUpload = uploadImage("foodImage");
                                if ($imageUpload["uploadedFile"] == "") {
                                    alertWindow($imageUpload["returnMsg"]);
                                } else {
                                    DB::insert("food", [
                                        "foodName" => $foodName,
                                        "foodDescription" => $foodDescription,
                                        "foodPrice" => $foodPrice,
                                        "foodImage" => $imageUpload["uploadedFile"]
                                    ]);
                                }
                            }

                            $isSuccess = DB::affectedRows();

                            if ($isSuccess) {
                                DB::commit();
                                header("Location: " . SITE_URL . "admin-panel.php" . "?insertFoodSuccess=1");
                                exit();
                            } else {
                                DB::rollback();
                                alertWindow("An error has occurred. Please try again.");
                            }
                        } else {
                            alertWindow("Food item already exists, please try again");
                        }
                    } else {
                        alertWindow("Please enter the price of the food item");
                    }
                } else {
                    alertWindow("Please enter the description of the food item");
                }
            } else {
                alertWindow("Please enter the name of the food item");
            }
        }
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Insert · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Insert Data</h1>
            <h4>The more the merrier!</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <!-- Insert Users Data -->
    <div class="row">
        <div class="col-md-6 border-end">
            <h4 class="text-center">Add New User</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 px-5">
                        <label for="name" class="labels mb-1">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Please enter your name" value="<?php echo $name?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="email" class="labels mb-1">Email Address</label>
                        <input type="text" class="form-control" name="email" placeholder="name@example.com" value="<?php echo $email?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="password" class="labels mb-1">Password</label>
                        <input type="text" class="form-control" name="password" placeholder="Password" value="">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="confirmPassword" class="labels mb-1">Confirm Password</label>
                        <input type="text" class="form-control" name="confirmPassword" placeholder="Please re-enter your new password" value="">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="phone" class="labels mb-1">Phone Number</label>
                        <input type="text" class="form-control" name="phone" placeholder="Please enter your phone number" value="<?php echo $phone?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="address" class="labels mb-1">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Block XXX AAA Road #01-01" value="<?php echo $address?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="postalCode" class="labels mb-1">Postal Code</label>
                        <input type="text" class="form-control" name="postalCode" placeholder="S123456" value="<?php echo $postalCode?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="profileImg" class="labels mb-1">Profile Picture</label>
                        <input type="file" class="form-control" name="profileImg">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                    <label for="Permission" class="form-label mb-1">Permission</label>
                        <select class="form-select" name="permission" id="Permission">
                            <option value="" selected>Please select a permission</option>    
                            <option value="0" <?php if ($permission ==  0) echo "selected" ?>>User</option>
                            <option value="1" <?php if ($permission == 1) echo "selected" ?>>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" name="addUser" class="btn btn-warning me-2 mt-2">Add User</button>
                    <a class="btn btn-outline-danger me-2 mt-2" href="admin-panel.php">Head Back</a>
                </div>
            </form>
        </div>

        <!-- Insert Food Data -->
        <div class="col-md-6">
            <h4 class="text-center">Add New Food Item</h4>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mt-3">
                    <div class="col-md-12 mb-3 px-5">
                        <label for="foodName" class="labels mb-1">Name</label>
                        <input type="text" class="form-control" name="foodName" placeholder="Please enter the name of the item" value="<?php echo $foodName?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="foodDescription" class="labels mb-1">Description</label>
                        <input type="text" class="form-control" name="foodDescription" placeholder="Please enter the description" value="<?php echo $foodDescription?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="foodPrice" class="labels mb-1">Price</label>
                        <input type="text" class="form-control" name="foodPrice" placeholder="X.XX" value="<?php echo $foodPrice?>">
                    </div>
                    <div class="col-md-12 mb-3 px-5">
                        <label for="foodImage" class="labels mb-1">Image</label>
                        <input type="file" class="form-control" name="foodImage">
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" name="addFood" class="btn btn-warning me-2 mt-2">Add Item</button>
                    <a class="btn btn-outline-danger me-2 mt-2" href="admin-panel.php">Head Back</a>
                </div>
            </form>
        </div>
        
    <!-- Footer Template-->
    <?php include("templates/footer.php"); ?>

    <!-- Javascript Template --> 
    <?php include("templates/script.php"); ?>

</body>
</html>