<?php 
    function alertReload($message){
        echo "<script language='Javascript'>window.alert('$message');window.location=window.location.href;</script>";
    }

    function alertWindow($message){
        echo "<script language='Javascript'>window.alert('" . $message . "');</script>";
    }

    function alertRedirect($message, $redirectURL){
        echo "<script language='JavaScript'>window.alert('$message');window.location='$redirectURL'</script>";
    }

    function isAdmin(){
        if(isset($_COOKIE["userID"])){
            $userPermQuery = DB::query("SELECT * FROM users WHERE userID = %i", $_COOKIE["userID"]);
            foreach($userPermQuery as $userPermResult){
                $getUserPerm = $userPermResult["userPermission"];
            }
            if($getUserPerm == 1){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function isLoggedIn(){
        if(isset($_COOKIE['userID']) && isset($_COOKIE['isLoggedIn'])){
          $userQuery = DB::query("SELECT * FROM users WHERE userID=%i", $_COOKIE['userID']);
          $userCount = DB::count();
          if($userCount == 1){
              return true; //is logged in
          } else {
              return false; //is  NOT logged in
          }
        } else {
            return false; //is  NOT logged in
        }
    }
    
    function prepareDBVariables($controlName, $isAllLowercase = false) {
        $var = "";
        if(isset($_POST[$controlName]) && $_POST[$controlName] != ""){
            $var = trim($_POST[$controlName]);
            $var = stripslashes($_POST[$controlName]);
            $var = htmlspecialchars($_POST[$controlName]);
        }
        if($isAllLowercase){
            $var = strtolower($var);
        }
        return $var;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strtoupper($data);
        return $data;
    }

    function setCookies($name, $value) {
        setcookie($name, $value, time() + (86400 * 30)); #86400 = 1 day * 30 = 30 days
        setcookie("isLoggedIn", true, time() + (86400 * 30)); #86400 = 1 day * 30 = 30 days
    }

    function unsetCookies($name) {
        setcookie($name, "", time() - 3600); # deletes cookie 
        setcookie("isLoggedIn", "", time() - 3600); # deletes cookie 
    }

    function uploadImage($name){
        $currentDirectory = getcwd() . "/";
        $uploadDirectory = "assets/img/";
    
        $fileExtensionsAllowed = ['jpg', 'jpeg', 'jpe', 'jif', 'jfif', 'jfi', 'png', 'webp', 'bmp', 'dib', 'heif', 'heic', 'svg', 'svgz']; // These will be the only file extensions allowed 
    
        $fileName = $_FILES[$name]['name'];
        $fileSize = $_FILES[$name]['size'];
        $fileTmpName  = $_FILES[$name]['tmp_name'];
        $fileType = $_FILES[$name]['type'];
    
        // Extracting file extension
        $fileExtension = explode('.', $fileName);
        $fileExtension = end($fileExtension);
        $fileExtension = strtolower($fileExtension);
    
        $encryptedFileName = md5(basename($fileName, "." . $fileExtension) . rand()) . "." . $fileExtension;
    
        $uploadPath = $currentDirectory . $uploadDirectory . $encryptedFileName;
    
        if (!in_array($fileExtension, $fileExtensionsAllowed)) {
            $returnMsg = "This file extension is not allowed. Please upload a valid image file";
        }
    
        if ($fileSize > 10000000) {
            $returnMsg = "File exceeds maximum size (10MB)";
        }
    
        if ($returnMsg == "") {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
    
            if ($didUpload) {
                $returnMsg = "The file " . htmlspecialchars(basename($fileName)) . " has been uploaded";
            } else {
                $returnMsg = "An error occurred. Please contact the administrator.";
            }
        } else {
            $didUpload = false;
        }
    
        if($didUpload == true){
            $uploadedFile = $uploadDirectory . $encryptedFileName;
        } else {
            $uploadedFile = "";
        }
    
        return array("uploadedFile" => $uploadedFile, "returnMsg" => $returnMsg);
    }

    function name($value) {
        $newValue = ucfirst(strtolower($value));
        return $newValue;
    }
?>