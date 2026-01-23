<?php
define('MYSITE', true);
include 'DataBase/dbconnect.php';

$title = 'Register Service Provider';
$css_directory = 'css/main.min.css';
$css_directory2 = 'css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';
?>


<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sp_name = $_POST["sp_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $transaction_id = $_POST["transaction_id"];
    $city_name = $_POST["sp_city"];
    $area = $_POST["area"];
    $pincode = $_POST["pincode"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];


    $existsql = "SELECT * FROM `login` where username ='$username' ";
    $existresult = mysqli_query($conn, $existsql);
    $numexist = mysqli_num_rows($existresult);
    if ($numexist > 0) {
        $showError = "Username is already existing.";
    } else {
        // Check Email
        $emailSql = "SELECT * FROM `sp` WHERE email = '$email'";
        if (mysqli_num_rows(mysqli_query($conn, $emailSql)) > 0) {
            $showError = "Email is already registered. Please Login.";
        } else {
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $otp = rand(100000, 999999);
                // insert into LOGIN TABLE incl OTP
                $sql = "INSERT INTO `login` (`login_id` , `role_id`, `username`,`password`, `is_verified`, `verification_code`) VALUES ('', '2', '$username', '$hash', '0', '$otp')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    //fetch login id from login table.
                    $fetch_loginid = "SELECT `login_id` FROM `login` where username ='$username'";
                    $fetch_result = mysqli_query($conn, $fetch_loginid);
                    $login_row = mysqli_fetch_assoc($fetch_result);
                    $login_id = $login_row['login_id'];

                    //fetch city is from city table.
                    $fetch_cityid = "SELECT `city_id` FROM `city` where city_name ='$city_name'";
                    $fetch_city_result = mysqli_query($conn, $fetch_cityid);
                    $city_row = mysqli_fetch_assoc($fetch_city_result);
                    $city_id = $city_row['city_id'];
                    // $sql2 = "INSERT INTO `sp` (`sp_id`, `login_id`, `sp_name`, `email`, `phone`, `city_id`, `pincode`) VALUES (NULL, '16', 'deepkorat', 'deepkorat213@gmail.com', '9687480417', '5', '341262')";
                    $sql2 = "INSERT INTO `sp` (`sp_id`, `login_id`, `sp_name`, `email`, `phone`, `transaction_id`, `city_id`, `area`, `pincode`, `status`) VALUES ('', '$login_id', '$sp_name', '$email','$phone', '$transaction_id', '$city_id', '$area', '$pincode', 'deactive')";
                    $result2 = mysqli_query($conn, $sql2);
                    if ($result2) {
                        // Send OTP
                        include_once 'php/send_otp.php';
                        if (sendOTP($email, $otp)) {
                            $_SESSION['temp_login_id'] = $login_id;
                            $_SESSION['temp_email'] = $email;
                            echo "<script>
                             alert('SP Account Created! Please verify your Email.');
                             window.location.href = 'verify_otp.php';
                         </script>";
                            exit;
                        } else {
                            $_SESSION['temp_login_id'] = $login_id;
                            $_SESSION['temp_email'] = $email;
                            echo "<script>
                                alert('Email Sending Failed (Localhost). Testing OTP: $otp');
                                window.location.href = 'verify_otp.php';
                            </script>";
                            exit;
                        }
                    }
                } else {
                    $showError = "Something went wrong!";
                }
            } else {
                $showError = "Password do no match!";
            }
        }
    }
}

?>




