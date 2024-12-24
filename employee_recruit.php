<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruit Employee</title>
    <!-- Links Start -->
    <?php include '_link_common.php'; ?>

    <!-- Link End -->

</head>
<body>
    <?php
        // Login check
        require '_logincheck_admin.php';
            
        //Defining Page Type
        $page_type = "employee";
        $page_name = "recruit employee";

        // Navbar
        require '_nav_admin.php';

        //variables
        $phone_error = "";
        $email_error = "";
        $nid_number_error = "";
        $post_error = "";
        $nid_file_error = "";
        $certificate_file_error = "";
        $resume_file_error = "";
        $photo_file_error = "";
        $submition_error = "";
        $data_submit_error = false;

        if (isset($_POST['recruit'])){
            // connect to the database
            require '_database_connect.php';

            $name = $_POST["name"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $gender = $_POST["gender"];
            $post = $_POST["post"];
            $salary = $_POST["salary"];
            $nid_number= $_POST["nid-number"];
            $temp_pass= $_POST["temp-pass"];

            //chack duplicate phone number
            $phone_chack_sql = "SELECT * FROM `employee` WHERE `phone` = '$phone'";
            $phone_chack = mysqli_query($connect, $phone_chack_sql);
            $num_phone = mysqli_num_rows($phone_chack);
            if ($num_phone>0){
                $phone_error = "The phone number already exist";
                $data_submit_error = true;
            }

            //chack duplicate email
            $email_chack_sql = "SELECT * FROM `employee` WHERE `email` = '$email'";
            $email_chack = mysqli_query($connect, $email_chack_sql);
            $num_email = mysqli_num_rows($email_chack);
            if ($num_email>0){
                $email_error = "The Email already exist";
                $data_submit_error = true;
            }

            //chack duplicate NID
            $nid_number_chack_sql = "SELECT * FROM `employee` WHERE `nid` = '$nid_number'";
            $nid_number_chack = mysqli_query($connect, $nid_number_chack_sql);
            $num_nid_number = mysqli_num_rows($nid_number_chack);
            if ($num_nid_number>0){
                $nid_number_error = "The NID already exist";
                $data_submit_error = true;
            }

            //Allowed document file types and maximum file size
            $doc_file_allowed_type = "pdf";
            $doc_file_max_size = 5 * 1048576;

            //Valid Nid File
            // Get file details
            $nid_file_name = $_FILES['nid-file']['name'];
            $nid_file_size = $_FILES['nid-file']['size'];
            $nid_file_type = strtolower(pathinfo($nid_file_name, PATHINFO_EXTENSION));
            // Check file type
            if ($doc_file_allowed_type != $nid_file_type) {
                $nid_file_error = "Only pdf files are allowed.";
                $data_submit_error = true;
            }
            // Check file size
            if ($doc_file_max_size <= $nid_file_size) {
                $nid_file_error = "File size exceeds the maximum limit of 5MB.";
                $data_submit_error = true;
            }

            //Valid Certificate File
            // Get file details
            $certificate_file_name = $_FILES['certificate-file']['name'];
            $certificate_file_size = $_FILES['certificate-file']['size'];
            $certificate_file_type = strtolower(pathinfo($certificate_file_name, PATHINFO_EXTENSION));
            // Check file type
            if ($doc_file_allowed_type != $certificate_file_type) {
                $certificate_file_error = "Only pdf files are allowed.";
                $data_submit_error = true;
            }
            // Check file size
            if ($doc_file_max_size <= $certificate_file_size) {
                $certificate_file_error = "File size exceeds the maximum limit of 5MB.";
                $data_submit_error = true;
            }

            //Valid resume File
            // Get file details
            $resume_file_name = $_FILES['resume-file']['name'];
            $resume_file_size = $_FILES['resume-file']['size'];
            $resume_file_type = strtolower(pathinfo($resume_file_name, PATHINFO_EXTENSION));
            // Check file type
            if ($doc_file_allowed_type != $resume_file_type) {
                $resume_file_error = "Only pdf files are allowed.";
                $data_submit_error = true;
            }
            // Check file size
            if ($doc_file_max_size <= $resume_file_size) {
                $resume_file_error = "File size exceeds the maximum limit of 5MB.";
                $data_submit_error = true;
            }

            //Photo file Error
            //Allowed photo file types and maximum file size
            $photo_file_allowed_type = array("jpg", "jpeg", "png");
            $photo_file_max_size = 2 * 1048576;
            // Get file details
            $photo_file_name = $_FILES['photo-file']['name'];
            $photo_file_size = $_FILES['photo-file']['size'];
            $photo_file_type = strtolower(pathinfo($photo_file_name, PATHINFO_EXTENSION));
            // Check file type
            if (!in_array($photo_file_type, $photo_file_allowed_type)) {
                $photo_file_error = "Only JPG, JPEG, and PNG files are allowed.";
                $data_submit_error = true;
            }
            // Check file size
            if ($photo_file_max_size <= $photo_file_size) {
                $photo_file_error = "File size exceeds the maximum limit of 2MB.";
                $data_submit_error = true;
            }
            //if no error ---> Submit
            if (!$data_submit_error){
                //employee in data base
                //Info insart SQL
                $info_sql = "INSERT INTO `employee` (`name`, `post`, `salary`, `address`, `nid`, `email`, `phone`, `gender`, `password`) VALUES ('{$name}', '{$post}', '{$salary}', '{$address}', '{$nid_number}', '{$email}', '{$phone}', '{$gender}', '{$temp_pass}')";
                $info_insart = mysqli_query($connect, $info_sql);

                //If insart complite get the employee id, move the files, insart file locations
                if($info_insart){
                    //getemployee id
                    $get_employee_id_sql = "SELECT `id` FROM `employee` WHERE `phone` = '{$phone}' AND `email` = '{$email}' AND `nid` = '{$nid_number}'";
                    $get_employee_id = mysqli_query($connect, $get_employee_id_sql);
                    $employee_id = mysqli_fetch_assoc($get_employee_id);
                    $employee_id = $employee_id["id"];

                    //Move File to the folder
                    $nid_folder = "files/employee/nid_file";
                    $certificate_folder = "files/employee/certificate_file";
                    $resume_folder = "files/employee/resume_file";
                    $photo_folder = "files/employee/profile_pic_file";

                    //File location
                    $nid_file_location =$nid_folder . "/" . $employee_id . "_nid.pdf";
                    $certificate_file_location =$certificate_folder . "/" . $employee_id . "_certificate.pdf";
                    $resume_file_location =$resume_folder . "/" . $employee_id . "_resume.pdf";
                    $photo_file_location =$photo_folder . "/" . $employee_id . "_photo." . $photo_file_type;

                    //temporary file name to store file
                    $nid_tamp_name = $_FILES["nid-file"]["tmp_name"];
                    $certificate_tamp_name = $_FILES["certificate-file"]["tmp_name"];
                    $resume_tamp_name = $_FILES["resume-file"]["tmp_name"];
                    $photo_tamp_name = $_FILES["photo-file"]["tmp_name"];
                    
                    //Move the file to the folder And Chack for the error
                    if(!move_uploaded_file($nid_tamp_name, $nid_file_location)){
                        $nid_file_error = "Faild To Uplode The File";
                        $data_submit_error = true;
                    }
                    if(!move_uploaded_file($certificate_tamp_name, $certificate_file_location)){
                        $certificate_file_error = "Faild To Uplode The File";
                        $data_submit_error = true;
                    }
                    if(!move_uploaded_file($resume_tamp_name, $resume_file_location)){
                        $resume_file_error = "Faild To Uplode The File";
                        $data_submit_error = true;
                    }
                    if(!move_uploaded_file($photo_tamp_name, $photo_file_location)){
                        $photo_file_error = "Faild To Uplode The File";                $data_submit_error = true;
                    }

                    //Insart Fil Locations
                    if(!$data_submit_error){
                        $insart_file_location_sql = "UPDATE `employee` SET `photo_file` = '{$photo_file_location}', `nid_file` = '{$nid_file_location}', `certificate_file` = '{$certificate_file_location}', `resume_file` = '{$resume_file_location}' WHERE `id` = '{$employee_id}';";
                        echo var_dump($employee_id);
                        $insart_file_location = mysqli_query($connect, $insart_file_location_sql);
                        echo var_dump($insart_file_location);

                        //Tarmination and Redirection
                        if($insart_file_location){       
                            // Rederection for employee page
                            echo "<script> window.location.href='employee.php';</script>";
                            // Close the database connection
                            mysqli_close($connect);
                            die();
                        }
                    }  else {
                        $delete_employee_info_sql = "DELETE FROM `employee` WHERE `employee`.`id` = '{$employee_id}';";
                        $delete_employee_info = mysqli_query($connect, $delete_employee_info_sql);
                        $submition_error = "File Insartaion Faild";
                    }
                } else $submition_error = "Data Insartaion Faild";
            }

            // Close the database connection
            mysqli_close($connect);
        }
    ?>

    <!-- Add Employee form -->
    <div class="container rounded bg-black my-3 p-4 text-light form_con" style="width: 480px;">
        <h3 class="border p-2 text-center mb-4">Give detail of the New Employee</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="e-name" class="form-label">Employee Name</label>
                <input type="text" name="name" <?php if(isset($name)) echo "value='$name'"; ?> class="form-control" id="name" placeholder="Employee Name Here" required>
            </div>
            <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control" id="Address" name="address" <?php if(isset($address)) echo "value='$address'"; ?> placeholder="Address" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" <?php if(isset($phone)) echo "value='$phone'"; ?> placeholder="Phone Number" required>
                <p class="text-danger"><?php echo $phone_error;?></p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" <?php if(isset($email)) echo "value='$email'"; ?> placeholder="Email Address" required>
                <p class="text-danger"><?php echo $email_error;?></p>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="male" id="gender-male" <?php if(isset($gender) && $gender=="male") echo "checked"; else if(isset($gender)) echo ""; else echo "checked"; ?>>
                    <label class="form-check-label form-label" for="male">Male</label>
                </div>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="female" id="gender-female" <?php if(isset($gender) && $gender=="female") echo "checked"; ?>>
                    <label class="form-check-label form-label" for="Female">Female</label>
                </div>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="other" id="gender-other" <?php if(isset($gender) && $gender=="other") echo "checked"; ?>>
                    <label class="form-check-label form-label" for="Female">Other</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="nid" class="form-label">Post</label>
                <select class="search-select form-control" name="post">
                    <option value="" <?php if(isset($post) && $post=="") echo "selected"; else if(isset($post)) echo ""; else echo "selected"; ?>>Select Post</option>
                    <option value="Manager" <?php if(isset($post) && $post=="Manager") echo "selected"; ?>>Manager</option>
                    <option value="Assistant Manager" <?php if(isset($post) && $post=="Assistant Manager") echo "selected"; ?>>Assitant Manager</option>
                    <option value="Sarver Oparator" <?php if(isset($post) && $post=="Sarver Oparator") echo "selected"; ?>>Sarver Oparator</option>
                    <option value="Line Man" <?php if(isset($post) && $post=="Line Man") echo "selected"; ?>>Line Man</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nid" class="form-label">Salary/Month</label>
                <div class="input-group">
                    <input type="number" name="salary" class="form-control" id="salary" <?php if(isset($salary)) echo "value='$salary'"; ?> placeholder="Salary" required>
                    <label class="input-group-text">Tk/Month</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="nid" class="form-label">NID Number</label>
                <input type="number" name="nid-number" class="form-control" id="nid-number" <?php if(isset($nid_number)) echo "value='$nid_number'"; ?> placeholder="NID" required>
                <p class="text-danger"><?php echo $nid_number_error;?></p>
            </div>
            <div class="mb-3">
                <label for="nid-file" class="form-label">NID File</label>
                <input type="file" name="nid-file" class="form-control" id="nid-file" required>
                <p class="text-danger"><?php echo $nid_file_error;?></p>
            </div>
            <div class="mb-3">
                <label for="certificate-file" class="form-label">Certificate File</label>
                <input type="file" name="certificate-file" class="form-control" id="certificate-file" required>
                <p class="text-danger"><?php echo $certificate_file_error;?></p>
            </div>
            <div class="mb-3">
                <label for="resume-file" class="form-label">Resume File</label>
                <input type="file" name="resume-file" class="form-control" id="resume-file" required>
                <p class="text-danger"><?php echo $resume_file_error;?></p>
            </div>
            <div class="mb-3">
                <label for="photo-file" class="form-label">Photo</label>
                <input type="file" name="photo-file" class="form-control" id="photo-file" required>
                <p class="text-danger"><?php echo $photo_file_error;?></p>
            </div>
            <div class="mb-3">
                <label for="temp-pass" class="form-label">Temporary Password</label>
                <input type="text" name="temp-pass" class="form-control" id="temp-pass" <?php if(isset($temp_pass)) echo "value='$temp_pass'"; ?> placeholder="Temporary Password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-success" name="recruit"><i class="fa-solid fa-plus"></i> Recruit</button>
                <a href="employee.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i> Cancel</a>
            </div>
            <p class="text-danger"><?php echo $submition_error ?></p>
        </form>
    </div>
</body>
</html>