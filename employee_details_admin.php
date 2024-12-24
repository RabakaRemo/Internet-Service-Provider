<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee <Details></Details></title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="customer_details.css">
    <!-- Link End -->

</head>
<body>
    <?php
        //Login check
        require '_logincheck_admin.php';
        
        $employee_id = "";
        if (isset($_SESSION["employee_id_details"])) {
            $employee_id = $_SESSION["employee_id_details"];
            //unset($_SESSION["employee_id_details"]);
        } else {
            echo "<script> window.location.href='task_reports.php';</script>";
            die();
        }
        //Defining Page
        $page_type = "manage_employee";
        $page_name = "Employee Details";
        
        //Navbar
        require '_nav_admin.php';

        //if searched
        if(isset($_GET['search'])){
            $key = $_GET['key'];
            $word = $_GET['word'];
        }

        //If Re-Set
        if(isset($_GET['reset'])){
            $key = "all";
            $word = "";
        }

        // if Assign task button clicked
        if(isset($_GET['assign_task'])) {
            // Rederection for assign_task Page
            $_SESSION['employee_id_task'] = $employee_id;
            echo "<script> window.location.href='assign_task.php';</script>";
            die();
        }

        // connect to the database
        require '_database_connect.php';

        //getting Employee Info
        $find_employee_sql = "SELECT * FROM `employee` WHERE `id` = '{$employee_id}'";
        $find_employee = mysqli_query($connect, $find_employee_sql);
        $employee = mysqli_fetch_assoc($find_employee);

        //Sarcbar function
        if(isset($key) && isset($word)){
            if($key=="all" && $word==""){
                $find_task_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$employee_id}'";
            } else if($key=="all" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE CONCAT(name, address, state) LIKE '%$word%' AND `employee_id` = '{$employee_id}'";
            } else if($key=="title" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `name` LIKE '%$word%' AND `employee_id` = '{$employee_id}'";
            } else if($key=="address" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `address` LIKE '%$word%' AND `employee_id` = '{$employee_id}'";
            } else if($key=="status" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `state` LIKE '%$word%' AND `employee_id` = '{$employee_id}'";
            }
        } else {$find_task_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$employee_id}'";}

        // Find the task number
        $find_task = mysqli_query($connect, $find_task_sql);
        $total_task = mysqli_num_rows($find_task);
    ?>

    <div class="container">
        <div class="row row-cols-auto bg-light rounded justify-content-center my-4">
            <!-- profile picture -->
            <div class="col-auto m-2">
                <img class="pp_img" src="<?php echo $employee['photo_file']?>" alt="Profile Picture">
            </div>
            <!-- Details -->
            <div class="col-auto m-2 ms-md-3">
                <div class="bg-dark text-light rounded pb-1 pt-2 px-3 text-center"><h2><b><?php echo $employee["name"]?></b></h2></div>
                <div class="details fs-5 mt-4">
                    <p>
                        <b>Post: </b><?php echo $employee['post'];?><br>
                        <b>Address: </b><?php echo $employee['address'];?><br>
                        <b>Email: </b><?php echo $employee['email'];?><br>
                        <b>Phone: </b><?php echo $employee['phone'];?><br>
                        <b>NID: </b><?php echo $employee['nid'];?><br>
                        <b>Salary: </b><?php echo $employee['salary'];?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- task Section -->
    <div class='container'>
        <div>
            <h5 class='p-2 bg-info rounded'>Total Assigned Task: <?php echo $total_task;?></h5>
        </div>

        <div class="container">
            <!-- Search bar with filter -->
            <form method="get">
                <div class="input-group">
                    <!-- assign_task Button -->
                    <button type="submit" class="btn btn-success" name="assign_task">
                        <i class="fa-solid fa-plus"></i> Assign Task    
                    </button>
                    <select class="search-select" name="key" style="width: 20%;">
                        <option value="all" selected>Search By</option>
                        <option value="title">Title</option>
                        <option value="address">Address</option>
                        <option value="status">Status</option>
                    </select>
                    <input type="text" class="form-control" name="word" placeholder="Search">
                    <button class="btn btn-danger btn-outline-light" name="search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></i> Search</button> 
                    <button class="btn btn-success btn-outline-light" name="reset" type="submit"><i class="fa-solid fa-rotate"></i></i> Re-set</button>  

                </div>
            </form>
        </div>

        <?php
            // Showing task list
            if($total_task>0){
                echo "
                <div class='container overflow-x-scroll'>
                    <div class='num_of_res text-light btn btn-dark m-1'>
                        <h7 class='pt-2'>Total Result: $total_task</h7>
                    </div>
                    <table class='table table-info table-striped table-hover m-1 p-2 text-center'>
                        <thead>
                            <tr>
                                <th>Titel</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Last Date</th>
                            </tr>
                        </thead>
                        <tbody>";
                    for($i=0; $i<$total_task; $i++){
                        $task = mysqli_fetch_assoc($find_task);

                        echo"<tr>
                                <td>$task[name]</td>
                                <td>$task[address]</td>
                                <td>$task[state]</td>
                                <td>$task[end]</td>
                            </tr>";
                    }
                    echo"
                        </tbody>
                    </table>
                </div>";
            }

            // Close the database connection
            mysqli_close($connect);
        ?>
    </div>

    <!-- Paymeent History section -->
    <div class='container <?php if($total_payement>0){echo "overflow-x-scroll";}?>'>
        <div>
            <h5 class='p-2 bg-info rounded'>Total Active Connections: <?php echo $total_task;?></h5>
        </div>

    <?php
        // Showing Customer list
        if($total_task>0){
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
            for($i=0; $i<$total_task; $i++){
                //getting customer info
                $employee = mysqli_fetch_assoc($find_customer);

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
    ?>
    </div>
</body>
</html>