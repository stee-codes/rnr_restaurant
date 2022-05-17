<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    } else {
        unsetCookies("userID");

        header("Location:" . SITE_URL); # redirect user to dashboard
        exit();
    }
?>