<?php
define('MYSITE', true);
include '../db/dbconnect.php';

$title = 'My Profile';
$css_directory = '../css/main.min.css';
$css_directory2 = '../css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo "<script>window.location.href = '../login.php';</script>";
    exit;
}

$login_id = $_SESSION['login_id'];
$customer_id = $_SESSION['customer_id'];

// Handle Profile Update
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

    // Basic Validation (Client-side should be there too)
    if (strlen($phone) == 11 && strlen($pincode) == 5) {
        $sql_update = "UPDATE `customer` SET 
            `first_name`='$first_name', 
            `last_name`='$last_name', 
            `phone`='$phone', 
            `address`='$address', 
            `pincode`='$pincode' 
            WHERE `customer_id`='$customer_id'";

        if (mysqli_query($conn, $sql_update)) {
            $msg = '<div class="alert alert-success">Profile Updated Successfully!</div>';
        } else {
            $msg = '<div class="alert alert-danger">Error Updating Profile: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        $msg = '<div class="alert alert-warning">Invalid Phone (11 digits) or Pincode (5 digits).</div>';
    }
}

// Fetch Current Data
$sql = "SELECT * FROM `customer` WHERE `customer_id` = '$customer_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fa fa-user"></i> My Profile</h4>
                </div>
                <div class="card-body">
                    <?php echo $msg; ?>
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="<?php echo $row['first_name']; ?>" required pattern="[A-Za-z\s]+">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="<?php echo $row['last_name']; ?>" required pattern="[A-Za-z\s]+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email (Cannot be changed)</label>
                            <input type="email" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Phone (11 Digits, Starts with 03)</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>"
                                required pattern="^03[0-9]{9}$" maxlength="11" minlength="11"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3"
                                required><?php echo $row['address']; ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Pincode (5 Digits)</label>
                                <input type="text" name="pincode" class="form-control"
                                    value="<?php echo $row['pincode']; ?>" required pattern="\d{5}" maxlength="5"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                            <!-- City ID is foreign key, keeping it simple or read-only for now unless we fetch city list -->
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <?php
                                $city_id = $row['city_id'];
                                $city_sql = "SELECT city_name FROM city WHERE city_id = '$city_id'";
                                $city_res = mysqli_query($conn, $city_sql);
                                $city_row = mysqli_fetch_assoc($city_res);
                                ?>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($city_row['city_name']) ? $city_row['city_name'] : ''; ?>"
                                    readonly>
                                <small class="text-muted">City cannot be changed currently.</small>
                            </div>
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-success btn-block">Update
                            Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br>

<?php
include '../includes/footer.php';
?>