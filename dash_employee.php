<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dash_admin.css">
    <!-- Link End -->

</head>
<body>
<?php
    //Login check
    require '_logincheck_employee.php';
            
    //Defining Page
    $page_name = "Home";

    //Navbar
    require '_nav_employee.php';

    // connect to the database
    require '_database_connect.php';

    // Get number of pending task
    $find_pending_task_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$_SESSION['id']}' AND `status` = 'Pending'";
    $find_pending_task = mysqli_query($connect, $find_pending_task_sql);
    $pending_task_num = mysqli_num_rows($find_pending_task);

    // Get number of conplited task
    $find_completed_task_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$_SESSION['id']}' AND `status` = 'Completed'";
    $find_completed_task = mysqli_query($connect, $find_completed_task_sql);
    $completed_task_num = mysqli_num_rows($find_completed_task);

    // Get number of Expiard task
    $find_expired_task_sql = "SELECT * FROM `task` WHERE `employee_id` = '{$_SESSION['id']}' AND `status` = 'Expired'";
    $find_expired_task = mysqli_query($connect, $find_expired_task_sql);
    $expired_task_num = mysqli_num_rows($find_expired_task);
?>

<div class="container">
    <div class="row justify-content-center my-5">


        <!-- Task -->
        <div class="col-auto p-2">
            <div class="card-box card-1 text-bg-light rounded d-flex align-items-center">
                <div class="card-side rounded-start" style="background-color: red"></div>
                <div class="card-text">
                    <h5><i class="fa-solid fa-list-check" style="color: #9d8189"></i>Pending Tasks</h5>
                    <p>On-Going Task: <?php echo "$pending_task_num"; ?></p>
                    <form method="post"><button class="btn btn-secondary rounded p-2" type="submit" name="pending_tasks">Pending Task list</button></form>
                </div>
            </div>
        </div>

        <!-- Task -->
        <div class="col-auto p-2">
            <div class="card-box card-1 text-bg-light rounded d-flex align-items-center">
                <div class="card-side rounded-start" style="background-color: green"></div>
                <div class="card-text">
                    <h5><i class="fa-solid fa-check"></i> Completed Tasks</h5>
                    <p>Completed Task: <?php echo "$completed_task_num"; ?></p>
                    <form method="post"><button class="btn btn-secondary rounded p-2" type="submit" name="pending_tasks">Completed Task list</button></form>
                </div>
            </div>
        </div>

        <!-- Task -->
        <div class="col-auto p-2">
            <div class="card-box card-1 text-bg-light rounded d-flex align-items-center">
                <div class="card-side rounded-start" style="background-color: black"></div>
                <div class="card-text">
                    <h5><i class="fa-solid fa-xmark"></i> Expired Tasks</h5>
                    <p>Expired Task: <?php echo "$expired_task_num"; ?></p>
                    <form method="post"><button class="btn btn-secondary rounded p-2" type="submit" name="pending_tasks">Expired Task list</button></form>
                </div>
            </div>
        </div>


    </div>
</div>



<?php require '_footer_common.php';?>
</body>
</html>