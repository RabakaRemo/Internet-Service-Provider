<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navbar.css">
    <!-- Link End -->

</head>
<body>
    <?php
        //Login check
        require '_logincheck_employee.php';
            
        //Defining Page
        $page_name = $_SESSION['task_type']." Tasks";

        //Navbar
        require '_nav_employee.php';

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
        
    ?>



    <div class="container my-3">
        <!-- Search bar with filter -->
        <form method="get">
            <div class="input-group">
                <button class="btn btn-success btn-outline-light" name="reset" type="submit"><i class="fa-solid fa-rotate"></i></i> Re-set</button>  
                <select class="search-select" name="key" style="width: 20%;">
                    <option value="all" selected>Search By</option>
                    <option value="title">Title</option>
                    <option value="address">Address</option>
                    <option value="status">Status</option>
                </select>
                <input type="text" class="form-control" name="word" placeholder="Search">
                <button class="btn btn-danger btn-outline-light" name="search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></i> Search</button>  
            </div>
        </form>
    </div>



    <?php
        if (isset($_SESSION['task_type'])) $match = " AND  `status` = '{$_SESSION['task_type']}'"; else {
            echo "<script> window.location.href='dash_employee.php';</script>";
            die();
        }
        
        //Sarcbar function
        if(isset($key) && isset($word)){
            if($key=="all" && $word==""){
                $find_task_sql = "SELECT * FROM `task` WHERE `status` = '{$_SESSION['task_type']}'";
            } else if($key=="all" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE CONCAT(title, address, status) LIKE '%$word%'".$match;
            } else if($key=="title" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `title` LIKE '%$word%'".$match;
            } else if($key=="address" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `address` LIKE '%$word%'".$match;
            } else if($key=="status" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `status` LIKE '%$word%'".$match;
            }
        } else {$find_task_sql = "SELECT * FROM `task` WHERE `status` = '{$_SESSION['task_type']}'";}

        // connect to the database
        require '_database_connect.php';

        //Query
        $find_task = mysqli_query($connect, $find_task_sql);
        $total_task = mysqli_num_rows($find_task);

        // Showing task list
        if($total_task>0){
            echo "
            <div class='container overflow-x-scroll mt-4'>
                <div class='num_of_res text-light btn btn-dark m-2'>
                    <h7 class='pt-2'>Total Result: $total_task</h7>
                </div>
                <table class='table table-info table-striped table-hover m-2 p-2 text-center'>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Address</th>
                            <th>Customer Number</th>
                            <th>Status</th>
                            <th>Last Date</th>
                            <th>Employee Details</th>
                        </tr>
                    </thead>
                    <tbody>";
                for($i=0; $i<$total_task; $i++){
                    $task = mysqli_fetch_assoc($find_task);

                    // Find the Employee number
                    //$find_task_employee_sql = "SELECT * FROM `employee` where `id` = '{$task['employee_id']}'";
                    //$find_task_employee = mysqli_query($connect, $find_task_employee_sql);
                    //$task_employee = mysqli_num_rows($find_task_employee);

                    echo"<tr>
                            <td>$task[title]</td>
                            <td>$task[address]</td>
                            <td>$task[address]</td>
                            <td>$task[status]</td>
                            <td>$task[last_date]</td>
                            <td>
                                <form method='post'>
                                    <input class='visually-hidden' type='text' name='t_id' value='$task[id]'</input>";
                                    switch ($_SESSION['task_type']){
                                        case "Pending":
                                            echo "<button type='submit' name='details' class='btn btn-danger'>Job Done</button>";
                                            break;
                                        case "Completed":
                                            echo "<button class='btn btn-success'>Complited</button>";
                                            break;
                                        case "Expired":
                                            echo "<button type='submit' name='details' class='btn btn-darks'>Lately Done</button>";
                                            break;
                                    }
                                    
                                echo "</form>
                            </td>
                        </tr>";
                }
                echo"
                    </tbody>
                </table>
            </div>";
        }
        
        

        // If detail button clicked
        if(isset($_POST['details'])) {
            // Connect to the database
            require '_database_connect.php';

            //Get update task info
            $up_task_info_sql = "SELECT * FROM `task` WHERE `id` = '{$_POST['t_id']}'";
            $up_task_info = mysqli_query($connect, $up_task_info_sql);
            $up_task = mysqli_fetch_assoc($up_task_info);

            if (strpbrk($up_task['task_ref'], '0123456789')) {
                // Check request type
                $check_state_sql = "SELECT * FROM `connections` WHERE `id` = '{$up_task['task_ref']}'";
                $check_state = mysqli_query($connect, $check_state_sql);
            
                // Ensure the query was successful
                if ($check_state) {
                    $state = mysqli_fetch_assoc($check_state);
            
                    // Determine the appropriate SQL query based on the state
                    if ($state['state'] == "Delete Request Pending") {
                        $up_connection_sql = "DELETE FROM `connections` WHERE `connections`.`id` = '{$up_task['task_ref']}'";
                    } else {
                        $up_connection_sql = "UPDATE `connections` SET `state` = 'Active' WHERE `connections`.`id` = '{$up_task['task_ref']}'";
                    }
            
                    // Execute the update or delete query
                    $up_connec_state = mysqli_query($connect, $up_connection_sql);
            
                    // Check if the update/delete was successful
                    if (!$up_connec_state) {
                        // Handle the error if the query failed
                        echo "Error updating connection state: " . mysqli_error($connect);
                    }
                } else {
                    // Handle the error if the initial query failed
                    echo "Error checking connection state: " . mysqli_error($connect);
                }
            }
            //update task status
            $up_task_status_sql = "UPDATE `task` SET `status` = 'Completed' WHERE `task`.`id` = '{$_POST['t_id']}'";
            $up_task_status = mysqli_query($connect, $up_task_status_sql);
            // Close the database connection
            mysqli_close($connect);
        }
    
    ?>

</body>
</html>