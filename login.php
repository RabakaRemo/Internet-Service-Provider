<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    
    <!-- Links Start -->

    <?php require '_link_common.php'; ?>

    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="footer.css">
        <!-- Link End -->

</head>
<body>
    <?php
        $inval_mass = "";
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // connection the database
            require '_database_connect.php';
            
            // Get form inputs
            $userid = $_POST["userid"];
            $pss = $_POST["pass"];
            $user = $_POST["user"];
            
            // SQL to check login
            $login_sql = "SELECT * FROM `$user` WHERE `email` = '$userid' AND `password` = '$pss'";
            $login_check = mysqli_query($connect, $login_sql);
            $login_state = mysqli_num_rows($login_check);

            // If login is successful
            if ($login_state == 1){
                // Fetch the row
                $row = mysqli_fetch_assoc($login_check);
            
                // Retrieve the 'id' from the row
                $id = $row['id'];
                
                // Start the session and store 'id' and 'user'
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['user'] = $user;
                
                // Redirect based on user role
                if($user=="customer"){ header("location: dash_customer.php"); die();}
                else if($user=="admin"){ header("location: dash_admin.php"); die();}
                else if($user=="employee"){ header("location: dash_employee.php"); die();}
                else {$inval_mass = "Invalid User";}
            } else{
                // Invalid login
                $inval_mass = "Invalid User-name or Password";
            }
        }
    ?>

    


    <!-- Top Banner -->
     <!-- image -->
    <img src="images\banar\welcome_back.gif" class="d-block w-100 mb-5" alt="Welcome">
    <!-- Or -->
    <!-- <div class="container text-center p-5 top_banner">
        <h1 class="page-title p-3">
            Welcome Back
            <span class="span-top"></span>
            <span class="span-right"></span>
            <span class="span-bottom"></span>
            <span class="span-left"></span>
        </h1>
    </div> -->

    <!-- Login Box -->
    <div class="login-box mb-5">
        <?php
            // Display error message if login is invalid
            if($inval_mass != "") {echo '<p class="py-3">' . $inval_mass . '</p>';}
        ?>
        <!--  autocomplete="on" -->
        <form action="login.php" method="post">
            <h2>Login</h2>
            <div class="user-input">
                <input type="email" name="userid" required>
                <label>Email</label>
            </div>
            <div class="user-input">
                <input type="password" name="pass" required>
                <label>Password</label>
            </div>

            <!-- Forgot Password Link -->
            <div class="position-relative bg-light">
                <div class="position-absolute top-0 end-0">
                    <a href="forgot-pass.php">Forgot Password?</a><br>
                </div>
            </div>

            <!-- Choose User Role -->
            <label class="text-light fs-6">Choose Your Role</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="user" value="admin" id="user-admin">
                <label class="form-check-label text-light fs-7" for="user-admin">Admin</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="user" value="customer" id="user-customer" checked>
                <label class="form-check-label text-light fs-7" for="user-customer">Customer</label>
            </div> 
            <div class="form-check form-switch">
                <input class="form-check-input" type="radio" name="user" value="employee" id="user-employee">
                <label class="form-check-label text-light fs-7" for="user-employee">Employee</label>
            </div>

            <!-- Login Button -->
            <span class="login-span my-4">
                <span class="span-top"></span>
                <span class="span-right"></span>
                <span class="span-bottom"></span>
                <span class="span-left"></span>
                <input class="login-btn" type="submit" value="LOGIN">
            </span>

            <!-- Registration Link -->
            <div class="position-relative bg-light mt-5">
                <div class="position-absolute top-0 end-0 mt-4">
                    <a href="registration.php">Don't have an account? Register</a><br>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <?php include '_footer_common.php';?>
</body>
</html>
