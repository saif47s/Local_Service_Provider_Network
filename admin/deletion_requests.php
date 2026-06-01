<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
include '../includes/account_deletion_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Approve/reject must run before any HTML (admin_header outputs the page)
if (isset($_GET['action'], $_GET['login_id'], $_GET['role'])) {
    if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] != true) {
        header('Location: index.php');
        exit;
    }

    $login_id = (int) $_GET['login_id'];
    $role_id = (int) $_GET['role'];
    $action = $_GET['action'];

    if ($action === 'approve' && in_array($role_id, [2, 3], true)) {
        if (dp_soft_delete_login($conn, $login_id, $role_id)) {
            if ($role_id === 2) {
                $sp_q = mysqli_query($conn, "SELECT `sp_id` FROM `sp` WHERE `login_id` = '$login_id' LIMIT 1");
                if ($sp_q && mysqli_num_rows($sp_q) > 0) {
                    $sp_row = mysqli_fetch_assoc($sp_q);
                    $sp_id = (int) $sp_row['sp_id'];
                    mysqli_query($conn, "UPDATE `sp` SET `status` = 'deactive' WHERE `sp_id` = '$sp_id'");
                }
            }
            $_SESSION['status'] = 'Account deleted successfully (moved to trash).';
        } else {
            $_SESSION['statusfail'] = 'Failed to delete account.';
        }
    } elseif ($action === 'reject' && in_array($role_id, [2, 3], true)) {
        if (dp_clear_deletion_request($conn, $login_id)) {
            $_SESSION['status'] = 'Deletion request rejected.';
        } else {
            $_SESSION['statusfail'] = 'Failed to reject deletion request.';
        }
    } else {
        $_SESSION['statusfail'] = 'Invalid action.';
    }

    header('Location: deletion_requests.php');
    exit;
}

$title = 'Deletion Requests';
include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row">
        <div class="col-lg-7">
            <h5 class="mb-0"><strong>Account Deletion Requests</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Deletion Requests</span>
        </div>
        <div class="col-md-auto col-lg-5">
            <?php
            if (isset($_SESSION['status'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> ' . htmlspecialchars($_SESSION['status']) . '
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>';
                unset($_SESSION['status']);
            } elseif (isset($_SESSION['statusfail'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ' . htmlspecialchars($_SESSION['statusfail']) . '
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>';
                unset($_SESSION['statusfail']);
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-1 mb-4 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-3"><i class="fa fa-user-md text-danger mr-2"></i> Service Provider Requests</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_sp = "SELECT sp.*, city.city_name, login.login_id, login.username
                                FROM sp
                                INNER JOIN login ON sp.login_id = login.login_id
                                INNER JOIN city ON sp.city_id = city.city_id
                                WHERE login.deletion_request = 1
                                  AND login.role_id = 2
                                  AND (login.account_status IS NULL OR login.account_status != 'deleted')
                                ORDER BY sp.sp_id DESC";
                            $result_sp = mysqli_query($conn, $sql_sp);
                            $sno = 0;
                            if ($result_sp && mysqli_num_rows($result_sp) > 0) {
                                while ($row = mysqli_fetch_assoc($result_sp)) {
                                    $sno++;
                                    $login_id = (int) $row['login_id'];
                                    echo '<tr>
                                        <td>' . $sno . '</td>
                                        <td>' . htmlspecialchars($row['sp_name']) . '</td>
                                        <td>' . htmlspecialchars($row['email']) . '</td>
                                        <td>' . htmlspecialchars($row['phone']) . '</td>
                                        <td>' . htmlspecialchars($row['city_name']) . '</td>
                                        <td>
                                            <a href="deletion_requests.php?action=approve&login_id=' . $login_id . '&role=2"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm(\'Delete this service provider account?\');">
                                               <i class="fa fa-trash"></i> Delete Account
                                            </a>
                                            <a href="deletion_requests.php?action=reject&login_id=' . $login_id . '&role=2"
                                               class="btn btn-secondary btn-sm"
                                               onclick="return confirm(\'Reject this deletion request?\');">
                                               Reject
                                            </a>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted">No pending service provider deletion requests.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-3"><i class="fa fa-users text-danger mr-2"></i> Customer Requests</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_cust = "SELECT customer.*, city.city_name, login.login_id, login.username
                                FROM customer
                                INNER JOIN login ON customer.login_id = login.login_id
                                INNER JOIN city ON customer.city_id = city.city_id
                                WHERE login.deletion_request = 1
                                  AND login.role_id = 3
                                  AND (login.account_status IS NULL OR login.account_status != 'deleted')
                                ORDER BY customer.customer_id DESC";
                            $result_cust = mysqli_query($conn, $sql_cust);
                            $sno = 0;
                            if ($result_cust && mysqli_num_rows($result_cust) > 0) {
                                while ($row = mysqli_fetch_assoc($result_cust)) {
                                    $sno++;
                                    $login_id = (int) $row['login_id'];
                                    $full_name = trim($row['first_name'] . ' ' . $row['last_name']);
                                    echo '<tr>
                                        <td>' . $sno . '</td>
                                        <td>' . htmlspecialchars($full_name) . '</td>
                                        <td>' . htmlspecialchars($row['email']) . '</td>
                                        <td>' . htmlspecialchars($row['phone']) . '</td>
                                        <td>' . htmlspecialchars($row['city_name']) . '</td>
                                        <td>
                                            <a href="deletion_requests.php?action=approve&login_id=' . $login_id . '&role=3"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm(\'Delete this customer account?\');">
                                               <i class="fa fa-trash"></i> Delete Account
                                            </a>
                                            <a href="deletion_requests.php?action=reject&login_id=' . $login_id . '&role=3"
                                               class="btn btn-secondary btn-sm"
                                               onclick="return confirm(\'Reject this deletion request?\');">
                                               Reject
                                            </a>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted">No pending customer deletion requests.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/admin_footer.php'; ?>
