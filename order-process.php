<?php
include("core/config.php");
include("core/db.php");
include("core/functions.php");

if(!isLoggedIn()){
    header("Location: " . SITE_URL . "index.php"); 
};

session_start(); 

$userID = $_COOKIE["userID"];

if (!empty($_GET["order"])) {
    if(isset($_SESSION["cart"])) {
        DB::startTransaction();
        foreach ($_SESSION["cart"] as $keys => $values) {
            DB::insert("foodorder", [
                "foodorderName" => $foodorderName = $values["foodName"],
                "foodorderNum" => $foodorderNum = $_GET["order"],
                "foodorderQuantity" => $foodorderQuantity = $values["foodQuantity"],
                "userID" => $userID, 
                "foodID" => $foodID = $values["foodID"]
            ]);
            unset($_SESSION["cart"]);
        }
        
        $isSuccess = DB::affectedRows();

        if ($isSuccess) {
            DB::commit();
            # Redirect admin back to Admin Panel
            header("Location: " . SITE_URL . "order-summary.php?foodOrderSuccess=1&order=" . $foodorderNum); 
            exit();
        } else {
            DB::rollback();
            alertWindow("An error has occurred. Please try again.");
        }
    }
} else {
    header("Location: " . SITE_URL . "index.php"); 
}

?>