<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    
    <!-- Links Start -->
    <?php require '_link_common.php'; ?>
    
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="footer.css">
    
    <!-- Links End -->


</head>
<body>

<!-- Databas Connection -->
<?php
    $massage = "";
    $error = false;
    $hold_value = false;
    $invalid_nid = "";
    $invalid_phone = "";
    $invalid_email = "";
    $invalid_pass = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require '_database_connect.php';

        $hold_value = true;

        $name = $_POST["name"];
        $address = $_POST["address"];
        $nid = $_POST["nid"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        $pass = $_POST["pass"];
        $repass = $_POST["repass"];

        $registration_sql = "INSERT INTO `customer` (`email`, `phone`, `name`, `address`, `gender`, `password`, `nid`) VALUES ('$email', '$phone', '$name', '$address', '$gender', '$pass', '$nid')";
        $nid_get = "SELECT * FROM `customer` WHERE `nid` = '$nid'";
        $phone_get = "SELECT * FROM `customer` WHERE `phone` = '$phone'";
        $email_get = "SELECT * FROM `customer` WHERE `email` = '$email'";

        $nid_check = mysqli_query($connect, $nid_get);
        $nid_state = mysqli_num_rows($nid_check);
        if(strlen($nid)!=10){
            $invalid_nid = "Enter a valid NID number.";
            $error=false;
        }
        else if($nid_state>0){
            $invalid_nid = "The NID already exist.";
            $error=true;
        }

        $phone_check = mysqli_query($connect, $phone_get);
        $phone_state = mysqli_num_rows($phone_check);
        if(strlen($phone)!=11){
            $invalid_phone = "Enter a valid Phone number.";
            $error=true;
        }
        else if($phone_state>0){
            $invalid_phone = "The Phone number already exist.";
            $error=true;
        }

        $email_check = mysqli_query($connect, $email_get);
        $email_state = mysqli_num_rows($email_check);
        if($email_state>0){
            $invalid_email = "The Email already exist.";
            $error=true;
        }

        if($pass!=$repass){
            $invalid_pass = "Password Doesn't match.";
            $error=true;
        }

        if($error!=true){
            $hold_value = false;
            $state = mysqli_query($connect, $registration_sql);

            // Close the database connection
            mysqli_close($connect);

            //Redirect to the login
            header("location: login.php");
            die();
        }
        
    }
?>

    <!-- Top Banner -->
    <!-- image -->
    <img src="images\banar\welcome_to_the_famaly.gif" class="d-block w-100 mb-5" alt="Welcome">
    <!-- Or -->
    <!-- <div class="container text-center p-5">
        <h1 class="page-title p-3">
            Welcome To The Family
            <span class="span-top"></span>
            <span class="span-right"></span>
            <span class="span-bottom"></span>
            <span class="span-left"></span>
        </h1>
    </div> -->

    <!-- registration Box -->
    <div class="registration-box mb-5">
        <form action="registration.php" method="post">
            <h2>Registration</h2>
            <div class="user-input">
                <input type="text" id="full_name" name="name" <?php if ($hold_value == true) { echo 'value="' . $name . '"'; } ?> required>
                <label>Full Name</label>
            </div>

            <div class="user-input">
                <input type="text" id="address" name="address" <?php if ($hold_value == true) { echo 'value="' . $address . '"'; } ?> required>
                <label>Presrnt Address</label>
            </div>

            <div class="user-input">
            <input type="number" id="nid" name="nid" <?php if ($hold_value == true) { echo 'value="' . $nid . '"'; } ?> required>
                <label>NID Number</label>
            </div>
            <?php
                if ($invalid_nid != "") {
                    echo '<span class="text-danger input-error">' . $invalid_nid . '</span>';
                }
            ?>


            <div class="user-input">
            <input type="email" id="email" name="email"  <?php if ($hold_value == true) { echo 'value="' . $email . '"'; } ?> required>
                <label>E-mail <Address></Address></label>
            </div>
            <?php
                if ($invalid_email != "") {
                    echo '<span class="text-danger input-error">' . $invalid_email . '</span>';
                }
            ?>

            <div class="user-input">
            <input type="number" id="phone" name="phone" <?php if ($hold_value == true) { echo 'value="' . $phone . '"'; } ?> required>
                <label>Phone Number</label>
            </div>
            <?php
                if ($invalid_phone != "") {
                    echo '<span class="text-danger input-error">' . $invalid_phone . '</span>';
                }
            ?>

            <label class="text-light fs-6">Gender</label><br>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input active" type="radio" name="gender" value="male" id="gender-male">
                <label class="form-check-label text-light fs-7" for="male">Male</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="female" id="gender-female">
                <label class="form-check-label text-light fs-7" for="Female">Female</label>
            </div>
            <div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="other" id="gender-other" checked>
                <label class="form-check-label text-light fs-7" for="Female">Other</label>
            </div>


            <div class="user-input mt-3">
                <input type="password" id="pass" name="pass" required>
                <label>Password</label>
            </div>
            <div class="user-input">
                <input type="password" id="repass" name="repass" required>
                <label>Comfirm Password</label>
            </div>
            <?php
                if ($invalid_pass != "") {
                    echo '<span class="text-danger input-error">' . $invalid_pass . '</span>';
                }
            ?>

            <span class="registration-span my-4">
                <span class="span-top"></span>
                <span class="span-right"></span>
                <span class="span-bottom"></span>
                <span class="span-left"></span>
                <input class="registration-btn" type="submit" value="REGISTER">
            </span>

            <div class="position-relative bg-light mt-5">
                <div class="position-absolute top-0 end-0 mt-4">
                    <a href="login.php">Already have account? Login</a><br>
                </div>
            </div>
        </form>
    </div>

<!-- Footer -->
<?php include '_footer_common.php';?>
</body>
</html>