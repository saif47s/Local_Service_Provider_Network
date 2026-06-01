<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['sp_loggedin']) || $_SESSION['sp_loggedin'] != true) {
    header('location: ../login.php');
    exit;
}

$title = 'Make Service Gig';
$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicetitle = mysqli_real_escape_string($conn, trim($_POST['servicetitle'] ?? ''));
    $sp_login_id = (int) $_SESSION['sp_login_id'];
    $category_id = (int) ($_POST['category'] ?? 0);
    $service_id = (int) ($_POST['service'] ?? 0);
    $description = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));
    $price = mysqli_real_escape_string($conn, trim($_POST['price'] ?? ''));
    $service_availibility = mysqli_real_escape_string($conn, $_POST['service_availibility'] ?? '');

    $sp_id = (int) ($_SESSION['sp_id'] ?? 0);
    if ($sp_id === 0) {
        $fetchspid = "SELECT `sp_id` FROM `sp` WHERE `login_id` = '$sp_login_id' LIMIT 1";
        $fetchresult = mysqli_query($conn, $fetchspid);
        if ($fetchresult && mysqli_num_rows($fetchresult) > 0) {
            $row = mysqli_fetch_assoc($fetchresult);
            $sp_id = (int) $row['sp_id'];
        }
    }

    if ($sp_id === 0) {
        $showError = 'Service provider record not found. Please log in again.';
    } elseif ($servicetitle === '' || $category_id === 0 || $service_id === 0 || $price === '' || $description === '') {
        $showError = 'Please fill all required fields.';
    } elseif ($service_availibility !== '0' && $service_availibility !== '1') {
        $showError = 'Please select service availability.';
    } else {
        $check = "SELECT * FROM `sp_service` WHERE `sp_id` = '$sp_id' AND `service_id` = '$service_id' LIMIT 1";
        $checkresult = mysqli_query($conn, $check);
        if ($checkresult && mysqli_num_rows($checkresult) > 0) {
            $showError = 'Sorry, you already have a gig for this service.';
        } else {
            $input = "INSERT INTO `sp_service`
                (`sp_id`, `service_id`, `category_id`, `service_title`, `price`, `description`, `availability`)
                VALUES ('$sp_id', '$service_id', '$category_id', '$servicetitle', '$price', '$description', '$service_availibility')";
            if (mysqli_query($conn, $input)) {
                $showAlert = 'Your gig was created successfully.';
            } else {
                $showError = 'Sorry, your gig could not be created. ' . mysqli_error($conn);
            }
        }
    }
}

include 'assets/include/sp_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row ">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Make Service</strong></h5>
            <span class="text-secondary">Workspace<i class="fa fa-angle-right"></i> make Service</span>
        </div>
        <div class="col-md-auto col-lg-7">
            <?php
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> ' . htmlspecialchars($showAlert) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
            }
            if ($showError) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops! </strong> ' . htmlspecialchars($showError) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-3 mb-3 p-1 button-container bg-white shadow-sm border">
                <div class="col-sm-12 ">
                    <h6 class="mb-2 pt-3 font-weight-bold">Make Service gig</h6>
                    <div class="mt-4 mb-3 p-3 button-container bg-white border shadow-sm ">

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="form-group row">
                                <label for="servicetitle" class="control-label col-sm-3">Service title:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="servicetitle" name="servicetitle"
                                        placeholder="ex.kitchen cleaning" required />
                                    <small class="form-text text-muted">Give a suitable title for your service.</small>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <label for="category" class="control-label col-sm-3">Select Category:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="" selected disabled>select category</option>
                                        <?php
                                        $categorysql = "SELECT * FROM `category` ORDER BY `category_name`";
                                        $result = mysqli_query($conn, $categorysql);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . (int) $row['category_id'] . '">'
                                                    . htmlspecialchars($row['category_name']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <label for="service" class="control-label col-sm-3">Select Service:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="service" name="service" required>
                                        <option value="" selected disabled>select service</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <label class="control-label col-sm-3" for="description">Short Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="description" name="description"
                                        placeholder="ex.I provide this service professionally" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="control-label col-sm-3">Price:</label>
                                <div class="col-sm-9">
                                    <input type="number" min="1" step="0.01" class="form-control" id="price" name="price"
                                        placeholder="500" required />
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <label class="control-label col-sm-3">Service Availability:</label>
                                <div class="col-sm-9">
                                    <div class="custom-control custom-radio mb-0">
                                        <input type="radio" class="custom-control-input" id="availabilityYes" value="1"
                                            name="service_availibility" required>
                                        <label class="custom-control-label" for="availabilityYes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-2">
                                        <input type="radio" class="custom-control-input" id="availabilityNo" value="0"
                                            name="service_availibility" required>
                                        <label class="custom-control-label" for="availabilityNo">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group pt-3 col-sm-12 d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Create</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/sp_footer.php'; ?>

<script>
$(function () {
    $('#category').on('change', function () {
        var category_id = this.value;
        if (!category_id) {
            return;
        }
        $.ajax({
            url: 'assets/ajax/_category_ajax.php',
            type: 'POST',
            data: { category_id: category_id },
            success: function (result) {
                $('#service').html(result);
            },
            error: function () {
                $('#service').html('<option value="" selected disabled>Could not load services</option>');
            }
        });
    });
});
</script>
