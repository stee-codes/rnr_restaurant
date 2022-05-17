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

    #Check if there is a GET parameter of "id"
    if(!isset($_GET['id']) || $_GET['id'] == ""){
        #No GET parameter detected
        header('Location: ' . SITE_URL . "admin-panel.php");
    } else {
        #GET parameter has value
        #Delete the user
        DB::delete("food", "foodID = %i", $_GET['id']);
        #Redirect the user back to dashboard
        header('Location: ' . SITE_URL . "admin-panel.php");
    }
?>