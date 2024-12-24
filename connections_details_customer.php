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
        require '_logincheck_customer.php';
            
        //Defining Page
        $page_type = "connections";
        $page_name = "Connection Details";
        
        //Navbar
        require '_nav_customer.php';

        // connect to the database
        require '_database_connect.php';

        // Get Connection Info
        $find_connection_sql = "SELECT * FROM `connections` WHERE `id` = '{$_SESSION['connections_id_details']}'";
        $find_connection = mysqli_query($connect, $find_connection_sql);
        $connection = mysqli_fetch_assoc($find_connection);

        //Get plan info
        $plan_sql = "SELECT * FROM `{$connection['type']}` WHERE `id` = '{$connection['plan_id']}'";
        $get_plan = mysqli_query($connect, $plan_sql);
        $plan = mysqli_fetch_assoc($get_plan);

        //To show Update State Not Requested Plan ID
        if($connection['state']!="Active" && $connection['state']!="Delete Request Pending" && $connection['state']!="Connection Pending"){
            $connection['state'] = "Update Request Pending";
        }

        // Close the database connection
        mysqli_close($connect);
    ?>

    <div class="container mb-5">
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
                        <button class="btn btn-danger" type="submit" name="delete"><i class="fa-solid fa-trash-can"></i> Delete Connection</button>
                    </form>
                </div>
            </div>

            <div class="row-auto card bg-dark text-light py-3 rounded m-2">
                <div class=" card-header">
                    <h3 class="text-center text-decoration-underline">Plan Info</h3>
                </div>
                <div class="card-body">
                    <b>Name: </b><?php echo $plan['name'] ?><br>
                    <b>Speed: </b><?php echo $plan['speed'] ?><br>
                    <b>Real-IP: </b><?php echo $plan['realip'] ?><br>
                    <b>Price: </b><?php echo $plan['price'] ?>
                </div>
                    <?php
                        if($connection['state']=="Active"){
                            echo "
                            <div class='card-footer'>
                                <form method='post'>
                                    <button class='btn btn-primary' type='submit' name='update'><i class='fa-solid fa-circle-up'></i> Update Plan</button>
                                </form>
                            </div>";
                        }
                    ?>
            </div>

        </div>
        <a class="btn btn-info" href="dash_customer.php"><i class="fa-solid fa-delete-left"></i> Back</a>
    </div>
    
    <!-- Footer -->
    <?php include '_footer_common.php';?>


    <?php

        //if Delete connection button Clicked
        if(isset($_POST['delete'])){
            // connect to the database
            require '_database_connect.php';

            if($connection['state']=="Connection Panding"){
                $delete_sql = "DELETE FROM `connections` WHERE `id` = '{$connection['id']}'";
            }
            else {$delete_sql = "UPDATE `connections` SET `state` = 'Delete Request Pending' WHERE `id` = '{$connection['id']}'";}
            
            $delete = mysqli_query($connect, $delete_sql);

            // Close the database connection
            mysqli_close($connect);

            //Rederection to the connection page
            echo "<script> window.location.href='dash_customer.php';</script>";
            die();
        }

        //if update plan button Clicked
        if(isset($_POST['update'])){
            $_SESSION['action'] = "update";
            $_SESSION['plan_type'] = $connection['type'];
            $_SESSION['plan_id'] = $plan['id'];
            //Rederection to the connection page
            echo "<script> window.location.href='plans_customer.php';</script>";
            die();
        }
    ?>

</body>
</html>