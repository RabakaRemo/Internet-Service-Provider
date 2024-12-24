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
        // Login check
        require '_logincheck_admin.php';
            
        // Defining Page
        $page_type = "plan";
        if($_SESSION['plan_type'] == "residential_plans"){
            $page_name = "Add Residential Plan";
        } else if ($_SESSION['plan_type'] == "organizational_plans"){
            $page_name = "Add Organizational Plan";
        }

        // Navbar
        require '_nav_admin.php';

        $error = "";

        // Adding plan to the database
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // connect to the database
            require '_database_connect.php';

            // storing plan values
            $name = $_POST['plan_name'];
            $speed = $_POST['plan_speed'];
            $price = $_POST['plan_price'];
            $readip = $_POST['plan_realip'];

            // SQL
            $add_plan_sql = "INSERT INTO `{$_SESSION['plan_type']}` (`name`, `speed`, `price`, `realip`) VALUES ('$name', '$speed', '$price', '$readip')";

            // Insert Data Into Database
            $insert_plan = mysqli_query($connect, $add_plan_sql);

            if($insert_plan) {
                // Success, redirect
                if($_SESSION['plan_type'] == "residential_plans"){
                    mysqli_close($connect);
                    echo "<script> window.location.href='plans_admin.php';</script>";
                    die();
                } else if ($_SESSION['plan_type'] == "organizational_plans"){
                    mysqli_close($connect);
                    echo "<script> window.location.href='plans_admin.php';</script>";
                    die();
                }
            } else {
                $error = "Failed To Create Plan! Please Try Again.";
            }

            // Close the database connection
            mysqli_close($connect);
        }
    ?>

    <!-- Add Plan form -->
    <div class="container rounded bg-black my-5 p-4 text-light" style="width: 480px;">
        <h3 class="border p-2 text-center">Give detail of the New <?php if($_SESSION['plan_type']=="residential_plans"){echo 'Residential';} else if ($_SESSION['plan_type'] == "organizational_plans"){echo 'Organizational';}?> Plan</h3>
        <form action="plans_add.php" method="post">
            <div class="mb-3">
                <label for="plan_name" class="form-label">Plan Name</label>
                <input type="text" name="plan_name" class="form-control" id="plan_name" placeholder="Plan Name Here" required>
            </div>
            <div class="mb-3">
                <label for="plan_speed" class="form-label">Speed</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="plan_speed" name="plan_speed" placeholder="Speed In Mbps" required>
                    <span class="input-group-text">Mbps</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="plan_price" class="form-label">Price</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="plan_price" name="plan_price" placeholder="Price In TK" required>
                    <span class="input-group-text">TK/Month</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="plan_realip" class="form-label">Real-Ip (Yes/No)</label>
                <input type="text" name="plan_realip" class="form-control" id="plan_realip" placeholder="Is The Plan Have Real-Ip (Yes/No)" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button>
                <a href="plans_admin.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i> Cancel</a>
            </div>
        </form>
        <h5 class="text-danger"><?php echo $error;?></h5>
    </div>
</body>
</html>