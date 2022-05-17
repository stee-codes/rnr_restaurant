<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };

    if(!isAdmin()){
        header("Location: " . SITE_URL); // Redirect to Main Page
        exit();
    }

    if(!isset($_GET['id']) || $_GET['id'] == ""){
        #No GET parameter detected
        header('Location: index.php');
    } else {
        #GET parameter is detected
        $getFoodQuery = DB::query("SELECT * FROM food WHERE foodID = %i", $_GET['id']);
        foreach($getFoodQuery as $getFoodResult){
            $foodName = $getFoodResult["foodName"];
            $foodDescription = $getFoodResult["foodDescription"];
            $foodPrice = $getFoodResult["foodPrice"];
            $foodImage = $getFoodResult["foodImage"];
            $foodStatus = $getFoodResult["foodStatus"];
        }
    }

    if ($foodImage == "") {
        $foodImage = "assets/img/default_food_img.png";
    }

    if (isset($_POST["submitImage"])) {

        DB::startTransaction();

        $imageUpload = uploadImage("foodImage");
        if ($imageUpload["uploadedFile"] == "") {
            alertWindow($imageUpload["returnMsg"]);
        } else {
            DB::update("food", [
                "foodImage" => $imageUpload["uploadedFile"]
            ], "foodID = %i", $_GET["id"]);
        }

        $isSuccess = DB::affectedRows();

        if ($isSuccess) {
            DB::commit();
            alertRedirect('Image successfully updated', SITE_URL . "update-food-profile.php?id=" . $_GET['id'] . "?updateFoodSuccess=1");
            exit();
        } else {
            DB::rollback();
            alertWindow("An error has occurred. Please try again.");
        }
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Update Food Item · <?php echo SITE_NAME;?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Edit Food Item</h1>
            <h4>Update food items</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>

        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <img class="rounded-circle mt-5 mb-3" width="150px" src="<?php echo $foodImage?>">
                        <span class="font-weight-bold mt-2 mb-2"><?php echo $foodName ?></span>
                        <span class="text-muted mt-2 mb-2"><?php echo strtolower($foodDescription) ?></span>
                        <span class="text-black-50 mb-2"><?php echo $foodPrice ?></span>
                        <ion-icon name="image-outline" class="changeImage"></ion-icon>                     
                        <div class="imageUpload hide">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-2">Change Image:</label>
                                    <input type="file" class="form-control form-control-sm" name="foodImage">
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
                            <h4 class="text-right">Edit Food Items</h4>
                        </div>
                        <form id="uploadForm">
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Name</label>
                                    <input type="text" class="form-control" id="foodName" placeholder="Please enter your name" value="<?php echo $foodName?>">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Food Description</label>
                                    <input type="text" class="form-control" id="foodDescription" placeholder="Food Description" value="<?php echo $foodDescription?>">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="labels mb-1">Food Price</label>
                                    <input type="text" class="form-control" id="foodPrice" placeholder="Please enter the price of the item" value="<?php echo $foodPrice?>">
                                </div>
                                <div>
                                    <p>Status: </p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="foodStatus" type="radio" id="foodStatus" value="1" <?php if ($foodStatus == "1") {echo "checked";}?>>
                                        <label class="form-check-label" for="foodStatus">Available</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="foodStatus" type="radio" id="foodStatus" value="0" <?php if ($foodStatus == "0") {echo "checked";}?>>
                                        <label class="form-check-label" for="foodStatus">Sold Out</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" value="submit" id="saveChanges" class="btn btn-primary me-2 mt-2">Save Changes</button>
                                <a class="btn btn-outline-danger me-2 mt-2" href="admin-panel.php">Head Back</a>
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
            let foodName = $("#foodName").val();
            let foodDescription = $("#foodDescription").val();
            let foodPrice = $("#foodPrice").val();
            let foodStatus = $("#foodStatus:checked").val();
            let id = <?php echo $_GET['id']; ?>;

            $.ajax({
                url: 'ajax-update-food.php', 
                method: 'POST',
                data:{
                    id: id,
                    foodName: foodName,
                    foodDescription: foodDescription,
                    foodPrice: foodPrice,
                    foodStatus: foodStatus,
                },
                success:function(data){
                    if(data != "Food item updated successfully"){
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