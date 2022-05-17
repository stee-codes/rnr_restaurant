<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };


    if(!isset($_GET['id']) || $_GET['id'] == ""){
        #No GET parameter detected
        header('Location: index.php');
    } else {
        # Pull information from DB 
        $userQuery = DB::query("SELECT * FROM users WHERE userID = %i", $_GET['id']);
        foreach ($userQuery as $userResult) {
            $userName = $userResult["userName"];
            $userEmail = $userResult["userEmail"];
            $userPhone = $userResult["userPhoneNum"];
            $userAddress = $userResult["userAddress"];
            $userImage = $userResult["userImage"];
            $userPermission = $userResult["userPermission"];
        }
    }

    $userPermissionText = $userPermission == 1 ? "Admin" : "User";

    if ($userImage == "") {
        $userImage = "assets/img/default_profile_img.jpg";
    }

    if (isset($_POST["submitImage"])) {

        DB::startTransaction();

        $imageUpload = uploadImage("userImage");
        if ($imageUpload["uploadedFile"] == "") {
            alertWindow($imageUpload["returnMsg"]);
        } else {
            DB::update("users", [
                "userImage" => $imageUpload["uploadedFile"]
            ], "userID = %i", $_GET["id"]);
        }

        $isSuccess = DB::affectedRows();

        if ($isSuccess) {
            DB::commit();
            alertRedirect('Image successfully updated', SITE_URL . "update-user-profile.php?id=" . $_GET['id'] . "?updateUserSuccess=1");
            exit();
        } else {
            DB::rollback();
            alertWindow("An error has occurred. Please try again.");
        }
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Update Profile · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">User Profile</h1>
            <h4>Update your account</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>

        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5" width="150px" src="<?php echo $userImage?>">
                        <span class="font-weight-bold mt-2 mb-2"><?php echo $userName ?></span>
                        <span class="font-weight-bold mb-2"><?php echo $userPermissionText ?></span>
                        <span class="text-black-50 mb-2"><?php echo $userEmail ?></span>
                        <ion-icon name="image-outline" class="changeImage"></ion-icon>                     
                        <div class="imageUpload hide">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-2">Change Image:</label>
                                    <input type="file" class="form-control form-control-sm" name="userImage">
                                    <button type="submit" value="submit" name="submitImage" class="btn btn-primary btn-sm mt-2">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div style="display: none;" class="alert alert-danger" id="error" role="alert"></div>
                    <div style="display: none;" class="alert alert-success" id="success" role="alert"></div>
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <form id="uploadForm">
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Please enter your name" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Email Address</label>
                                    <input type="text" class="form-control" id="email" placeholder="name@example.com" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Password</label>
                                    <input type="text" class="form-control" id="password" placeholder="Password" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Confirm Password</label>
                                    <input type="text" class="form-control" id="confirmPassword" placeholder="Please re-enter your new password" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Please enter your phone number" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Block XXX AAA Road #01-01" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Postal Code</label>
                                    <input type="text" class="form-control" id="postalCode" placeholder="S123456" value="">
                                </div>
                                <?php if (isAdmin()) {echo '
                                <div>
                                    <p>Permission: </p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="userPermission" type="radio" id="userPermission" value="1" <?php if ($userPermission == "1") {echo "checked";}?>
                                        <label class="form-check-label" for="userPermission">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="userPermission" type="radio" id="userPermission" value="0" <?php if ($userPermission == "0") {echo "checked";}?>
                                        <label class="form-check-label" for="userPermission">User</label>
                                    </div>
                                </div>
                                ';}?>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" id="saveChanges" class="btn btn-primary me-2 mt-2">Save Changes</button>
                                <a class="btn btn-danger me-2 mt-2" href="user-profile.php"><?php 
                                if (isAdmin()) {echo "Own Profile";} else {echo ("Head Back");}?></a>
                                <?php if(isAdmin()){
                                    echo '<a class="btn btn-success me-2 mt-2" href="admin-panel.php">Admin Panel</a></div>';}
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Template-->
    <?php include("templates/footer.php"); ?>

    <!-- Javascript Template --> 
    <?php include("templates/script.php"); ?>

    <script>
    $(document).ready(function(){
        $("#uploadForm").submit(function(e){
            e.preventDefault(e);
        });

        $("#saveChanges").click(function(){
            let name = $("#name").val();
            let email = $("#email").val();
            let password = $("#password").val();
            let confirmPassword = $("#confirmPassword").val();
            let phone = $("#phone").val();
            let address = $("#address").val();
            let postalCode = $("#postalCode").val();
            let userPermission = $("#userPermission:checked").val();
            let id = <?php echo $_GET['id']; ?>;

            $.ajax({
                url: 'ajax-update-user.php', 
                method: 'POST',
                data:{
                    id: id,
                    name: name,
                    email: email,
                    password: password,
                    confirmPassword: confirmPassword,
                    phone: phone,
                    address: address,
                    postalCode: postalCode,
                    userPermission: userPermission
                },
                success:function(data){
                    if(data != "User updated successfully"){
                        $("#success").hide();
                        $("#error").text(data).show();
                    } else {
                        $("#error").hide();
                        $("#success").text(data).show();
                        $("#uploadForm")[0].reset();
                    }
                }
            });
        });
    });
    </script>    

</body>
</html>