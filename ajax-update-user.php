<?php

    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    if(!isLoggedIn()){
        header("Location: " . SITE_URL . "login-signup.php"); // Redirect to Login Page
    };

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
    if (isset($_POST["userPermission"])) {
        $permission = test_input($_POST["userPermission"]);
    }
    
    DB::startTransaction();

    if ($name !== "") {
        if ($email !== "") {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($password !== "") {
                    if ($password == $confirmPassword) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        if ($phone !== "") {
                            if (preg_match('/^[0-9]{8}+$/', $phone)) {
                                if ($address !== "") {
                                    if (preg_match('/^[S0-9]{7}+$/', $postalCode)) {
                                        $fullAddress = $address . " " . $postalCode;

                                        if (isAdmin()) {
                                            if ($permission == "") {
                                                DB::update("users", [
                                                    "userName" => $name,
                                                    "userEmail" => $email,
                                                    "userPassword" => $hashedPassword,
                                                    "userPhoneNum" => $phone,
                                                    "userAddress" => $fullAddress,
                                                ], "userID = %i", $_POST["id"]);
                                            } else {
                                                DB::update("users", [
                                                    "userName" => $name,
                                                    "userEmail" => $email,
                                                    "userPassword" => $hashedPassword,
                                                    "userPhoneNum" => $phone,
                                                    "userAddress" => $fullAddress,
                                                    "userPermission" => $permission
                                                ], "userID = %i", $_POST["id"]);
                                            }
                                        } else {
                                            DB::update("users", [
                                                "userName" => $name,
                                                "userEmail" => $email,
                                                "userPassword" => $hashedPassword,
                                                "userPhoneNum" => $phone,
                                                "userAddress" => $fullAddress,
                                            ], "userID = %i", $_POST["id"]);
                                        }

                                        $isSuccess = DB::affectedRows();

                                        if ($isSuccess) {
                                            DB::commit();
                                            echo "User updated successfully";
                                        } else {
                                            DB::rollback();
                                            echo "An error has occurred. Please try again. ";
                                        }
                                    } else {
                                        echo "Please enter a valid postal code. ";
                                    }
                                } else {
                                    echo "Please enter your desired address. ";
                                }
                            } else {
                                echo "Please enter a valid phone number. ";
                            }
                        } else {
                            echo "Please enter your contact number. ";
                        }
                    } else {
                        echo "Password does not match. ";
                    }
                } else {
                    echo "Please enter your desired password. ";
                }
            } else {
                echo "Please enter a valid email address. ";
            }
        } else {
            echo "Please enter your email address. ";
        }
    } else {
        echo "Please enter your name. ";
    }
?>