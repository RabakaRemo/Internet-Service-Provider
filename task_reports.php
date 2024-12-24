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
        require '_logincheck_admin.php';
            
        //Defining Page
        $page_type = "reports";
        $page_name = "Task List";

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

        // If detail button clicked
        if(isset($_POST['details'])) {
            // Connect to the database
            require '_database_connect.php';
            // Close the database connection
            mysqli_close($connect);

            // Seasion Variable for employee dtails
            $_SESSION['employee_id_details'] = $_POST['em_id'];
    
            // Generate the JavaScript code to open the new tab
            echo "<script> window.open('employee_details_admin.php', '_blank');
                newTab.onload = function() {
                    window.location.href = window.location.href.split('?')[0];
                };
            </script>";
    
            // Prevent form resubmission on reload
            echo "<script>history.pushState({}, '', '');</script>";
        }
        
    ?>

    <div class="container my-3">
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
        // if Assign task button clicked
        if(isset($_GET['assign_task'])) {
            // Rederection for assign_task Page
            echo "<script> window.location.href='assign_task.php';</script>";
            die();
        }

        //Sarcbar function
        if(isset($key) && isset($word)){
            if($key=="all" && $word==""){
                $find_task_sql = "SELECT * FROM `task`";
            } else if($key=="all" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE CONCAT(name, address, state) LIKE '%$word%'";
            } else if($key=="title" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `name` LIKE '%$word%'";
            } else if($key=="address" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `address` LIKE '%$word%'";
            } else if($key=="status" && $word!=""){
                $find_task_sql = "SELECT * FROM `task` WHERE `state` LIKE '%$word%'";
            }
        } else {$find_task_sql = "SELECT * FROM `task`";}

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
                            <th>Status</th>
                            <th>Last Date</th>
                            <th>Employee Details</th>
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
                            <td>
                                <form method='post'>
                                    <input class='visually-hidden' type='text' name='em_id' value='$task[employee_id]'</input>
                                    <button class='btn btn-success' type='submit' name='details'>Employee details</button>
                                </form>
                            </td>
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

</body>
</html>