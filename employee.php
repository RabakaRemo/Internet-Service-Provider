<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="dash_admin.css">
    <!-- Link End -->

</head>
<body>

    <?php
        // Login check
        require '_logincheck_admin.php';

        // Defining Page Type
        $page_type = "employee";
        $page_name = "employee";

        // Variable
        $key = "all";
        $word = "";
        
        // If assign task button clicked
        if(isset($_POST['assign_task'])) {
            // Connect to the database
            require '_database_connect.php';
            // Close the database connection
            mysqli_close($connect);

            // Session variable clear
            require '_unset_seasion_variable.php';

            // Seasion Variable for assign task to employee employee
            $_SESSION['employee_id_task'] = $_POST['employee_id'];

            //redirect to the asign task page
            echo "<script> window.location.href='assign_task.php';</script>";
            die();
        }

        // If detail button clicked
        if(isset($_POST['details'])) {
            // Connect to the database
            require '_database_connect.php';
            // Close the database connection
            mysqli_close($connect);

            // Seasion Variable for employee dtails
            $_SESSION['employee_id_details'] = $_POST['employee_id'];

            // Generate the JavaScript code to open the new tab
            echo "<script>
                var newTab = window.open('employee_details_admin.php', '_blank');
                newTab.onload = function() {
                    window.location.href = window.location.href.split('?')[0];
                };
            </script>";

            // Prevent form resubmission on reload
            echo "<script>history.pushState({}, '', '');</script>";
        }    

        // If searched
        if(isset($_GET['search'])){
            $key = $_GET['key'];
            $word = $_GET['word'];
        }

        // If Re-Set
        if(isset($_GET['reset'])){
            $key = "all";
            $word = "";
        }

        // Navbar
        require '_nav_admin.php';
    ?>

    <!-- Search Bar -->
    <div class="container my-2">
        <form method="get">
            <div class="input-group">
                <!-- Recruit Button -->
                <a href="employee_recruit.php" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Recruit
                </a>
                
                <!-- Search bar with filter -->
                <select class="search-select" name="key" style="width: 20%;">
                    <option value="all" selected>Search By</option>
                    <option value="name">Name</option>
                    <option value="post">Post</option>
                    <option value="phone">Phone</option>
                    <option value="email">Email</option>
                    <option value="e-id">Employee-ID</option>
                </select>
                <input type="text" class="form-control" name="word" placeholder="Search">
                <button class="btn btn-danger btn-outline-light" name="search" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>  
                <button class="btn btn-success btn-outline-light" name="reset" type="submit"><i class="fa-solid fa-rotate"></i> Re-set</button>  
            </div>
        </form>
    </div>

    <?php
        // Showing result
        // Connect to the database
        require '_database_connect.php';

        // SQL
        if(isset($key) && isset($word)){
            if($key=="all" && $word==""){
                $show_employee_sql = "SELECT * FROM `employee`";
            } else if($key=="all" && $word!=""){
                    $show_employee_sql = "SELECT * FROM `employee` WHERE CONCAT(name, post, phone, email, id) LIKE '%$word%'";
            } else if($key=="name" && $word!=""){
                $show_employee_sql = "SELECT * FROM `employee` WHERE `name` LIKE '%$word%'";
            } else if($key=="post" && $word!=""){
                $show_employee_sql = "SELECT * FROM `employee` WHERE `post` LIKE '%$word%'";
            } else if($key=="phone" && $word!=""){
                $show_employee_sql = "SELECT * FROM `employee` WHERE `phone` LIKE '%$word%'";
            } else if($key=="email" && $word!=""){
                $show_employee_sql = "SELECT * FROM `employee` WHERE `email` LIKE '%$word%'";
            } else if($key=="e-id" && $word!=""){
                $show_employee_sql = "SELECT * FROM `employee` WHERE `id` LIKE '%$word%'";
            } else {$show_employee_sql = "SELECT * FROM `employee`";}
        }

        // Query
        $run_show_employee = mysqli_query($connect, $show_employee_sql);
        $total_employee = mysqli_num_rows($run_show_employee);
                
        // Close the database connection
        mysqli_close($connect);

        // Showing Employee list
        echo "
            <div class='container overflow-auto mt-4'>
                <div class='num_of_res text-light btn btn-dark m-2'>
                    <h7 class='pt-2'>Total Result: $total_employee</h7>
                </div>";
        if($total_employee>0){
            // Show the Employee List
            echo "
                <table class='table table-info table-striped table-hover m-2 p-2 text-center'>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Pending Task</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            for($i=0; $i<$total_employee; $i++){
                // Connect to the database
                require '_database_connect.php';
                // Get row

                $employee = mysqli_fetch_assoc($run_show_employee);

                //get task number
                $get_task_number_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$employee['id']}'";
                $get_task_number = mysqli_query($connect, $get_task_number_sql);
                $task_number = mysqli_num_rows($get_task_number);

                
                // Close the database connection
                mysqli_close($connect);
                
                echo "
                        <tr>
                            <td><img src='$employee[photo_file]' class='rounded-circle' alt='Employee Photo' style='width: 50px'></td>
                            <td>$employee[name]</td>
                            <td>$employee[post]</td>
                            <td>$employee[phone]</td>
                            <td>$employee[email]</td>
                            <td>$task_number</td>
                            <td>
                                <form method='post'>
                                    <input class='visually-hidden' type='text' name='employee_id' value='$employee[id]'>

                                    <button class='btn btn-danger mb-1' type='submit' name='assign_task' style='width: 114px'>Assign Task</button>

                                    <button class='btn btn-success' type='submit' name='details' style='width: 114px'>Details</button>
                                </form>
                            </td>
                        </tr>
                ";
            }
            echo "
                    </tbody>
                </table>
            ";
        }
        echo"</div>";

        // Connect to the database
        require '_database_connect.php';
        // Close the database connection
        mysqli_close($connect);
    ?>

</body>
</html>
