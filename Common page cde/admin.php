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
    <!-- Link End -->

</head>
<body>
<?php
    //Login check
    require '_logincheck_admin.php';
        
    //Defining Page
    $page_type = "";
    $page_name = "";
    
    //Navbar
    require '_nav_admin.php';
?>

Mid Code

</body>
</html>