<body style="background-image: linear-gradient(-145deg,#f5faff,#87b0de);">

    <?php

    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success! </strong> ' . $showAlert . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sorry! </strong> ' . $showError . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
    }

    ?>





    <!-- container -->
    <div class="container" style="margin-bottom: 100px;">
        <div class="col-12 col-md-8 mx-auto border border-dark p-3 p-md-5">
            <h2 class="pb-2 text-c1-1">Register as a Service provider</h2>
            <div class="bg-c1-1" style="width:430px; height: 3px; margin-top:-10px;"></div>
            <hr class="pt-3">


            <form class="needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>

                <!-- name & email line -->
                <div class="form-row">
                    <div class="form-group col-md-12 input-group-sm">
                        <label for="spname">Name</label>
                        <input type="text" pattern="[A-Za-z\s]+" class="form-control required asterisk_input"
                            id="sp_name" name="sp_name" required title="Only letters and spaces allowed"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                        <div class="invalid-feedback">
                            Please enter valid name (Alphabets only).
                        </div>

                    </div>
                    <div class="form-group col-md-6 input-group-sm">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            aria-describedby="emailFeedback" required>
                        <div id="emailFeedback" class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>
                    <div class="form-group col-md-6 input-group-sm">
                        <label for="phone">Phone No.</label>
                        <input type="tel" class="form-control" required pattern="^03[0-9]{9}$" name="phone"
                            aria-describedby="phoneFeedback" data-for="phoneNumber" maxlength="11" minlength="11"
                            placeholder="Ex: 03001234567" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <!-- <input type="tel" class="form-control" pattern="\d{10}" data-for="phoneNumber" name="phone" aria-describedby="phoneFeedback" required> -->
                        <div id="phoneFeedback" class="invalid-feedback">
                            Must be 11 digits and start with 03.
                        </div>
                    </div>
                </div>

                <!-- Payment Details Display -->
                <div class="form-row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-info shadow-sm" role="alert" style="border-left: 5px solid #17a2b8;">
                            <h5 class="alert-heading"><i class="fas fa-hand-holding-usd"></i> Payment Information</h5>
                            <p class="mb-1">Please Recharge Your Account Wallet:</p>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Account Type:</strong> Easypaisa / JazzCash<br>
                                    <strong>Account Title:</strong> Hyper Local Services<br>
                                    <strong>Account Number:</strong> <span class="badge badge-warning"
                                        style="font-size: 1.1em;">0300-1234567</span>
                                </div>
                                <div style="font-size: 2em; opacity: 0.8;">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- transaction id line -->
                <div class="form-row">
                    <div class="form-group col-md-12 input-group-sm">
                        <label for="transaction_id">Easypaisa Transaction ID</label>
                        <input type="text" class="form-control" id="transaction_id" name="transaction_id"
                            placeholder="Enter 11-12 Digit Transaction ID" required minlength="11" maxlength="12"
                            pattern="\d{11,12}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <div class="invalid-feedback">
                            Please enter valid 11-12 Digit Transaction ID.
                        </div>
                    </div>
                </div>






                <!-- city line -->
                <div class="form-row">
                    <div class="form-group col-md-4 input-group-sm">
                        <label for="city">City</label>
                        <select id="sp_city" class=" custom-select" name="sp_city" required>
                            <option value="">Choose City</option>
                            <?php // category view code. Data get from category table
                            $sql = "SELECT * FROM `city`";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $city_name = $row['city_name'];
                                    echo '<option value="' . $city_name . '">' . $city_name . '</option>';
                                }
                            }
                            ?>
                            <!-- <option value="two">.this..</option>
                            <option value="three">.and..</option>
                            <option value="five">.that..</option> -->
                        </select>
                        <div class="invalid-feedback">Please choose a city.</div>
                    </div>
                    <div class="form-group col-md-4 input-group-sm">
                        <label for="area">Area:-</label>
                        <input type="text" class="form-control" id="area" name="area" placeholder="Enter Area" required>
                        <div class="invalid-feedback">Please enter an area.</div>
                    </div>
                    <div class="form-group col-md-4 input-group-sm">
                        <label for="Pincode">Pincode(5 digits)</label>
                        <input type="text" class="form-control" pattern="\d{5}" name="pincode" id="pincode" required
                            maxlength="5" placeholder="Ex: 54000"
                            oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length > 5) this.value = this.value.slice(0, 5);">
                        <div class="invalid-feedback">
                            Please enter valid 5 Digit Pincode.
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-4">

                <!-- usename line -->
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">
                        <label for="inlineFormInputGroupUsername2">Create Username</label>
                        <div class="input-group mb-2 mr-sm-2 input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-c1-1 text-light">@</div>
                            </div>
                            <input type="text" class="form-control" pattern="(?=.*[a-z]).{4,}" id="username"
                                name="username" placeholder="sahil_18" aria-describedby="inputGroupPrepend" required>

                            <div class="invalid-feedback">
                                Please choose a right username.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- password line -->
                <div class="form-row">
                    <div class="form-group col-md-6 input-group-sm">
                        <label for="password">Create Password</label>
                        <!-- <input type="password" class="form-control" id="password" name="password"  required> -->
                        <input type="password" class="form-control" id="password" name="password"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                        <div id="phoneFeedback" class="invalid-feedback">
                            Must contain at least one number and one uppercase and lowercase letter, and at least 8 or
                            more characters.
                        </div>
                    </div>
                    <div class="form-group col-md-6 input-group-sm">
                        <label for="confirmpassword">Confirm Password</label>
                        <!-- <input type="password" class="form-control" id="cpassword" name="cpassword" required> -->
                        <input type="password" class="form-control" id="cpassword" name="cpassword"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                        <div id="phoneFeedback" class="invalid-feedback">
                            Password does not matched.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-c1-1">Sign Up</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
            </form>

        </div>
    </div>



    <!-- form validation feedback -->
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>



    <?php
    include 'includes/footer.php';
    ?>