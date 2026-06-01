<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
include '../includes/account_deletion_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['sp_loggedin']) || $_SESSION['sp_loggedin'] != true) {
    header('location: ../login.php');
    exit;
}

$title = 'My Profile';
include 'assets/include/sp_header.php';

$sp_id = (int) $_SESSION['sp_id'];
$login_id = (int) $_SESSION['sp_login_id'];
$showAlert = false;
$showError = false;
$deletionPending = false;

$profile = null;
$profile_sql = "SELECT sp.*, city.city_name
        FROM sp
        INNER JOIN city ON sp.city_id = city.city_id
        WHERE sp.sp_id = '$sp_id' AND sp.login_id = '$login_id'
        LIMIT 1";
$profile_result = mysqli_query($conn, $profile_sql);
if ($profile_result && mysqli_num_rows($profile_result) > 0) {
    $profile = mysqli_fetch_assoc($profile_result);
}

$login_username = $_SESSION['sp_username'];
$login_sql = "SELECT `username` FROM `login` WHERE `login_id` = '$login_id' LIMIT 1";
$login_result = mysqli_query($conn, $login_sql);
if ($login_result && mysqli_num_rows($login_result) > 0) {
    $login_row = mysqli_fetch_assoc($login_result);
    $login_username = $login_row['username'];
}

