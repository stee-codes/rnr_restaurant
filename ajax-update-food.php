<?php
    include('core/config.php');
    include('core/db.php');
    include('core/functions.php');
    
    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };

    if(!isAdmin()){
        header("Location: " . SITE_URL); // Redirect to Main Page
    }

    $foodName = $_POST["foodName"];
    $foodDescription = $_POST["foodDescription"];
    $foodPrice = $_POST["foodPrice"];
    $foodStatus = $_POST["foodStatus"];
    $id = $_POST["id"];

    if (isset($_POST["foodName"])) {
        $foodName = test_input($_POST["foodName"]);
    }
    if (isset($_POST["foodDescription"])) {
        $foodDescription = test_input($_POST["foodDescription"]);
    }
    if (isset($_POST["foodPrice"])) {
        $foodPrice = test_input($_POST["foodPrice"]);
    }
    if (isset($_POST["foodStatus"])) {
        $foodStatus = test_input($_POST["foodStatus"]);
    }
    
    if ($foodName == "" || $foodPrice == "") {
            echo "Please ensure all fields are filled up. ";
    } else {
        DB::startTransaction();

        if ($foodDescription == "") {
            DB::update("food", [
                "foodName" => $foodName,
                "foodPrice" => $foodPrice,
                "foodStatus" => $foodStatus
            ], "foodID = %i", $_POST["id"]);
        } else {
            DB::update("food", [
                "foodName" => $foodName,
                "foodDescription" => $foodDescription,
                "foodPrice" => $foodPrice,
                "foodStatus" => $foodStatus,
            ], "foodID = %i", $_POST["id"]);
        }
        
        $isSuccess = DB::affectedRows();

        if ($isSuccess) {
            DB::commit();
            echo "Food item updated successfully";
        } else {
            DB::rollback();
            echo "An error has occurred. Please try again";
        }
    }
?>