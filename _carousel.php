    <!-- Carousel Slide Start -->
    <div id="top-carousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Selector Button -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#top-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#top-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>

        <!-- Img Slide -->
        <div class="carousel-inner">

            <div class="carousel-item carousel-slide active">
                <img src="images/carousel/index_slide1.jpg" class="d-block w-100 carousel-slide-img" alt="Check Out Our Services">
                <div class="carousel-caption text-uppercase top-0">
                    <h1 class="fw-bolder mt-lg-5 mt-2">Residential Services</h1>
                    <ul class="list-unstyled m-lg-3 m-md-2 m-sm-1">
                        <li class="m-2">High Speed Internet.</li>
                        <li class="m-2">Same Speed 24/7.</li>
                        <li class="m-2">Highly Responsive Customer Service.</li>
                    </ul>
                    <form method="post">
                        <button class="btn btn-hov m-1"  type="submit" name="residential_plans">See Plans</button>
                    </form>
                </div>
            </div>

            <div class="carousel-item carousel-slide">
                <img src="images/carousel/index_slide2.jpg" class="d-block w-100 carousel-slide-img" alt="Check Out Our Services">
                <div class="carousel-caption text-uppercase top-0">
                    <h1 class="fw-bolder mt-lg-5 mt-2">Organizational Services</h1>
                    <ul class="list-unstyled m-lg-3 m-md-2 m-sm-1">
                        <li class="m-2">High Speed Internet.</li>
                        <li class="m-2">real ip facility.</li>
                        <li class="m-2">Same Speed 24/7.</li>
                        <li class="m-2">Highly Responsive Customer Service.</li>
                    </ul>
                    <form method="post">
                        <button class="btn btn-hov m-1"  type="submit" name="organizational_plans">See Plans</button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Next And Preview button -->
        <button class="carousel-control-prev" type="button" data-bs-target="#top-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#top-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>
    <!-- Carousel Slide end -->

    <?php
        //Plans Rederection PHP
        if(isset($_POST['residential_plans'])){
            $_SESSION['plan_type'] = "residential_plans";
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        } else if(isset($_POST['organizational_plans'])){
            $_SESSION['plan_type'] = "organizational_plans";
            echo "<script> window.location.href='plans_admin.php';</script>";
            die();
        }
    ?>