<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';

$title = 'Services';
$css_directory = '../css/main.min.css';
$css_directory2 = '../css/main.min.css.map';
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
        background-image: url('../img/services/service_14.jpg');
        object-fit: cover;
        background-repeat: no-repeat;
        background-size: cover;
        opacity: 0.5;
    }

    /* for sticky footer */
    .sticky {
        position: fixed;
        bottom: 0;
        left: 860px;
        bottom: 10px;
        width: 100%;
        z-index: 1;
    }
</style>

<body>
    <?php
    //fetch category name from index.php
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $sql = "SELECT * FROM `category` WHERE category_id = $category_id";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];
            }
        } else {
            echo "<script>window.location.href='customer_index.php';</script>";
        }
    } else {
        // if anyone directly enter url then else part run
        echo "<script>window.location.href='customer_index.php';</script>";
    }
    ?>

    <!-- ===landing page image Start=== -->
    <div class="jumbotron jumbotron-fluid bg-c1-4 mb-0">
        <div class="container">
            <h1 class="display-4"><b><?php echo $category_name ?></b></h1>
        </div>
    </div>
<<<<<<< HEAD

    <div class="bg-white sticky-top shadow-sm">
        <div class="container mb-3 py-3">

            <!-- Filter Section -->
            <form method="GET" action="serviceshow.php" class="form-inline mb-3 justify-content-center">
                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

                <div class="form-group mr-2">
                    <select name="city_id" id="city_id" class="form-control" onchange="fetchAreas(this.value)">
                        <option value="">All Cities</option>
                        <?php
                        $city_sql = "SELECT * FROM city";
                        $city_res = mysqli_query($conn, $city_sql);
                        while ($c_row = mysqli_fetch_assoc($city_res)) {
                            $selected = (isset($_GET['city_id']) && $_GET['city_id'] == $c_row['city_id']) ? 'selected' : '';
                            echo "<option value='" . $c_row['city_id'] . "' $selected>" . $c_row['city_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mr-2 position-relative">
                    <input type="text" name="area_name" id="area_input" list="area_list" class="form-control"
                        placeholder="Type Area..." autocomplete="off"
                        value="<?php echo isset($_GET['area_name']) ? htmlspecialchars($_GET['area_name']) : ''; ?>">
                    <datalist id="area_list">
                        <!-- Filled via AJAX -->
                    </datalist>
                </div>

                <div class="form-group mr-2">
                    <select name="sort" class="form-control">
                        <option value="">Sort By</option>
                        <option value="price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc')
                            echo 'selected'; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_desc')
                            echo 'selected'; ?>>Price: High to Low</option>
                        <option value="rating" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'rating')
                            echo 'selected'; ?>>Highest Rated</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-c1-1">Filter</button>
                <a href="serviceshow.php?category_id=<?php echo $category_id; ?>"
                    class="btn btn-outline-secondary ml-2">Reset</a>
            </form>
            <!-- Filter Section End -->

            <div class="scrolling-wrapper row flex-row flex-nowrap mt-2 pb-2 pt-1" style="overflow-x: auto;">
                <?php
                //fetch service name for buttons
=======
    <div class="bg-white border-bottom shadow-sm">
        <div class="container mb-3 py-3">
            <div class="d-flex flex-wrap align-items-center mb-3">
                <?php
                //fetch service name
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
                $sql = "SELECT * FROM `service` WHERE category_id = $category_id";
                $result = mysqli_query($conn, $sql);
                $numexist = mysqli_num_rows($result);
                if ($numexist > 0) {
<<<<<<< HEAD
                    while ($row = mysqli_fetch_assoc($result)) {
                        $s_id_btn = $row['service_id'];
                        $s_name_btn = $row['service_name'];
                        // Added category_id to the link so it doesn't break
                        ?>
                        <div class="col-auto">
                            <a href="serviceshow.php?category_id=<?php echo $category_id; ?>&serviceid=<?php echo $s_id_btn ?>"><button
                                    type="button" class="btn btn-outline-c1-1"><?php echo $s_name_btn ?></button></a>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="alert alert-danger col-12" role="alert">No Services under ' . $category_name . '</div>';
=======
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
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
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
                                    $selected = ($filter_city == ($crow['city_id'] ?? '')) ? 'selected' : '';
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
                                        $selected = ($filter_area == ($arow['area_id'] ?? '')) ? 'selected' : '';
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

    <!-- ===Service provider gig show page image Start=== -->
    <div class="container mt-4">

        <div class="row">
            <!-- ===Left side main page Start=== -->
            <div class="col-sm-8">
                <div class="">
                    <?php
<<<<<<< HEAD
                    // Build Query for SP Gigs
                    $query = "SELECT ss.*, s.sp_name, s.area AS sp_area_text,
                              se.service_name,
                              c.city_name,
                              a.area_name,
                              (SELECT AVG(rating) FROM reviews r WHERE r.sp_id = ss.sp_id) as avg_rating
                              FROM sp_service ss
                              JOIN sp s ON ss.sp_id = s.sp_id
                              JOIN service se ON ss.service_id = se.service_id
                              LEFT JOIN city c ON s.city_id = c.city_id
                              LEFT JOIN area a ON s.area_id = a.area_id
                              WHERE ss.category_id = $category_id";

                    // Apply Filters
                    if (isset($_GET['city_id']) && !empty($_GET['city_id'])) {
                        $f_city = $_GET['city_id'];
                        $query .= " AND s.city_id = $f_city";
                    }
                    if (isset($_GET['area_name']) && !empty($_GET['area_name'])) {
                        $f_area_name = mysqli_real_escape_string($conn, $_GET['area_name']);
                        // Filter by exact name in Area table (via ID) OR substring match in SP's area text column
                        // Logic: IF SP has area_id set, it matches. IF SP has area text set, it matches.
                        $query .= " AND (
                                        s.area LIKE '%$f_area_name%' 
                                        OR s.area_id IN (SELECT area_id FROM area WHERE area_name LIKE '%$f_area_name%')
                                    )";
                    }
                    if (isset($_GET['serviceid']) && !empty($_GET['serviceid'])) {
                        $f_service = $_GET['serviceid'];
                        $query .= " AND ss.service_id = $f_service";
                    }

                    // Apply Sorting
                    if (isset($_GET['sort'])) {
                        $sort = $_GET['sort'];
                        if ($sort == 'price_asc') {
                            $query .= " ORDER BY CAST(ss.price AS UNSIGNED) ASC";
                        } elseif ($sort == 'price_desc') {
                            $query .= " ORDER BY CAST(ss.price AS UNSIGNED) DESC";
                        } elseif ($sort == 'rating') {
                            $query .= " ORDER BY avg_rating DESC";
=======
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
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
                        }
                    }

<<<<<<< HEAD
                    $gigresult = mysqli_query($conn, $query);

                    // Fallback if no result or error
                    if (!$gigresult) {
                        echo '<div class="alert alert-warning">No results found or error in query.</div>';
                    } else if (mysqli_num_rows($gigresult) == 0) {
                        echo '<div class="alert alert-info">No service providers found for your criteria.</div>';
                    } else {
=======
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
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)

                        while ($gigrow = mysqli_fetch_assoc($gigresult)) {
                            $service_title = $gigrow['service_title'];
                            $current_category_id = $gigrow['category_id'];
                            $sp_id = $gigrow['sp_id'];
                            $price = $gigrow['price'];
                            $description = $gigrow['description'];
                            $sp_name = $gigrow['sp_name'];
                            $service_name = $gigrow['service_name'];
                            $service_id = $gigrow['service_id'];
                            
                            // Location Logic
                            $city_name = $gigrow['city_name'];
                            $area_name = $gigrow['area_name'];
                            $sp_area_text = $gigrow['sp_area_text'];
                            
                            $display_location = $city_name;
                            if(!empty($area_name)){
                                $display_location = $area_name . ", " . $city_name;
                            } elseif(!empty($sp_area_text)){
                                $display_location = $sp_area_text . ", " . $city_name;
                            }

                            $avg_rating = $gigrow['avg_rating'];
                            $display_rating = $avg_rating ? number_format($avg_rating, 1) : 'New';

                            ?>

                                <!-- main card start -->
                                <form action="manage_cart.php" method="post">
                                    <div class="media m-4 border p-3 rounded shadow-sm bg-white">
                                        <div class="media-body col-7">

                                            <span class="text-success"
                                                style="text-transform:uppercase; font-weight:bold;"><?php echo $service_name ?></span>
                                            <hr style="margin:2px;">
                                            <h5 class="mt-2 font-weight-bold" style="color:#0A2647"><?php echo $service_title; ?>
                                            </h5>
                                            
                                            <div class="d-flex align-items-center flex-wrap mb-1">
                                                <h6 class="text-muted mb-0 mr-3"><i class="fas fa-user-circle"></i> <?php echo $sp_name; ?></h6>
                                                <small class="text-dark"><i class="fas fa-map-marker-alt text-danger"></i> <?php echo $display_location; ?></small>
                                            </div>

                                            <h6
                                                class="badge <?php echo ($display_rating === 'New') ? 'badge-info' : 'badge-warning'; ?>">
                                            <?php echo $display_rating; ?> <i class="fa-solid fa-star"></i>
                                            </h6>

                                            <h5 class="text-primary mt-2">Rs. <?php echo $price ?>/-</h5>

                                            <p class="text-secondary small mt-2"><?php echo $description ?></p>
                                        </div>

                                        <div class="ml-2 text-center" style="width:12rem;">
                                            <img src="../img/<?php echo $current_category_id ?>.jpg"
                                                style="width:100%; height:120px; object-fit:cover; border-radius:10px"
                                                class="card-img-top mb-2" alt="...">
                                            <div class="card-body text-center p-0">
                                                <button type="submit" name="add_to_cart" class="btn btn-block btn-c1-1"
                                                    style="border-radius:10px;">Add to Cart</button>
                                                <input type="hidden" name="category_id" value="<?php echo $current_category_id ?>">
                                                <input type="hidden" name="service_id" value="<?php echo $service_id ?>">
                                                <input type="hidden" name="service_name" value="<?php echo $service_name ?>">
                                                <input type="hidden" name="service_title" value="<?php echo $service_title ?>">
                                                <input type="hidden" name="price" value="<?php echo $price ?>">
                                                <input type="hidden" name="sp_name" value="<?php echo $sp_name; ?>">
                                                <input type="hidden" name="sp_id" value="<?php echo $sp_id; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- main card end -->

                            <?php
                        } // end while
                    }
                    ?>

                </div>
            </div>
            <!-- ===Left side main page End=== -->


            <!-- ===Right side main page Start=== -->
            <div class="col-sm-4 sticky d-none d-sm-block">
                <div class="">
                    <!-- Message section -->
                    <?php
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

<<<<<<< HEAD
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Your Cart</h5>
                            <p class="card-text">Ready to checkout?</p>
                            <a href="mycart.php" class="btn btn-c1-2 btn-block"><b>View Cart</b></a>
                        </div>
=======
                    <div class="row justify-content-around " style="bottom:0; align-items:center;">
                        <a href="mycart.php" class="card-link btn btn-c1-2 px-5 py-3 "><b>View Cart</b></a>
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
                    </div>
                </div>
            </div>
            <!-- ===Right side main page End=== -->
        </div>
    </div>
    <!-- ===Service provider gig show page image End=== -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Use jQuery for simplified AJAX
        function fetchAreas(cityId) {
            if (cityId) {
                $.ajax({
                    type: 'POST',
                    url: 'get_areas.php',
                    data: { city_id: cityId },
                    success: function (html) {
                        $('#area_list').html(html);
                        // Clear input when city changes
                        //$('#area_input').val(''); 
                    }
                });
            } else {
                $('#area_list').html('');
            }
        }

        // Retain Selected Area on Load (if exists)
        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var cityId = urlParams.get('city_id');
            // We only need to fetch datalist options if city is selected
            if (cityId) {
                $.ajax({
                    type: 'POST',
                    url: 'get_areas.php',
                    data: { city_id: cityId },
                    success: function (html) {
                        $('#area_list').html(html);
                    }
                });
            }
        });
    </script>

    <script>
<<<<<<< HEAD
        var grandtotal = document.getElementById('grandtotal');
        var myVariable = localStorage.getItem("myVar");
        if (grandtotal) grandtotal.innerText = myVariable;
=======
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
                const response = await fetch('../assets/ajax/get_areas.php', {
                    method: 'POST',
                    body: formData
                });
                const html = await response.text();
                filterArea.innerHTML = '<option value="0">All Areas</option>' + html;
            });
        }
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
    </script>

    <?php
    include '../includes/footer.php';
    ?>