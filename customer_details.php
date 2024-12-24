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
    <link rel="stylesheet" href="customer_details.css">
    <!-- Link End -->

</head>
<body>
    <?php
        //Login check
        require '_logincheck_admin.php';
            
        //Defining Page
        $page_type = "customers_list";
        $page_name = "Customers Details";
        
        //Navbar
        require '_nav_admin.php';

        // connect to the database
        require '_database_connect.php';

        //getting Customer Info
        $find_customer_sql = "SELECT * FROM `customer` WHERE `id` = '{$_SESSION['customer_id_details']}'";
        $find_customer = mysqli_query($connect, $find_customer_sql);
        $customer = mysqli_fetch_assoc($find_customer);

        // Find the connections number
        $find_customer_connection_sql = "SELECT * FROM `connections` where `customer_id` = '{$_SESSION['customer_id_details']}'";// AND `state` != 'Connection Panding'
        $find_connection = mysqli_query($connect, $find_customer_connection_sql);
        $total_connections = mysqli_num_rows($find_connection);
    ?>

    <div class="container">
        <div class="row row-cols-auto bg-light rounded justify-content-center my-4">
            <!-- profile picture -->
            <div class="col-auto m-2">
                <img class="pp_img" src="images\profile.jpg" alt="Profile Picture">
            </div>
            <!-- Details -->
            <div class="col-auto m-2 ms-md-3">
                <div class="bg-dark text-light rounded pb-1 pt-2 px-3 text-center"><h2><b><?php echo$customer["name"]?></b></h2></div>
                <div class="details fs-5 mt-4">
                    <p>
                        <b>Address: </b><?php echo $customer['address'];?><br>
                        <b>Email: </b><?php echo $customer['email'];?><br>
                        <b>Phone: </b><?php echo $customer['phone'];?><br>
                        <b>NID: </b><?php echo $customer['nid'];?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Connection Section -->
    <div class='container <?php if($total_connections>0){echo "overflow-x-scroll";}?>'>
        <div>
            <h5 class='p-2 bg-info rounded'>Total Active Connections: <?php echo $total_connections;?></h5>
        </div>

    <?php
        // Showing Customer list
        if($total_connections>0){
            echo "
            <table class='table table-info table-striped table-hover mx-2 p-2 text-center'>
            <thead>
                <tr>
                    <th>Connection name</th>
                    <th>Address</th>
                    <th>Plan Type</th>
                    <th>Plan Name</th>
                    <th>Speed</th>
                    <th>Monthly Bill</th>
                </tr>
            </thead>
            <tbody>";
            for($i=0; $i<$total_connections; $i++){
                //getting customer info
                $customer = mysqli_fetch_assoc($find_customer);

                //Getting connection info
                $connection = mysqli_fetch_assoc($find_connection);

                // getting plan name
                $plan_sql = "SELECT * FROM `{$connection['type']}` WHERE `id` = '{$connection['plan_id']}'";
                $get_plan = mysqli_query($connect, $plan_sql);
                $plan = mysqli_fetch_assoc($get_plan);

                echo"
                <tr>
                    <td>$connection[name]</td>
                    <td>$connection[address]</td>
                    <td>$connection[type]</td>
                    <td>$plan[name]</td>
                    <td>$plan[speed]</td>
                    <td>$plan[price]</td>
                </tr>";
            }
            echo "
            </tbody>
        </table>";
        }

        // Close the database connection
        mysqli_close($connect);
    ?>
    </div>

    <!-- Paymeent History section -->
    <div class='container <?php if($total_payement>0){echo "overflow-x-scroll";}?>'>
        <div>
            <h5 class='p-2 bg-info rounded'>Total Active Connections: <?php echo $total_connections;?></h5>
        </div>

    <?php
        // Showing Customer list
        if($total_connections>0){
            echo "
            <table class='table table-info table-striped table-hover mx-2 p-2 text-center'>
            <thead>
                <tr>
                    <th>Connection name</th>
                    <th>Address</th>
                    <th>Plan Type</th>
                    <th>Plan Name</th>
                    <th>Speed</th>
                    <th>Monthly Bill</th>
                </tr>
            </thead>
            <tbody>";
            for($i=0; $i<$total_connections; $i++){
                //getting customer info
                $customer = mysqli_fetch_assoc($find_customer);

                //Getting connection info
                $connection = mysqli_fetch_assoc($find_connection);

                // getting plan name
                $plan_sql = "SELECT * FROM `{$connection['type']}` WHERE `id` = '{$connection['plan_id']}'";
                $get_plan = mysqli_query($connect, $plan_sql);
                $plan = mysqli_fetch_assoc($get_plan);

                echo"
                <tr>
                    <td>$connection[name]</td>
                    <td>$connection[address]</td>
                    <td>$connection[type]</td>
                    <td>$plan[name]</td>
                    <td>$plan[speed]</td>
                    <td>$plan[price]</td>
                </tr>";
            }
            echo "
            </tbody>
        </table>";
        }

        // Close the database connection
        mysqli_close($connect);
    ?>
    </div>



</body>
</html>