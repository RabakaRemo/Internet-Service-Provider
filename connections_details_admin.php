<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comone page for Admin</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="connections_details.css">
    <!-- Link End -->

</head>
<body>
    <?php
        //Login check
        require '_logincheck_admin.php';
            
        //Defining Page
        $page_type = "connections";
        $page_name = "Connection Details";
        
        //Navbar
        require '_nav_admin.php';

        // connect to the database
        require '_database_connect.php';

        // Get Connection Info
        $find_connection_sql = "SELECT * FROM `connections` WHERE `id` = '{$_SESSION['connections_id_details']}'";
        $find_connection = mysqli_query($connect, $find_connection_sql);
        $connection = mysqli_fetch_assoc($find_connection);

        //To show Update State Not Requested Plan ID
        if (strpbrk($connection['state'], "0123456789")!=false){$connection['state']="Update request pending";}

        //Get plan info
        $plan_sql = "SELECT * FROM `{$connection['type']}` WHERE `id` = '{$connection['plan_id']}'";
        $get_plan = mysqli_query($connect, $plan_sql);
        $plan = mysqli_fetch_assoc($get_plan);

        //Get Customer info
        $customer_sql = "SELECT * FROM `customer` WHERE `id` = '{$connection['customer_id']}'";
        $get_customer = mysqli_query($connect, $customer_sql);
        $customer = mysqli_fetch_assoc($get_customer);

        // Close the database connection
        mysqli_close($connect);
    ?>

    <div class="container">
        <div class="row row-cols-auto justify-content-center">

            <div class="row-auto card bg-dark text-light py-3 rounded m-2">
                <div class=" card-header">
                    <h3 class="text-center text-decoration-underline">Connection Info</h3>
                </div>
                <div class="card-body">
                    <b>Name: </b><?php echo $connection['name'] ?><br>
                    <b>Address: </b><?php echo $connection['address'] ?><br>
                    <b>Statas: </b><?php echo $connection['state'] ?>
                </div>
                <div class="card-footer">
                    <form method="post">
                        <button class="btn btn-danger" type="submit" name="delete"><i class="fa-solid fa-trash-can"></i> Disconnect Connection</button>
                    </form>
                </div>
            </div>

            <div class="row-auto card bg-dark text-light py-3 rounded m-2">
                <div class=" card-header">
                    <h3 class="text-center text-decoration-underline">Plan Info</h3>
                </div>
                <div class="card-body">
                    <b>Name: </b><?php echo $plan['name'] ?><br>
                    <b>Speed: </b><?php echo $plan['speed'] ?> MBps<br>
                    <b>Real-IP: </b><?php echo $plan['realip'] ?><br>
                    <b>Price: </b><?php echo $plan['price'] ?>
                </div>
                <div class="card-footer">
                    <form method="post">
                        <button class="btn btn-primary" type="submit" name="update"><i class="fa-solid fa-circle-up"></i> Update Plan</button>
                    </form>
                </div>
            </div>

            <div class="row-auto card bg-dark text-light py-3 rounded m-2">
                <div class=" card-header">
                    <h3 class="text-center text-decoration-underline">Customer Info</h3>
                </div>
                <div class="card-body">
                    <b>Name: </b><?php echo $customer['name'] ?><br>
                    <b>Address: </b><?php echo $customer['address'] ?><br>
                    <b>Phone: </b><?php echo $customer['phone'] ?><br>
                    <b>Email: </b><?php echo $customer['email'] ?><br>
                </div>
                <div class="card-footer">
                    <form method="post">
                        <form method="post">
                            <button class="btn btn-success" type="submit" name="customer_details">Customer Details</button>
                        </form>
                    </form>
                </div>
            </div>

        </div>
        <a class="btn btn-info" href="connections_admin.php"><i class="fa-solid fa-delete-left"></i> Back</a>
    </div>


    <?php

        //if Delete connection button Clicked
        if(isset($_POST['delete'])){
            // connect to the database
            require '_database_connect.php';
            
            $delete_sql = "UPDATE `connections` SET `state` = 'Delete Request Pending'  WHERE `id` = '{$_SESSION['connections_id_details']}'";
            $delete = mysqli_query($connect, $delete_sql);

            // Close the database connection
            mysqli_close($connect);

            $_SESSION['connections_id_details'] =$connection['id'];
            //Rederection to the connection page
            echo "<script> window.location.href='assign_task.php';</script>";
            die();
        }

        //if Customer Details button Clicked
        else if(isset($_POST['customer_details'])){
            $_SESSION['customer_id_details'] = $customer['id'];
            //Rederection to the connection page
            echo "<script> window.location.href='customer_details.php';</script>";
            die();
        }

        //if update button Clicked
        else if(isset($_POST['update'])){
            $_SESSION['action'] = "update";
            $_SESSION['plan_type'] = $connection['type'];
            $_SESSION['plan_id'] = $plan['id'];
            //Rederection to the connection page
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        }
    ?>

</body>
</html>