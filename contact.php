<?php
    include("core/config.php");
    include("core/db.php");
    include("core/functions.php");

    $name = $inputEmail = $phone = $website = $age = $modeOfContact = $comments ="";

    # If form is submitted
    if (isset($_POST["submit"])) {

        if (isset($_POST["name"])) {
            $name = test_input($_POST["name"]);
        }
        
        if (isset($_POST["inputEmail"])) {
            $inputEmail = test_input($_POST["inputEmail"]);
        }
        
        if (isset($_POST["phone"])) {
            $phone = test_input($_POST["phone"]);
        }

        if (isset($_POST["age"])) {
            $age = test_input($_POST["age"]);
        }
        
        if (isset($_POST["modeOfContact"])) {
            $modeOfContact = test_input($_POST["modeOfContact"]);
        }
        
        if (isset($_POST["comment"])) {
            $comment = test_input($_POST["comment"]);
        }        

        if ($name == "" || $inputEmail == "" || $phone == "" || $modeOfContact == "") {
            alertWindow("Form is incomplete, please fill up the required fields");
        } else {     
            if (preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                if (filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
                    if (preg_match('/^[0-9]{8}+$/', $phone)) {
                        if ($comment !== "" || $comment == "") {
                            echo "
                            <div class='overlay'>
                                <div class='confirmation'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <p class='modal-title'>Please ensure your details are correct</p>
                                                <a href='http://localhost:8888/rnr_restaurant/contact.php'><button type='button' class='btn-close' data-bs-dismiss='overlay' aria-label='Close'></button></a>
                                            </div>
                                            <div class='modal-body'>
                                                <p>Name: $name </p>
                                                <p>Email Address: $inputEmail </p>
                                                <p>Phone: $phone </p>
                                                <p>Preferred Mode of Contact: $modeOfContact </p>
                                                <p>Comments: $comment </p>
                                            </div>
                                            <div class='modal-footer'>
                                            <a href='http://localhost:8888/rnr_restaurant/contact.php'><button type='button' class='btn btn-secondary' data-bs-dismiss='overlay'>No, i need to make changes</button></a>
                                                <a href='http://localhost:8888/rnr_restaurant/contact.php?ContactFormSubmitted=1'><button type='button' class='btn btn-primary'>Yes its correct!</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        } else {
                            alertReload("An error has occured. Please try again");
                        }
                    } else {
                        alertWindow ("Please enter a valid phone number");
                    }
                } else {
                    alertWindow ("Invalid email");
                }
            } else {
                alertWindow ("Only letters and white space allowed");    
            }   
        }
    }
?>

<!-- Header Template -->
<?php include("templates/header.php") ?>

<title>Contact Us · <?php echo SITE_NAME?></title>

<!-- Stylesheet Template -->
<?php include("templates/styles.php") ?>

<body>
    <!-- Navbar Template -->
    <?php include("templates/navbar.php") ?>

    <!-- Title -->
    <div class="row">
        <div class="head">
            <h1 class="mb-3">Contact Us</h1>
            <h4>We'd love to hear from you!</h4>
        </div>
        
        <!-- Carousel --> 
        <?php include("templates/carousel.php")?>
    </div>

    <!-- Contact Us Form -->
    <div class="container mb-5">
        <div class="contactForm mx-auto mt-5">
            <h4 class="mb-3">Please let us know if there are any room for improvements.</h4>
            <hr class="my-3">
            <p>Kindly fill up the fields marked with <span class="isRequired">*</span>.</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="inputName" class="form-label"><span class="isRequired">*</span> Name :</label>
                    <input type="inputName" class="form-control" name="name" placeholder="Please enter your name" id="inputName" value="<?php echo $name?>">
                </div>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label"><span class="isRequired">*</span> Email address :</label>
                    <input type="email" class="form-control" name="inputEmail" placeholder="name@example.com" id="inputEmail" value="<?php echo $inputEmail?>">
                </div>
                <div class="mb-3">
                    <label for="inputNum" class="form-label"><span class="isRequired">*</span> Phone :</label>
                    <input type="text" class="form-control" name="phone" placeholder="9123 4567" id="phoneNum" value="<?php echo $phone?>">
                </div>
                <div>
                    <label for="inputModeOfContact" class="form-label me-1"><span class="isRequired">*</span> Preferred Mode of Contact : </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="modeOfContact" id="mobile" value="mobile">
                        <label class="form-check-label" for="inlineRadio1">Mobile</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="modeOfContact" id="contactEmail" value="email">
                        <label class="form-check-label" for="inlineRadio2">Email</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label" >Comments :</label>
                    <textarea class="form-control" rows="2" name="comment" placeholder="Please enter a message" value="<?php echo $comment?>"></textarea>
                </div>    
                <button type="submit" name="submit" class="btn w-100 btn-outline-dark" id="submitContactForm">Submit</button>
            </form>    
        </div>
    </div>

    <!-- Address --> 
    <div class="container address">
        <h1>Locate Us</h1>
        <hr class="my-3">
        <h3>Rest & Relax Restaurant</h3>
        <h5>123 Jalan Relac</h5>
        <h5>#01-01</h5>
        <h5>Singapore 123456</h5>
        <h5><a href="tel: +65 6123 4567">+65 6123 4567</a></h5>
    </div>

    <!-- Fixed Icons -->
    <?php include("templates/fixed-icons.php"); ?>

    <!-- Footer Template-->
    <?php include("templates/footer.php"); ?>

    <!-- Javascript Template --> 
    <?php include("templates/script.php"); ?>

</body>
</html>