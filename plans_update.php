<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Update</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navbar.css">
    <!-- Link End -->

</head>
<body>
    <?php
        // Login check
        require '_logincheck_admin.php';

        //Gloval Variables
        $plan_type = $plan_id = "";
        $plan_name = $plan_speed = $plan_price = $plan_realip = "No Data Found";
        $error = "";

        //Taking Seasion Data.
        if(isset($_SESSION['plan_type']) && isset($_SESSION['plan_id_update'])){
            //Taking Seasion data
            $plan_type = $_SESSION['plan_type'];
            $plan_id = $_SESSION['plan_id_update'];
        }else {
            //Rederect to plan page
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        }

        //Setting Page type and Name
        $page_type = "plans";
        $page_name = "";
        if($plan_type == "residential_plans"){
            $page_name = "Update Residential Plan";
        } else if ($plan_type == "organizational_plans"){
            $page_name = "Update Organizational Plan";
        }

        // Navbar
        require '_nav_admin.php';

        // connect to the database
        require '_database_connect.php';

        // Getting Privious Data Form Database
        $get_plan_data_sql = "SELECT * FROM `{$plan_type}` WHERE `id` = '{$plan_id}'";
        $get_plan_data = mysqli_query($connect, $get_plan_data_sql);
        if(!$get_plan_data){
            //Rederect to the Admin Home
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        }
        $get_result = mysqli_num_rows($get_plan_data);
        if($get_result==1){
            // Getting row data
            $get_data = mysqli_fetch_assoc($get_plan_data);

            //Storing Data
            $plan_name = $get_data['name'];
            $plan_speed = $get_data['speed'];
            $plan_price = $get_data['price'];
            $plan_realip = $get_data['realip'];
        }
        // Close the database connection
        mysqli_close($connect);


        // Adding plan to the database
        if(isset($_POST['plan_update'])) {
            // connect to the database
            require '_database_connect.php';

            // storing plan values
            $name = $_POST['plan_name'];
            $speed = $_POST['plan_speed'];
            $price = $_POST['plan_price'];
            $realip = $_POST['plan_realip'];

            // SQL
            $update_plan_sql = "UPDATE `{$plan_type}` SET `name` = '$name', `speed` = '$speed', `price` = '$price', `realip` = '$realip' WHERE `{$plan_type}`.`id` = '{$plan_id}';";

            // Insert Data Into Database
            $update_plan = mysqli_query($connect, $update_plan_sql);

            if($update_plan) {
                // Success, redirect

                // Close the database connection
                mysqli_close($connect);

                echo "<script> window.location.href='plans_admin.php';</script>";
                die();
            } else {
                $error = "Failed To Create Plan! Please Try Again.";
            }

            // Close the database connection
            mysqli_close($connect);
        }
    ?>

    <!-- Add Plan form --> 
    <div class="container rounded bg-black my-5 p-4 text-light">
        <h3 class="border p-2 text-center">
            Update The Detail Of The <?php if($plan_type=="residential_plans"){echo 'Residential';} else if ($plan_type == "organizational_plans"){echo 'Organizational';}?> Plan
        </h3>
        <form action="plans_update.php" method="post">
            <div class="mb-3">
                <label for="plan_name" class="form-label">Plan Name</label>
                <input type="text" name="plan_name" class="form-control" id="plan_name" <?php echo 'value="'.$plan_name.'"'?> required>
            </div>
            <div class="mb-3">
                <label for="plan_speed" class="form-label">Speed</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="plan_speed" name="plan_speed" <?php echo 'value="'.$plan_speed.'"'?> required>
                    <span class="input-group-text">Mbps</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="plan_price" class="form-label">Price</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="plan_price" name="plan_price" <?php echo 'value="'.$plan_price.'"'?> required>
                    <span class="input-group-text">TK/Month</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="plan_realip" class="form-label">Real-Ip (Yes/No)</label>
                <input type="text" name="plan_realip" class="form-control" id="plan_realip" <?php echo 'value="'.$plan_realip.'"'?> required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-success" name="plan_update">
                    <i class='fa-solid fa-up-down'></i> Update
                </button>
                <a href="plans_admin.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i> Cancel</a>
            </div>
        </form>
        <h5 class="text-danger"><?php echo $error;?></h5>
    </div>
</body>
</html>