$deletionStatus = dp_get_login_deletion_status($conn, $login_id);
if ($deletionStatus && (int) ($deletionStatus['deletion_request'] ?? 0) === 1) {
    $deletionPending = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_account_deletion'])) {
    $deletionResult = dp_submit_deletion_request($conn, $login_id);
    if ($deletionResult['ok']) {
        $showAlert = $deletionResult['message'];
        $deletionPending = true;
    } else {
        $showError = $deletionResult['message'];
        if (!empty($deletionResult['already_sent'])) {
            $deletionPending = true;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    if (!$profile) {
        $showError = 'Profile not found. Cannot update.';
    } else {
    $sp_name = trim($_POST['sp_name'] ?? '');
    $email = $profile['email']; // Email cannot be changed from profile
    $phone = trim($_POST['phone'] ?? '');
    $city_name = trim($_POST['sp_city'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';

    // Keep existing values when a field is left unchanged/empty
    if ($sp_name === '') {
        $sp_name = $profile['sp_name'];
    }
    if ($phone === '') {
        $phone = $profile['phone'];
    }
    if ($city_name === '') {
        $city_name = $profile['city_name'];
    }
    if ($pincode === '') {
        $pincode = $profile['pincode'];
    }
    if ($username === '') {
        $username = $login_username;
    }

    $sp_name = mysqli_real_escape_string($conn, $sp_name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $city_name = mysqli_real_escape_string($conn, $city_name);
    $pincode = mysqli_real_escape_string($conn, $pincode);
    $username = mysqli_real_escape_string($conn, $username);

    $city_id = (int) $profile['city_id'];
    $city_result = mysqli_query($conn, "SELECT `city_id` FROM `city` WHERE `city_name` = '$city_name' LIMIT 1");
    if ($city_result && mysqli_num_rows($city_result) > 0) {
        $city_row = mysqli_fetch_assoc($city_result);
        $city_id = (int) $city_row['city_id'];
    } else {
        $showError = 'Please select a valid city.';
    }

    if (!$showError && !preg_match('/^[0-9]{10,11}$/', $phone)) {
        $showError = 'Phone must be 10 or 11 digits.';
    }

    if (!$showError && !preg_match('/^[0-9]{6}$/', $pincode)) {
        $showError = 'Pincode must be 6 digits.';
    }

    if (!$showError) {
        $username_check = mysqli_query(
            $conn,
            "SELECT `login_id` FROM `login` WHERE `username` = '$username' AND `login_id` != '$login_id' LIMIT 1"
        );
        if ($username_check && mysqli_num_rows($username_check) > 0) {
            $showError = 'Username is already taken. Choose another.';
        }
    }

    if (!$showError && $password !== '') {
        if ($password !== $cpassword) {
            $showError = 'Password and confirm password do not match.';
        } elseif (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password)) {
            $showError = 'Password must be at least 8 characters with upper, lower, and a number.';
        }
    }

    if (!$showError) {
        $update_sp = "UPDATE `sp` SET
            `sp_name` = '$sp_name',
            `email` = '$email',
            `phone` = '$phone',
            `city_id` = '$city_id',
            `pincode` = '$pincode'
            WHERE `sp_id` = '$sp_id' AND `login_id` = '$login_id'";

        $update_login = "UPDATE `login` SET `username` = '$username' WHERE `login_id` = '$login_id'";

        if (mysqli_query($conn, $update_sp) && mysqli_query($conn, $update_login)) {
            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $hash = mysqli_real_escape_string($conn, $hash);
                mysqli_query($conn, "UPDATE `login` SET `password` = '$hash' WHERE `login_id` = '$login_id'");
            }
            $_SESSION['sp_username'] = $username;
            $showAlert = 'Profile updated successfully.';
        } else {
            $showError = 'Could not update profile. ' . mysqli_error($conn);
        }
    }

    // Reload profile after successful update
    if ($showAlert) {
        $profile_result = mysqli_query($conn, $profile_sql);
        if ($profile_result && mysqli_num_rows($profile_result) > 0) {
            $profile = mysqli_fetch_assoc($profile_result);
        }
        $login_result = mysqli_query($conn, $login_sql);
        if ($login_result && mysqli_num_rows($login_result) > 0) {
            $login_row = mysqli_fetch_assoc($login_result);
            $login_username = $login_row['username'];
        }
    }
    }
}
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-0"><strong>My Profile</strong></h5>
    <span class="text-secondary">Workspace <i class="fa fa-angle-right"></i> Update profile</span>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <?php
                if ($showAlert) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> ' . htmlspecialchars($showAlert) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                if ($showError) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ' . htmlspecialchars($showError) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
                ?>

                <?php if ($profile) { ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="update_profile" value="1">
                        <p class="text-muted small">Change only the fields you need, then click Update Profile.</p>

                        <div class="form-row">
                            <div class="form-group col-md-12 input-group-sm">
                                <label for="sp_name">Name</label>
                                <input type="text" class="form-control" id="sp_name" name="sp_name"
                                    value="<?php echo htmlspecialchars($profile['sp_name']); ?>">
                            </div>
                            <div class="form-group col-md-6 input-group-sm">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email"
                                    value="<?php echo htmlspecialchars($profile['email']); ?>" readonly>
                                <small class="text-muted">Email cannot be changed.</small>
                            </div>
                            <div class="form-group col-md-6 input-group-sm">
                                <label for="phone">Phone No.</label>
                                <input type="tel" class="form-control" name="phone" id="phone"
                                    value="<?php echo htmlspecialchars($profile['phone']); ?>"
                                    maxlength="11" inputmode="numeric"
                                    title="10 or 11 digit phone number">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 input-group-sm">
                                <label for="sp_city">City</label>
                                <select id="sp_city" class="custom-select" name="sp_city">
                                    <option value="">Choose City</option>
                                    <?php
                                    $city_sql = "SELECT * FROM `city` ORDER BY `city_name`";
                                    $city_result = mysqli_query($conn, $city_sql);
                                    if ($city_result) {
                                        while ($city_row = mysqli_fetch_assoc($city_result)) {
                                            $selected = ($city_row['city_name'] === $profile['city_name']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($city_row['city_name']) . '" ' . $selected . '>'
                                                . htmlspecialchars($city_row['city_name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2 input-group-sm">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" name="pincode" id="pincode"
                                    value="<?php echo htmlspecialchars($profile['pincode']); ?>"
                                    maxlength="6" inputmode="numeric" title="6 digit pincode">
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <div class="input-group mb-2 mr-sm-2 input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-c1-1 text-light">@</div>
                                    </div>
                                    <input type="text" class="form-control" id="username"
                                        name="username" value="<?php echo htmlspecialchars($login_username); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 input-group-sm">
                                <label for="password">New Password <small class="text-muted">(optional)</small></label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group col-md-6 input-group-sm">
                                <label for="cpassword">Confirm New Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-c1-1">Update Profile</button>
                        <a href="sp_index.php" class="btn btn-outline-secondary">Cancel</a>
                    </form>

                    <hr class="mt-4 mb-3">
                    <h6 class="text-danger font-weight-bold">Delete Account</h6>
                    <p class="text-muted small mb-3">
                        Request admin to delete your service provider account. Your account will remain active until admin approves.
                    </p>
                    <?php if ($deletionPending) { ?>
                        <div class="alert alert-warning mb-0">
                            <strong>Wait for admin response.</strong> Request already sent.
                        </div>
                    <?php } else { ?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                            onsubmit="return confirm('Send account deletion request to admin?');">
                            <input type="hidden" name="request_account_deletion" value="1">
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fa fa-trash"></i> Delete Account
                            </button>
                        </form>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-warning mb-0">Profile not found. Please contact support.</div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/sp_footer.php'; ?>
