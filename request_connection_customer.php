<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plans</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navbar.css">
    <!-- Link End -->

</head>
<body>
    <?php
        //Login check
        require '_logincheck_customer.php';
            
        // Defining Page
        $page_type = "new_cnonnection";
        if($_SESSION['plan_type'] == "residential_plans"){
            $page_name = "Residential Connection Request";
        } else if ($_SESSION['plan_type'] == "organizational_plans"){
            $page_name = "Organizational Connection Request";
        }

        // Navbar
        require '_nav_customer.php';

        $error = "";

        // connect to the database
        require '_database_connect.php';

        //getting tthe plan details
        // SQL
        $plan_sql = "SELECT * FROM `{$_SESSION['plan_type']}` WHERE `id` = '{$_SESSION['plan_id_new']}'";
        //Query
        $plan_query = mysqli_query($connect, $plan_sql);
        $total_plans = mysqli_num_rows($plan_query);
        if($total_plans==1){
            //Getting the row
            $plan = mysqli_fetch_assoc($plan_query);
        }

        //Gatting Customer Defalt Address
        $address_sql = "SELECT * FROM `customer` WHERE `id` = '{$_SESSION['id']}'";
        //Query
        $address_query = mysqli_query($connect, $address_sql);
        $total_customer = mysqli_num_rows($address_query);
        if($total_customer==1){
            //Getting the row
            $customer = mysqli_fetch_assoc($address_query);
        }

        // Close the database connection
        mysqli_close($connect);




        //Submit the address
        if(isset($_POST['request'])) {
            // connect to the database
            require '_database_connect.php';

            $new_connection_sql = "INSERT INTO `connections` (`type`, `name`, `customer_id`, `plan_id`, `address`, `starting_date`, `state`) VALUES ('{$_SESSION['plan_type']}', '{$_POST['name']}', '{$_SESSION['id']}', '{$_SESSION['plan_id_new']}', '{$_POST['address']}', '{$_POST['start_date_rq']}', 'Connection Pending')";
            $new_connection_query = mysqli_query($connect, $new_connection_sql);

            if($new_connection_query){
                echo "<script> window.location.href='plans_customer.php';</script>";
            } else {$error = "Faild to Submite Request";}

            // Close the database connection
            mysqli_close($connect);
        }
    ?>

    <!-- Add Plan form -->
    <div class="container rounded bg-black my-5 p-4 text-light">
        <h3 class="border p-2 text-center">Comfirm Your <?php if($_SESSION['plan_type']=="residential_plans"){echo 'Residential';} else if ($_SESSION['plan_type']== "organizational_plans"){echo 'Organizational';}?> Connection Details</h3>
        <p>
            <h4>Plan Details for This Connection</h4>
            <b>Plan Name: </b><?php echo $plan['name']; ?><br>
            <b>Speed: </b><?php echo $plan['speed']; ?> Mbps<br>
            <b>Real-IP: </b><?php echo $plan['realip']; ?><br>
            <b>Price: </b><?php echo $plan['price']; ?> TK/Month<br>
        </p>
        <form method="post">
            <div class="my-4">
                <label for="name" class="form-label">Name of your connection</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Connection Name" required>
            </div>
            <div class="my-4">
                <label for="address" class="form-label">Instalation Address</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php echo $customer['address']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="start_date_rq" class="form-label">Form when you want to start the connection</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="start_date_rq" name="start_date_rq" required>
                </div>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-success" name="request"><i class="fa-solid fa-cloud-arrow-up"></i> Submit Request</button>
                <a href="plans_customer.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i> Cancel</a>
            </div>
        </form>
        <h5 class="text-danger"><?php echo $error;?></h5>
    </div>
    
</body>
</html>