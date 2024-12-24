    <!-- Navbar Satrat -->
    <nav class="navbar navbar-expand-md bg-dark sticky-top" data-bs-theme="dark">
        <div class="container-fluid d-flex justify-content-between">

            <!-- Toggler button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-links" aria-controls="nav-links" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-list-ul"></i>
            </button>

            <!-- Page Name -->
            <a class="navbar-brand text-uppercase" href="about.php"><?php echo $page_name;?></a>

            <!-- Nav Icons -->
            <div class="nav-icon">
                <!-- <a class="navbar-brand px-3" href="customer_notification.php" title="Notification"><i class="fa-regular fa-bell nav-icon"></i></a> -->
                <a class="navbar-brand px-3" href="admin_info.php" title="Profile"><i class="fa-regular fa-user nav-icon"></i></a>
                <a class="navbar-brand px-3" href="logout.php" title="Logout"><i class="fa-solid fa-right-from-bracket nav-icon"></i></a>
            </div>

            <!-- Navbar-links -->
            <div class="collapse navbar-collapse" id="nav-links">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  <?php if($page_type == "home"){echo "op-ac";}?>" aria-current="page" href="dash_customer.php">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  <?php if($page_type == "new_cnonnection"){echo "op-ac";}?>" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            New Connection
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><form method="post"><button class="dropdown-item" type="submit" name="residential_plans">
                                <i class="fa-solid fa-house"></i>
                                Residential
                            </button></form></li>
                            <li><form method="post"><button class="dropdown-item" type="submit" name="organizational_plans">
                                <i class="fa-solid fa-briefcase"></i>
                                Organizational
                            </button></form></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form method="post"><button class="dropdown-item disabled" type="submit" name="">
                                <i class="fa-solid fa-gears"></i>
                                Custom Plan
                            </button></form></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  <?php if($page_type == "payment"){echo "op-ac";}?>" href="pament.php">Payment</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  <?php if($page_type == "customer_complaint"){echo "opac";}?>" href="customer_complaint.php">Complaint</a>
                    </li>
                </ul>
            </div>


        </div>
    </nav>
    <!-- NavBar End -->

    <?php
        //Plans Rederection PHP
        if(isset($_POST['residential_plans'])){
            $_SESSION['plan_type'] = "residential_plans";
            if(isset($_SESSION['plan_id'])) unset($_SESSION['plan_id']);
            echo "<script> window.location.href='plans_customer.php';</script>";
            die();
        } else if(isset($_POST['organizational_plans'])){
            $_SESSION['plan_type'] = "organizational_plans";
            if(isset($_SESSION['plan_id'])) unset($_SESSION['plan_id']);
            echo "<script> window.location.href='plans_customer.php';</script>";
            die();
        }
    ?>