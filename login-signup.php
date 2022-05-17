<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(isLoggedIn()){
        header("Location: " . SITE_URL . "user-profile.php"); // Redirect to User Profile Page
    }

    $email = $password = $username = $signupEmail = $signupPassword = $phone = $address = $postalCode = "";

    if (isset($_POST["login"])) {
        if (isset($_POST["email"])) {
            $email = test_input($_POST["email"]);
        }
        if (isset($_POST["password"])) {
            $password = test_input($_POST["password"]);
        }

        if ($email == "" || $password == "") {
            alertReload("Please fill up all required fields.");
            exit();
        } else {
            # Check if email is valid
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                # Check if email exists in DB
                $userQuery = DB::query("SELECT * FROM users WHERE userEmail = %s", $email);
                # Count the number of users that exist with email input
                $userCount = DB::count();

                if ($userCount == 1) {
                    foreach($userQuery as $userResult) {
                        $userID = $userResult["userID"];
                        $userPassword = $userResult["userPassword"];
                    }

                    # Password Verification 
                    if (password_verify($password, $userPassword)) {
                        setCookies("userID", $userID);

                        header("Location:" . SITE_URL . "user-profile.php");
                        exit();
                    } else {
                        alertWindow("Password is incorrect");
                    }
                } else {
                    alertWindow("User does not exist");
                }
            } else {
                alertWindow("Email is incorrect");
            }
        }
    }

    if (isset($_POST["signup"])) {
        if (isset($_POST["username"])) {
            $username = test_input($_POST["username"]);
        }
        if (isset($_POST["signupEmail"])) {
            $signupEmail = test_input($_POST["signupEmail"]);
        }
        if (isset($_POST["signupPassword"])) {
            $signupPassword = test_input($_POST["signupPassword"]);
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

        if ($username !== "") {
            if (filter_var($signupEmail, FILTER_VALIDATE_EMAIL)) {
                if ($signupPassword !== "") {
                    if ($signupPassword == $confirmPassword) {
                        if (preg_match('/^[0-9]{8}+$/', $phone)) {
                            if ($address !== "") {
                                if (preg_match('/^[S0-9]{7}+$/', $postalCode)) {
                                    $fullAddress = $address . " " . $postalCode;

                                    $userQuery = DB::query("SELECT * FROM users WHERE userEmail = %s", $signupEmail);
                                    $userCount = DB::count();

                                    if ($userCount == 0) {
                                        $hashedPassword = password_hash($signupPassword, PASSWORD_DEFAULT);
                                    
                                        DB::startTransaction();
                                        DB::insert("users", [
                                            "userName" => $username,
                                            "userEmail" => $signupEmail,
                                            "userPassword" => $hashedPassword,
                                            "userPhoneNum" => $phone,
                                            "userAddress" => $fullAddress
                                        ]);
                                    
                                        $newUserID = DB::insertID();
                                        $isSuccess = DB::affectedRows();
                                    
                                        if ($isSuccess) {
                                            DB::commit();
                                            setCookies("userID", $newUserID);
                                    
                                            header("Location:" . SITE_URL . "user-profile.php");
                                            exit();
                                        } else {
                                            DB::rollback();
                                            alertWindow("An error has occured, please try again");
                                        }
                                    } else {
                                    alertWindow("User already exists. Please try to login");
                                    }
                                } else {
                                    alertWindow("Please enter a valid postal code e.g. s123456");
                                }
                            } else {
                                alertWindow("Please enter your address e.g. Block XXX AAA Road #01-01");
                            }        
                        } else {
                            alertWindow("Please enter a valid phone number e.g. 91234567");
                        }
                    } else {
                        alertWindow("Please re-enter the same password");
                    }
                } else {
                    alertWindow("Please enter your desired password");
                }
            } else {
                alertWindow("Please enter a valid email");
            }
        } else {
            alertWindow("Please indicate your desired username");
        }
    }

?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Login | Signup · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title --> 
    <div class="row">
        <div class="head">
            <h1>Member's Area</h1>
            <h4>Be a part of our community to unlock exclusive content!</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <!-- Login --> 
    <div class="LoginBox mt-5">
        <div class="main mx-auto">  	
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="login">
                <form method="POST">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                    <input type="password" name="password" placeholder="Password">
                    <button name="login" type="submit">Login</button>
                </form>
            </div>
            <div class="signup">
                <form method="POST">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="username" name="username" placeholder="User name" value="<?php echo $username; ?>">
                    <input type="email" name="signupEmail" placeholder="Email" value="<?php echo $signupEmail; ?>">
                    <input type="password" name="signupPassword" placeholder="Password">
                    <input type="password" name="confirmPassword" placeholder="Confirm Password">
                    <input type="text" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>">
                    <input type="text" name="address" placeholder="Address" value="<?php echo $address; ?>">
                    <input type="text" name="postalCode" placeholder="Postal Code" value="<?php echo $postalCode; ?>">
                    <button name="signup" type="submit">Sign up</button>
                </form>
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