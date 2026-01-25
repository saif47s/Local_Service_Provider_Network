<?php
define('MYSITE', true);
include 'DataBase/dbconnect.php';

$title = 'Signup';
$css_directory = 'css/main.min.css';
$css_directory2 = 'css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';
?>


<?php
$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["firstname"];
    $last_name = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city_name = $_POST["city"];
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
        $emailSql = "SELECT * FROM `customer` WHERE email = '$email'";
        if (mysqli_num_rows(mysqli_query($conn, $emailSql)) > 0) {
            $showError = "Email is already registered. Please Login.";
        } else {
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $token = bin2hex(random_bytes(16)); // Generate 32-character secure token

                // insert into LOGIN TABLE including Token
                $sql = "INSERT INTO `login` (`login_id` , `role_id`, `username`,`password`, `is_verified`, `verification_code`) VALUES ('', '3', '$username', '$hash', '0', '$token')";
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
                    $sql2 = "INSERT INTO `customer` (`customer_id`, `login_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city_id`, `area`, `pincode`) VALUES ('', '$login_id', '$first_name', '$last_name','$email','$phone', '$address', '$city_id', '$area', '$pincode')";
                    $result2 = mysqli_query($conn, $sql2);
                    if ($result2) {
                        // Send Verification Email
                        include_once 'php/send_email.php';
                        if (sendVerificationEmail($email, $token)) {
                            echo "<script>
                            alert('Account Created! Please check your email ($email) to verify your account.');
                            window.location.href = 'login.php';
                        </script>";
                            exit;
                        } else {
                            // Check if this is localhost dev
                            $verifyLink = "http://localhost/BCA-home-Services-Project-master/BCA-home-Services-Project-master/verify_email.php?token=" . urlencode($token);
                            echo "<script>
                                alert('Email Sending Failed (Localhost). Manual Link: $verifyLink');
                                window.location.href = 'login.php';
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
            <strong>Success! </strong> ' . $showError . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
    }

    ?>


    <!-- container -->
    <div class="container">
        <div class="mx-auto col-11 col-md-8" style="border: 1px solid #1C315E; padding: 1.5em;">
            <h4 class="pb-2 text-c1-1">Enter the details for order service </h4>
            <div class="bg-c1-1" style="width:100%; height: 3px; margin-top:-10px;"></div>
            <hr class="pt-3">


            <form class="needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>

                <!-- name & email line -->
                <div class="form-row">
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="firstname">First Name:-</label>
                        <input type="text" class="form-control " id="firstname" name="firstname" required
                            pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                        <!-- <div class="valid-feedback">
                            Looks good!
                        </div> -->
                    </div>
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="lastname">Last Name:-</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required
                            pattern="[A-Za-z\s]+" title="Only letters and spaces allowed"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                    </div>
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="email">Email:-</label>
                        <input type="email" class="form-control" id="spemail" name="email"
                            aria-describedby="emailFeedback" required>
                        <div id="emailFeedback" class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="phone">Phone No:-</label>
                        <input type="tel" class="form-control" required pattern="^03[0-9]{9}$" name="phone"
                            aria-describedby="phoneFeedback" data-for="phoneNumber" maxlength="11" minlength="11"
                            placeholder="Ex: 03001234567" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <!-- <input type="tel" class="form-control" required pattern="\d{10}" data-for="phoneNumber" name="phone" aria-describedby="phoneFeedback" > -->
                        <div id="phoneFeedback" class="invalid-feedback">
                            Must be 11 digits and start with 03.
                        </div>
                    </div>
                </div>


                <!-- Address line -->
                <div class="form-row">
                    <div class="mb-3 col-12">
                        <label for="validationTextarea">Address:-</label>
                        <textarea class="form-control" id="validationTextarea" name="address"
                            placeholder="Enter your home address" required></textarea>
                        <div class="invalid-feedback">
                            Please enter your address.
                        </div>
                    </div>
                </div>



                <!-- city line -->
                <div class="form-row">
                    <div class="form-group col-12 col-md-4 input-group-sm">
                        <label for="city">City:-</label>
                        <select id="city" class=" custom-select" name="city" required>
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
                    <div class="form-group col-12 col-md-4 input-group-sm">
                        <label for="area">Area:-</label>
                        <input type="text" class="form-control" id="area" name="area" placeholder="Enter Area" required>
                        <div class="invalid-feedback">Please enter an area.</div>
                    </div>
                    <div class="form-group col-12 col-md-4 input-group-sm">
                        <label for="Pincode">Pincode(5 digits):-</label>
                        <input type="text" class="form-control" name="pincode" pattern="\d{5}" id="pincode" required
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
                    <div class="form-group col-12 col-md-6 ">
                        <label for="inlineFormInputGroupUsername2">Create Username:-</label>
                        <div class="input-group mb-2 mr-sm-2 input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-c1-1 text-light">@</div>
                            </div>
                            <input type="text" class="form-control" pattern="(?=.*[a-z]).{4,}" id="username"
                                name="username" placeholder="deep_13" aria-describedby="inputGroupPrepend" required>

                            <div class="invalid-feedback">
                                Please choose a right username.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- password line -->
                <div class="form-row">
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="password">Create Password:-</label>
                        <!-- <input type="password" class="form-control" id="password" name="password" required> -->
                        <input type="password" class="form-control" id="password" name="password"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                        <div id="phoneFeedback" class="invalid-feedback">
                            Must contain at least one number and one uppercase and lowercase letter, and at least 8 or
                            more characters.
                        </div>
                    </div>
                    <div class="form-group col-12 col-md-6 input-group-sm">
                        <label for="confirmpassword">Confirm Password:-</label>
                        <!-- <input type="password" class="form-control" id="cpassword" name="cpassword" required> -->
                        <input type="password" class="form-control" id="cpassword" name="cpassword"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                        <div id="phoneFeedback" class="invalid-feedback">
                            Password does not matched.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn pest_btn btn-c1-1">Sign Up</button>
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


    <!-- AJAX for Area and Pincode -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#city').on('change', function () {
                var city_name = this.value;

                // Auto-fill pincode for Chakwal
                if (city_name === 'Chakwal') {
                    $('#pincode').val('48800');
                    // $('#pincode').prop('readonly', true); // Optional: Lock it if desired
                } else {
                    $('#pincode').val('');
                    // $('#pincode').prop('readonly', false);
                }

                // Fetch Areas
                $.ajax({
                    url: 'assets/ajax/get_areas.php',
                    type: "POST",
                    data: {
                        city_name: city_name
                    },
                    success: function (result) {
                        $('#area').html(result);
                    }
                });
            });
        });
    </script>

    <?php
    include 'includes/footer.php';
    ?>