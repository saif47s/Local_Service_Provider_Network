<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!defined('MYSITE')) {
    define('MYSITE', true);
}
if (!defined('MYSITE')) {
    header('location: ../../index.php');
    die();
}
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] != true) {
    header("location: ../index.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Meta Responsive tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">






    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!--Custom style.css-->
    <link rel="stylesheet" href="assets/css/quicksand.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <!--Animate CSS-->
    <link rel="stylesheet" href="assets/css/chartist.min.css">
    <!--Map-->
    <link rel="stylesheet" href="assets/css/jquery-jvectormap-2.0.2.css">
    <!--Bootstrap Calendar-->
    <link rel="stylesheet" href="assets/js/calendar/bootstrap_calendar.css">
    <!--Datatable-->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <!--JsGrid CSS-->
    <link rel="stylesheet" href="assets/css/jsgrid.min.css">
    <link rel="stylesheet" href="assets/css/jsgrid-theme.min.css">
    <!-- jquery cdn link for ajax removed to prevent double loading/conflicts with footer jquery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.3.js" ...></script> -->



    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <title>Hyper Local Service Provider Admin</title>
</head>







<body>
    <!--Page loader-->
    <div class="loader-wrapper">
        <div class="loader-circle">
            <div class="loader-wave"></div>
        </div>
    </div>
    <!--Page loader-->

    <!--Page Wrapper-->

    <div class="container-fluid">

        <!--Header-->
        <div class="row header shadow-sm">

            <!--Logo-->
            <div class="col-sm-3 pl-0 text-center header-logo">
                <div class="bg-theme mr-3 pt-3 pb-2 mb-0">
                    <h3 class="logo"><a href="../../../index.php" class="text-secondary logo">
                            <i class="fa fa-institution"></i>
                            <span class="small"><b>Hyper Local Service Provider</b> admin</span></a></h3>
                </div>
            </div>
            <!--Logo-->

            <!--Header Menu-->
            <div class="col-sm-9 header-menu pt-2 pb-0">
                <div class="row">

                    <!--Menu Icons-->
                    <div class="col-sm-4 col-8 pl-0">
                        <!--Toggle sidebar-->
                        <span class="menu-icon" onclick="toggle_sidebar()">
                            <span id="sidebar-toggle-btn"></span>
                        </span>
                        <!--Toggle sidebar-->
                    </div>
                    <!--Menu Icons-->


                    <!--Search box and avatar-->
                    <div class="col-sm-8 col-4 text-right flex-header-menu justify-content-end">

                        <!-- Notifications -->
                        <?php
                        // 1. Pending Service Providers
                        $sql_sp = "SELECT COUNT(*) as count FROM sp WHERE status = 'deactive'";
                        $res_sp = mysqli_query($conn, $sql_sp);
                        $row_sp = mysqli_fetch_assoc($res_sp);
                        $count_sp = $row_sp['count'];

                        // 2. Pending Wallet Requests
                        $sql_wallet = "SELECT COUNT(*) as count FROM wallet_transactions WHERE status = 'pending'";
                        $res_wallet = mysqli_query($conn, $sql_wallet);
                        $row_wallet = mysqli_fetch_assoc($res_wallet);
                        $count_wallet = $row_wallet['count'];

                        // 3. Activation Requests (Split)
                        // SP Requests (Role ID 2)
                        $sql_req_sp = "SELECT COUNT(*) as count FROM login WHERE activation_request = 1 AND role_id = 2";
                        $res_req_sp = mysqli_query($conn, $sql_req_sp);
                        $row_req_sp = mysqli_fetch_assoc($res_req_sp);
                        $count_req_sp = $row_req_sp['count'];

                        // Customer Requests (Role ID 3)
                        $sql_req_cust = "SELECT COUNT(*) as count FROM login WHERE activation_request = 1 AND role_id = 3";
                        $res_req_cust = mysqli_query($conn, $sql_req_cust);
                        $row_req_cust = mysqli_fetch_assoc($res_req_cust);
                        $count_req_cust = $row_req_cust['count'];

                        // 4. New Customer Reviews
                        $count_rev = 0;
                        $sql_rev = "SELECT COUNT(*) as count FROM customer_reviews WHERE is_read = 0";
                        // Suppress error if table doesn't exist to prevent crash
                        $res_rev = @mysqli_query($conn, $sql_rev);
                        if ($res_rev) {
                            $row_rev = mysqli_fetch_assoc($res_rev);
                            $count_rev = $row_rev['count'];
                        }

                        $total_notif = $count_sp + $count_wallet + $count_req_sp + $count_req_cust + $count_rev;
                        ?>

                        <div class="mr-4 position-relative">
                            <a class="" href="#" role="button" id="notifDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell text-secondary" style="font-size: 1.4rem;"></i>
                                <?php if ($total_notif > 0): ?>
                                    <span class="badge badge-danger rounded-circle"
                                        style="position: absolute; top: -5px; right: -5px; font-size: 0.6rem; padding: 4px 6px;"><?php echo $total_notif; ?></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mt-13 shadow border-0"
                                aria-labelledby="notifDropdown" style="min-width: 280px;">
                                <h6 class="dropdown-header text-uppercase font-weight-bold">Notifications</h6>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item d-flex justify-content-between align-items-center py-2"
                                    href="sp_view.php">
                                    <span><i class="fa fa-user-plus mr-2 text-primary"></i> New SP Approvals</span>
                                    <?php if ($count_sp > 0) {
                                        echo '<span class="badge badge-primary badge-pill">' . $count_sp . '</span>';
                                    } ?>
                                </a>

                                <a class="dropdown-item d-flex justify-content-between align-items-center py-2"
                                    href="wallet_requests.php">
                                    <span><i class="fa fa-wallet mr-2 text-info"></i> Wallet Requests</span>
                                    <?php if ($count_wallet > 0) {
                                        echo '<span class="badge badge-info badge-pill">' . $count_wallet . '</span>';
                                    } ?>
                                </a>

                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header text-muted small">Activation Requests</h6>

                                <a class="dropdown-item d-flex justify-content-between align-items-center py-2"
                                    href="sp_trash.php">
                                    <span><i class="fa fa-user-md mr-2 text-warning"></i> Service Provider</span>
                                    <?php if ($count_req_sp > 0) {
                                        echo '<span class="badge badge-warning badge-pill">' . $count_req_sp . '</span>';
                                    } ?>
                                </a>

                                <a class="dropdown-item d-flex justify-content-between align-items-center py-2"
                                    href="customer_trash.php">
                                    <span><i class="fa fa-users mr-2 text-warning"></i> Customer</span>
                                    <?php if ($count_req_cust > 0) {
                                        echo '<span class="badge badge-warning badge-pill">' . $count_req_cust . '</span>';
                                    } ?>
                                </a>

                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header text-muted small">Reviews</h6>
                                <a class="dropdown-item d-flex justify-content-between align-items-center py-2"
                                    href="customer_reviews.php">
                                    <span><i class="fa fa-star mr-2 text-success"></i> Customer Reviews</span>
                                    <?php if ($count_rev > 0) {
                                        echo '<span class="badge badge-success badge-pill">' . $count_rev . '</span>';
                                    } ?>
                                </a>

                                <?php if ($total_notif == 0): ?>
                                    <div class="dropdown-item text-muted text-center small py-3">No new notifications</div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <!-- <div class="search-rounded mr-3">
                            <input type="text" class="form-control search-box" placeholder="Enter keywords.." />
                        </div> -->
                        <div class="mr-4">
                            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="assets/img/user.png " alt="Adam" class="rounded-circle" width="40px"
                                    height="40px">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mt-13" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="category_view.php"><i class="fa fa-square pr-2"></i>
                                    Category</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="service_view.php"><i class="fa fa-th-list pr-2"></i>
                                    Service</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="_generate_report.php"><i class="fa fa-book pr-2"></i>
                                    Report</a>
                                <div class="dropdown-divider"></div>
<<<<<<< HEAD
                                <a class="dropdown-item" href="admin_profile.php"><i class="fa fa-user pr-2"></i>
                                    My Profile</a>
=======
                                <a class="dropdown-item" href="profile.php"><i class="fa fa-user pr-2"></i>
                                    Profile</a>
>>>>>>> 606a8a0 (Added comprehensive Frontend and Backend Defense Documentation and updated system logic)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off pr-2"></i>
                                    Logout</a>
                            </div>
                        </div>
                    </div>
                    <!--Search box and avatar-->
                </div>
            </div>
            <!--Header Menu-->
        </div>
        <!--Header-->

        <!--Main Content-->

        <div class="row main-content">
            <!--Sidebar left-->
            <div class="col-sm-3 col-xs-6 sidebar pl-0">
                <div class="inner-sidebar mr-3">
                    <!--Image Avatar-->
                    <div class="avatar text-center">
                        <img src="assets/img/user.png" alt="" class="img-fluid  rounded-circle" />
                        <p><strong><?php echo $_SESSION['admin_username']; ?></strong></p>
                        <span
                            class="text-primary small"><strong><?php echo $_SESSION['admin_username']; ?></strong></span>
                    </div>
                    <!--Image Avatar-->


                    <!--Sidebar Navigation Menu-->
                    <div class="sidebar-menu-container">
                        <ul class="sidebar-menu mt-4 mb-4">


                            <!-- My desk -->
                            <li class="parent">
                                <a href="index.php" class=""><i class="fa fa-user mr-3"></i>
                                    <span class="none">My desk </span>
                                </a>
                            </li>

                            <!-- Category -->
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('category'); return false" class=""><i
                                        class="fa  fa-square mr-3"></i>
                                    <span class="none">Category <i
                                            class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="category">
                                    <li class="child"><a href="category_view.php" class="ml-4"><i
                                                class="fa fa-angle-right mr-2"></i> View Category</a></li>
                                </ul>
                            </li>

                            <!-- Services -->
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('service'); return false" class=""><i
                                        class="fa  fa-th-list mr-3"></i>
                                    <span class="none">Service <i
                                            class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="service">
                                    <li class="child"><a href="service_view.php" class="ml-4"><i
                                                class="fa fa-angle-right mr-2"></i> View Service</a></li>
                                    <li class="child"><a href="service_add.php" class="ml-4"><i
                                                class="fa fa-angle-right mr-2"></i> Add Service</a></li>
                                    <!-- <li class="child"><a href="sp_update.php" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Edit Service Provider Details</a></li> -->
                                </ul>
                            </li>



                            <!-- Service Provider -->
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('serviceprovider'); return false" class=""><i
                                        class="fa  fa-male mr-3"></i>
                                    <span class="none">Service Provider <i
                                            class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="serviceprovider">
                                    <li class="child"><a href="sp_view.php" class="ml-4"><i
                                                class="fa fa-angle-right mr-2"></i> View Service Provider </a></li>
                                    <!-- <li class="child"><a href="sp_update.php" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Edit Service Provider Details</a></li> -->
                                </ul>
                            </li>

                            <!-- Customer -->
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('customer'); return false" class=""><i
                                        class="fa fa-users mr-3"></i>
                                    <span class="none">Customer <i
                                            class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="customer">
                                    <li class="child"><a href="customer_view.php" class="ml-4"><i
                                                class="fa fa-angle-right mr-2"></i> View Customer</a></li>
                                    <!-- <li class="child"><a href="sp_update.php" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Edit Service Provider Details</a></li> -->
                                </ul>
                            </li>



                            <!-- Orders -->
                            <!-- <li class="parent">
                                <a href="#" onclick="toggle_menu('order'); return false" class=""><i class="fa  fa-cubes mr-3"></i>
                                    <span class="none">Order <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="order">
                                    <li class="child"><a href="view_order.php" class="ml-4"><i class="fa fa-angle-right mr-2"></i> View Order</a></li>
                                </ul>
                            </li> -->


                            <!-- orders -->
                            <li class="parent">
                                <a href="_generate_report.php" class=""><i class="fa fa-book mr-3"></i>
                                    <span class="none">Generate Report </span>
                                </a>
                            </li>

                            <!-- Wallet Requests -->
                            <li class="parent">
                                <a href="wallet_requests.php" class=""><i class="fa fa-wallet mr-3"></i>
                                    <span class="none">Wallet Requests </span>
                                </a>
                            </li>

                            <!-- Revenue Report -->
                            <li class="parent">
                                <a href="revenue_view.php" class=""><i class="fa fa-chart-line mr-3"></i>
                                    <span class="none">Revenue Details </span>
                                </a>
                            </li>

                            <!-- Fuel Price -->
                            <li class="parent">
                                <a href="fuel_price.php" class=""><i class="fa fa-gas-pump mr-3"></i>
                                    <span class="none">Fuel Price </span>
                                </a>
                            </li>




                            <!-- 
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('dashboard'); return false" class=""><i class="fa fa-dashboard mr-3"> </i>
                                    <span class="none">Dashboard <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="dashboard">
                                    <li class="child"><a href="index.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Default</a></li>
                                    <li class="child"><a href="index2.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Analytics</a></li>
                                    <li class="child"><a href="index3.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Ecommerce</a></li>
                                    <li class="child"><a href="index4.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Cryptocurrency</a></li>
                                </ul>
                            </li>
                            </li>
                            <li class="parent">
                                <a href="widgets.html" class=""><i class="fa fa-puzzle-piece mr-3"></i>
                                    <span class="none">Widget </span>
                                </a>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('ul_element'); return false" class=""><i class="fa fa-puzzle-piece mr-3"></i>
                                    <span class="none">UI Elements <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="ul_element">
                                    <li class="child"><a href="accordion.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Accordions</a></li>
                                    <li class="child"><a href="buttons.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Buttons</a></li>
                                    <li class="child"><a href="badges.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Badges</a></li>
                                    <li class="child"><a href="breadcrumb.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Breadcrumbs</a></li>
                                    <li class="child"><a href="cards.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Cards</a></li>
                                    <li class="child"><a href="icons.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Icons</a></li>
                                    <li class="child"><a href="modal.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Modals</a></li>
                                    <li class="child"><a href="notification.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Notification</a></li>
                                    <li class="child"><a href="progressbar.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Progressbar</a></li>
                                    <li class="child"><a href="sweetalert.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Sweet alert</a></li>
                                    <li class="child"><a href="tabs.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Tabs</a></li>
                                    <li class="child"><a href="tooltip-popover.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Tooltip and Popovers</a></li>
                                    <li class="child"><a href="typography.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Typography</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('form_element'); return false" class=""><i class="fa fa-pencil-square mr-3"></i>
                                    <span class="none">Form Elements <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="form_element">
                                    <li class="child"><a href="form-general.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Basic Elements</a></li>
                                    <li class="child"><a href="form-advanced.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Advanced Elements</a></li>
                                    <li class="child"><a href="form-validation.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Validation</a></li>
                                    <li class="child"><a href="form-wizard.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Form Wizard</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('editors'); return false" class=""><i class="fa fa-pencil-square-o mr-3"></i>
                                    <span class="none">Text Editors <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="editors">
                                    <li class="child"><a href="ckeditor-classic.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Ckeditor classic</a></li>
                                    <li class="child"><a href="ckeditor-inline.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Ckeditor inline</a></li>
                                    <li class="child"><a href="ckeditor-document.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Ckeditor document</a></li>
                                    <li class="child"><a href="summernote.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Summernote editor</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('tables'); return false" class=""><i class="fa fa-pencil-square mr-3"></i>
                                    <span class="none">Tables <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="tables">
                                    <li class="child"><a href="basic-tables.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Basic Tables</a></li>
                                    <li class="child"><a href="datatable.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Datatables</a></li>
                                    <li class="child"><a href="jsgrid-table.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> JSGrid Tables</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('charts'); return false" class=""><i class="fa fa-pie-chart mr-3"></i>
                                    <span class="none">Charts <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="charts">
                                    <li class="child"><a href="chart.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Chart JS</a></li>
                                    <li class="child"><a href="chartist.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Chartist JS</a></li>
                                    <li class="child"><a href="echarts.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Echarts JS</a></li>
                                    <li class="child"><a href="flot.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Flot JS</a></li>
                                    <li class="child"><a href="morris.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Morris JS</a></li>
                                    <li class="child"><a href="nvd3.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> NVD3 JS</a></li>
                                    <li class="child"><a href="sparkline.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Sparkline JS</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="icons.html" class=""><i class="fa fa-toggle-on mr-3"></i>
                                    <span class="none">Icons</span>
                                </a>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('ecommerce'); return false" class=""><i class="fa fa-shopping-cart mr-3"></i>
                                    <span class="none">Ecommerce <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="ecommerce">
                                    <li class="child"><a href="products.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> ProductList</a></li>
                                    <li class="child"><a href="product-detail.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> ProductDetail</a></li>
                                    <li class="child"><a href="orders.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> OrderList</a></li>
                                    <li class="child"><a href="invoice.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Invoice</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('maps'); return false" class=""><i class="fa fa-map mr-3"></i>
                                    <span class="none">Maps <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="maps">
                                    <li class="child"><a href="jvector-maps.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jvector Maps</a></li>
                                    <li class="child"><a href="google-maps.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Google Maps</a></li>
                                </ul>
                            </li>
                            <li class="parent">
                                <a href="#" onclick="toggle_menu('pages'); return false" class=""><i class="fa fa-file mr-3"></i>
                                    <span class="none">Pages <i class="fa fa-angle-down pull-right align-bottom"></i></span>
                                </a>
                                <ul class="children" id="pages">
                                    <li class="child"><a href="email-inbox.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Email-Inbox</a></li>
                                    <li class="child"><a href="email.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Email-Compose</a></li>
                                    <li class="child"><a href="login.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Login</a></li>
                                    <li class="child"><a href="register.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Signup</a></li>
                                    <li class="child"><a href="lockscreen.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Lock Screen</a></li>
                                    <li class="child"><a href="forgot-password.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Forgot Password</a></li>
                                    <li class="child"><a href="profile.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Profile</a></li>
                                    <li class="child"><a href="gallery.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Gallery</a></li>
                                    <li class="child"><a href="invoice.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Invoice</a></li>
                                    <li class="child"><a href="search-result.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Search</a></li>
                                    <li class="child"><a href="pricing.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Pricing</a></li>
                                    <li class="child"><a href="blank.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Blank Page</a></li>
                                    <li class="child"><a href="error-404.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Error 404</a></li>
                                    <li class="child"><a href="error-500.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Error 500</a></li>
                                    <li class="child"><a href="error-504.html" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Error 504</a></li>
                                </ul>
                            </li> -->

                        </ul>
                    </div>
                    <!--Sidebar Naigation Menu-->
                </div>
            </div>
            <!--Sidebar left-->