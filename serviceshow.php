<?php
define('MYSITE', true);
include 'DataBase/dbconnect.php';

$title = 'Main';
$css_directory = 'css/main.min.css';
$css_directory2 = 'css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';

// Initialize filter parameters at the top to avoid undefined variable warnings
$filter_city = isset($_GET['filter_city']) ? (int)$_GET['filter_city'] : 0;
$filter_area = isset($_GET['filter_area']) ? (int)$_GET['filter_area'] : 0;
?>

<style>
    .card:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        transform: translateY(-5px);
        background-color: #0A2647;
        color: white;
    }

    .showcategoryimg {
        background-image: url('img/services/service_14.jpg');
        object-fit: cover;
        background-repeat: no-repeat;
        background-size: cover;
        opacity: 0.5;
    }

    /* for sticky footer */
    .sticky {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        bottom: 60px;
        width: 100%;
        z-index: 1;
    }

    @media (min-width: 576px) {
        .sticky {
            left: auto;
            right: 0;
            width: auto;
            position: fixed;
            /* Keep it fixed on desktop too? Or relative */
        }
    }
</style>

<body>
    <?php
    //fetch category name from index.php
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $sql = "SELECT * FROM `category` WHERE category_id = $category_id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];
            }
        }
    } else {
        // if anyone directly enter url then else part run
        echo "<script>
        window.location.href='index.php';
        </script>";
    }
    ?>

    <!-- ===landing page image Start=== -->
    <div class="jumbotron jumbotron-fluid bg-c1-4 mb-0">
        <div class="container">
            <h1 class="display-4"><b><?php echo $category_name ?></b></h1>
            <!-- <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p> -->
        </div>
    </div>
    <div class="bg-white border-bottom shadow-sm">
        <div class="container mb-3 py-3">
            <div class="d-flex flex-wrap align-items-center mb-3">
                <?php
                //fetch service name
                $sql = "SELECT * FROM `service` WHERE category_id = $category_id";
                $result = mysqli_query($conn, $sql);
                $numexist = mysqli_num_rows($result);
                if ($numexist > 0) {
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $service_id = $row['service_id'];
                            $service_name = $row['service_name'];
                            ?>
                            <a href="serviceshow.php?serviceid=<?php echo $service_id ?>"><button type="button"
                                    class="btn btn-outline-c1-1 btn-sm mr-2 mb-2"><?php echo $service_name ?></button></a>
                            <?php
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">No services under ' . $category_name . '</div>';
                }
                ?>
            </div>

            <!-- Location Filter Bar -->
            <div class="card bg-light border-0">
                <div class="card-body py-2">
                    <form action="serviceshow.php" method="get" class="form-row align-items-end">
                        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                        
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="small font-weight-bold mb-1"><i class="fas fa-city mr-1"></i>City</label>
                            <select class="form-control form-control-sm" name="filter_city" id="filter_city">
                                <option value="0">All Cities</option>
                                <?php
                                $city_sql = "SELECT * FROM city";
                                $city_res = mysqli_query($conn, $city_sql);
                                while($crow = mysqli_fetch_assoc($city_res)) {
                                    $selected = ($filter_city == $crow['city_id']) ? 'selected' : '';
                                    echo '<option value="'.$crow['city_id'].'" '.$selected.'>'.$crow['city_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="small font-weight-bold mb-1"><i class="fas fa-map-marker-alt mr-1"></i>Area</label>
                            <select class="form-control form-control-sm" name="filter_area" id="filter_area">
                                <option value="0">All Areas</option>
                                <?php
                                if ($filter_city > 0) {
                                    $area_sql = "SELECT * FROM area WHERE city_id = $filter_city";
                                    $area_res = mysqli_query($conn, $area_sql);
                                    while($arow = mysqli_fetch_assoc($area_res)) {
                                        $selected = ($filter_area == $arow['area_id']) ? 'selected' : '';
                                        echo '<option value="'.$arow['area_id'].'" '.$selected.'>'.$arow['area_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-c1-1 btn-sm flex-grow-1 mr-2">Apply Filter</button>
                            <?php if($filter_city > 0 || $filter_area > 0): ?>
                                <a href="serviceshow.php?category_id=<?php echo $category_id; ?>" class="btn btn-outline-secondary btn-sm">Clear</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ===landing page image End=== -->



    <!-- ===Service provider gig show page image Start=== -->
    <div class="container">

        <div class="row">
            <!-- ===Left side main page Start=== -->
            <div class="col-12 col-md-8">
                <div class="">
                    <?php
                    // Build query with filters
                    $fetchspgig = "SELECT sp_service.* FROM `sp_service` 
                                  JOIN `sp` ON sp_service.sp_id = sp.sp_id 
                                  WHERE sp_service.category_id = $category_id";
                    
                    if ($filter_city > 0) {
                        $fetchspgig .= " AND sp.city_id = $filter_city";
                    }
                    if ($filter_area > 0) {
                        $fetchspgig .= " AND sp.area_id = $filter_area";
                    }
                    
                    $fetchspgig .= " ORDER BY sp_service.price ASC";

                    $gigresult = mysqli_query($conn, $fetchspgig);
                    if (mysqli_num_rows($gigresult) == 0) {
                        echo '<div class="alert alert-info m-4">No services found for the selected location.</div>';
                    }

                    while ($gigrow = mysqli_fetch_assoc($gigresult)) {
                        $service_title = $gigrow['service_title'];
                        $category_id = $gigrow['category_id'];
                        $sp_id = $gigrow['sp_id'];
                        $price = $gigrow['price'];
                        $description = $gigrow['description'];
                        if ($gigrow['availability'] == 1) {
                            $availibility = "Yes";
                        } else {
                            $availibility = "No";
                        }

                        $spname_query = "SELECT sp.*, city.city_name, area.area_name 
                                       FROM `sp` 
                                       LEFT JOIN city ON sp.city_id = city.city_id 
                                       LEFT JOIN area ON sp.area_id = area.area_id 
                                       WHERE sp.sp_id = $sp_id";
                        $spname_result = mysqli_query($conn, $spname_query);
                        $sprow = mysqli_fetch_assoc($spname_result);
                        
                        $sp_name = $sprow['sp_name'];
                        $sp_city = $sprow['city_name'] ?? "Unknown City";
                        $sp_area = $sprow['area_name'] ?? $sprow['area'];

                        $service_id = $gigrow['service_id'];
                        $servicename = "SELECT * FROM `service` WHERE service_id = $service_id";
                        $servicename_result = mysqli_query($conn, $servicename);
                        while ($servicerow = mysqli_fetch_assoc($servicename_result)) {
                            $service_name = $servicerow['service_name'];
                        }
                        ?>

                        <!-- main card start -->
                        <form action="manage_cart.php" method="post">
                            <div class="media m-4 row">
                                <div class="media-body col-12 col-md-7">

                                    <span class="text-success"
                                        style="text-transform:uppercase;"><?php echo $service_name ?></span>
                                    <hr style="margin:2px;">
                                    <h5 class="mt-0"><?php
                                    echo $service_title;
                                    ?></h5>
                                    <h6>Service provider: <?php echo $sp_name; ?></h6>
                                    <h6><i class="fas fa-map-marker-alt text-danger"></i>
                                        <?php echo $sp_city . ", " . $sp_area; ?></h6>
                                    <h6 class="badge badge-success">4.4 <i class="fa-solid fa-star"></i></h6>
                                    <h6>Starts at <small>Rs. </small><?php echo $price ?>/-</h6>
                                    <hr style="margin-bottom: 5px;">
                                    <p class="text-break"
                                        style="overflow-wrap: break-word; word-wrap: break-word; hyphens: auto;">
                                        <?php echo $description ?>
                                    </p>
                                    <!-- <a href="" data-toggle="modal" data-target="#exampleModal"><b>View details</b> </a> -->

                                    <!--comment out start Modal -->
                                    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $service_name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Add details here </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                    <!--comment out enc modal end -->


                                    <!-- <div class="media mt-3">
                                <a class="mr-3" href="#">
                                    <img src="..." alt="...">
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">Media heading</h5>
                                    <p>Greetings loved ones lets take a journey. Yes, we make angels cry, raining down on earth from up above. Give you something good to celebrate. I used to bite my tongue and hold my breath. Im ma get your heart racing in my skin-tight jeans. As I march alone to a different beat. Summer after high school when we first met. Youre so hypnotizing, could you be the devil? Could you be an angel? It time to bring out the big balloons. Thought that I was the exception Bikinis, zucchinis, Martinis, no weenies</p>
                                </div>
                            </div> -->
                                </div>
                                <!-- <center>
                                <div class="">
                                    <img src="img/plumber.jpg" style="width:100px; height:100px; object-fit:cover;" class="mr-3" alt="..."><br>
                                    <a href="" class="btn btn-c1-1">Add to Cart</a>
                                </div>
                            </center> -->

                                <div class="col-12 col-md-5 text-center mt-3 mt-md-0" style="">
                                    <img src="img/<?php echo $category_id ?>.jpg"
                                        style="width:100px; height:100px;object-fit:cover; border-radius:10px"
                                        class="card-img-top" alt="...">
                                    <div class="card-body text-center">
                                        <button type="submit" name="add_to_cart" class="card-link btn btn-c1-1"
                                            style="border-radius:10px;">Add to Cart</button>
                                        <!-- category id pn moklvi pdi because jo category id bahar thi set thy ne nai aave to error batavse dynamic page che atle. -->
                                        <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
                                        <input type="hidden" name="service_id" value="<?php echo $service_id ?>">
                                        <input type="hidden" name="service_name" value="<?php echo $service_name ?>">
                                        <input type="hidden" name="service_title" value="<?php echo $service_title ?>">
                                        <input type="hidden" name="price" value="<?php echo $price ?>">
                                        <input type="hidden" name="sp_name" value="<?php echo $sp_name; ?>">
                                        <input type="hidden" name="sp_id" value="<?php echo $sp_id; ?>">
                                        <input type="hidden" name="sp_location"
                                            value="<?php echo $sp_city . ', ' . $sp_area; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <!-- main card end -->

                        <?php
                        //end while loop
                    }
                    ?>

                </div>
            </div>
            <!-- ===Left side main page End=== -->


            <!-- ===Right side main page Start=== -->
            <div class="col-sm-4 sticky">
                <div class="">
                    <!-- Message section -->
                    <?php
                    //Alert OR Error Message:
                    if (isset($_SESSION['status'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['status'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        unset($_SESSION['status']);
                    } elseif (isset($_SESSION['statusfail'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops! </strong> ' . $_SESSION['statusfail'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                        unset($_SESSION['statusfail']);
                    }
                    ?>

                    <div class="row justify-content-end" style="bottom: 80px; align-items:center; margin-right: 20px;">
                        <a href="mycart.php" class="card-link btn btn-c1-2 px-3 py-2 "><b>View Cart</b></a>
                    </div>
                </div>
            </div>
            <!-- ===Right side main page End=== -->
        </div>
    </div>
    <!-- ===Service provider gig show page image End=== -->





    <script>
        const filterCity = document.getElementById('filter_city');
        const filterArea = document.getElementById('filter_area');

        if (filterCity) {
            filterCity.addEventListener('change', async function () {
                const cityId = this.value;
                if (cityId == 0) {
                    filterArea.innerHTML = '<option value="0">All Areas</option>';
                    return;
                }
                const formData = new FormData();
                formData.append('city_id', cityId);
                const response = await fetch('assets/ajax/get_areas.php', {
                    method: 'POST',
                    body: formData
                });
                const html = await response.text();
                filterArea.innerHTML = '<option value="0">All Areas</option>' + html;
            });
        }
    </script>


    <?php
    include 'includes/footer.php';
    // include 'includes/navfooter.php';
    ?>