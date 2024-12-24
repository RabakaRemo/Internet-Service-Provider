
    <!-- Navbar Satrat -->
    <nav class="navbar bg-dark sticky-top" data-bs-theme="dark">
        <div class="container-fluid d-flex justify-content-between">

            <!-- Button to open Sidebar -->
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#dashboard-sidebar" aria-controls="dashboard-sidebar" title="Dashboard">
                <i class="fa-solid fa-angles-right"></i>
            </button>

            <!-- Page Name -->
            <a class="navbar-brand text-uppercase" href="about.php"><?php echo $page_name;?></a>

            <!-- Nab Icon -->
            <div class="nav-icon">
                <a class="navbar-brand px-3" href="customer_notification.php" title="Notification"><i class="fa-regular fa-bell nav-icon"></i></a>
                <a class="navbar-brand px-3" href="admin_info.php" title="Profile"><i class="fa-regular fa-user nav-icon"></i></a>
                <a class="navbar-brand px-3" href="logout.php" title="Logout"><i class="fa-solid fa-right-from-bracket nav-icon"></i></a>
            </div>
        </div>
    </nav>
    <!-- NavBar End -->


    <!-- Sidebar/offcanvas start -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="dashboard-sidebar" aria-labelledby="dashboard-head">
    
        <!-- Sidebar Header -->
        <div class="offcanvas-header ms-2">
            <h3 class="offcanvas-title font-weight-bolder text-uppercase" id="dashboard-head">
                <?php
                    if($page_type == "dashboard"){ echo '<i class="fa-solid fa-gauge"></i> Dashboard'; }
                    else if($page_type == "customers"){ echo '<i class="fa-solid fa-people-line"></i> Customers'; }
                    else if($page_type == "requests"){ echo '<i class="fa-regular fa-hand"></i> Requests'; }
                    else if($page_type == "plans"){ echo '<i class="fa-solid fa-clipboard-list"></i> Plans'; }
                    else if($page_type == "customers_list"){ echo '<i class="fa-solid fa-circle-nodes"></i> Connections'; }
                    else if($page_type == "reports"){ echo '<i class="fa-regular fa-flag"></i> Reports'; }
                    else if($page_type == "manage_employee"){ echo '<i class="fa-solid fa-users-gear"></i> Manage Employee'; }
                    else if($page_type == "complains"){ echo '<i class="fa-solid fa-not-equal"></i> Complaints'; }
                    else if($page_type == "customer_output_control"){ echo '<i class="fa-solid fa-gauge"></i> Dashboard'; }
                ?>
            </h3>
            <button type="button" class="btn btn-dark position-absolute top-0 end-0 m-2 text-light" data-bs-dismiss="offcanvas" title="Close"><i class="fa-solid fa-angles-left"></i> </button>
        </div>
        
        <!-- slide bar boddy -->
        <div class="offcanvas-body ms-2">
        
            <div class="offcanvas-options fs-5">
                <ul class="list-unstyled">
                    <li>
                        <a class="dropdown-item rounded p-2 <?php if($page_type == "home"){echo "op-ac";}?>" href="dash_admin.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                    </li>

                    <li>
                        <a class="dropdown-item rounded p-2  <?php if($page_type == "customers_list"){echo "op-ac";}?>" href="customer_list.php"><i class="fa-solid fa-people-line"></i> Customers</a>
                    </li>

                    <li class="dropdown">
                        <span class="dropdown-toggle dropdown-item rounded p-2 <?php if($page_type == "requests"){echo "op-ac";}?>" id="requests" data-bs-toggle="dropdown">
                            <i class="fa-regular fa-hand"></i> Requests
                        </span>
                        <form method="post">
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="requests">
                                <li><button class="dropdown-item rounded p-2" type="
                                submit" name="new_connections">
                                    <i class="fa-solid fa-plus"></i> New Connections
                                </button></li>
                                <li><button class="dropdown-item rounded p-2" type="
                                submit" name="update_coneections">
                                    <i class="fa-solid fa-circle-up"></i> Update Requests
                                </button></li>
                                <li><button class="dropdown-item rounded p-2" type="
                                submit" name="delete_connections">
                                    <i class="fa-solid fa-trash-can"></i> Delete Requests
                                </button></li>
                            </ul>
                        </form>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle dropdown-item rounded p-2 <?php if($page_type == "plans"){echo "op-ac";}?>" id="plans" data-bs-toggle="dropdown"><i class="fa-solid fa-clipboard-list"></i> Plans</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="plans">
                            <li><form method="post"><button class="dropdown-item rounded p-2" type="submit" name="residential_plans">
                                <i class="fa-solid fa-house-laptop"></i> 
                                Residential Plans
                            </button></form></li>
                            <li><form method="post"><button class="dropdown-item rounded p-2" type="submit" name="organizational_plans">
                                <i class="fa-solid fa-building"></i> 
                                Organizational plans
                            </button></form></li>
                        </ul>
                    </li>

                    <li>
                        <a class="dropdown-item rounded p-2 <?php if($page_type == "connections"){echo "op-ac";}?>" href="connections_admin.php"><i class="fa-solid fa-circle-nodes"></i> Connections</a>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle dropdown-item rounded p-2 <?php if($page_type == "reports"){echo "op-ac";}?>" id="reports" data-bs-toggle="dropdown">
                            <i class="fa-regular fa-flag"></i> Reports
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="reports">
                            <li><a class="dropdown-item rounded p-2" href="payment_reports.php">
                                <i class="fa-solid fa-house"></i> 
                                Payment Reports
                            </a></li>
                            <li><a class="dropdown-item rounded p-2" href="task_reports.php">
                                <i class="fa-solid fa-briefcase"></i> 
                                Task Reports
                            </a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="dropdown-item rounded p-2 <?php if($page_type == "manage_employee"){echo "op-ac";}?>" href="employee.php"><i class="fa-solid fa-users-gear"></i> Manage Employee</a>
                    </li>

                    <li>
                        <a class="dropdown-item rounded p-2  <?php if($page_type == "complaints"){echo "op-ac";}?>" href="customer_complaints.php"><i class="fa-solid fa-not-equal"></i> Complaints</a>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle dropdown-item rounded p-2 disabled <?php if($page_type == "cu_out_con"){echo "op-ac";}?>" id="customer" data-bs-toggle="dropdown"><i class="fa-solid fa-clipboard-list"></i> Customer view Control</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="customer">
                            <li><form method="post"><button class="dropdown-item rounded p-2" type="submit" name="residential_plans">
                                <i class="fa-solid fa-house-laptop"></i> 
                                Navbar Control
                            </button></form></li>
                            <li><form method="post"><button class="dropdown-item rounded p-2" type="submit" name="organizational_plans">
                                <i class="fa-solid fa-building"></i> 
                                Carosoule Control
                            </button></form></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Sidebar/Offcanvas -->


    <?php
        //Plans Rederection PHP
        if(isset($_POST['residential_plans'])){
            //Clear extra Seasion variable
            require '_clear_session_variable.php';

            $_SESSION['plan_type'] = "residential_plans";
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        } else if(isset($_POST['organizational_plans'])){
            //Clear extra Seasion variable
            require '_clear_session_variable.php';

            $_SESSION['plan_type'] = "organizational_plans";
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        }

        //Requests Rederections
        else if(isset($_POST['new_connections'])){
            $_SESSION['show'] = "new_connections";
            echo "<script> window.location.href='requests.php';</script>";
            die();
        }else if(isset($_POST['update_coneections'])){
            $_SESSION['show'] = "update_coneections";
            echo "<script> window.location.href='requests.php';</script>";
            die();
        }else if(isset($_POST['delete_connections'])){
            $_SESSION['show'] = "delete_connections";
            echo "<script> window.location.href='requests.php';</script>";
            die();
        }
    ?>