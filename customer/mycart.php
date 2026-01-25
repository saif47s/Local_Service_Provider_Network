<?php
define('MYSITE', true);
include '../db/dbconnect.php';


$title = 'Main';
$css_directory = '../css/main.min.css';
$css_directory2 = '../css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch User Details for Validation
$user_id = $_SESSION['customer_id'];
$u_sql = "SELECT * FROM customer WHERE customer_id = '$user_id'";
$u_res = mysqli_query($conn, $u_sql);
$u_row = mysqli_fetch_assoc($u_res);
$db_name = $u_row['first_name'] . ' ' . $u_row['last_name'];
$db_phone = $u_row['phone'];
$db_pincode = $u_row['pincode'];

?>

<body>


    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-4">
                <?php
                //Alert OR Error Message:
                if (isset($_SESSION['removesuccess'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> ' . $_SESSION['removesuccess'] . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                    unset($_SESSION['removesuccess']);
                } elseif (isset($_SESSION['removeunsuccess'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops! </strong> ' . $_SESSION['removeunsuccess'] . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                    unset($_SESSION['removeunsuccess']);
                }
                ?>
                <div class="text-center border rounded bg-light my-4">
                    <h4>CART</h4>
                </div>
            </div>


            <?php
            if (!isset($_SESSION['cart']) || $_SESSION['cart'] != true) {
                ?>

                <div class="container-fluid mt-5">
                    <div class="row align-self-center">
                        <div class="col-md-12">
                            <div class="card" style="border:none;">
                                <!-- <div class="card-header">
                                        <h5>Cart</h5>
                                    </div> -->
                                <div class="card-body">
                                    <div class="col-sm-12 empty-cart-cls text-center">
                                        <!-- <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3"> -->
                                        <img src="../img/EMPTY_CART.png" width="130" height="130"
                                            class="img-fluid mb-4 mr-3">
                                        <h3><strong>Your Cart is Empty</strong></h3>
                                        <h5 class="text-secondary">You will find a lot of interesting services on our
                                            "Service" page :)</h5>
                                        <a href="customer_index.php" class="btn btn-c1-1 cart-btn-transform m-3"
                                            data-abc="true">continue shopping</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Service Provider</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Operation</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                foreach ($_SESSION['cart'] as $key => $value) {
                                    $sr = $key + 1;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $sr; ?></th>
                                        <td><?php echo $value['service_title']; ?></td>
                                        <td><?php echo $value['sp_name']; ?></td>
                                        <td>
                                            <small>Rs. </small><?php echo $value['price']; ?>
                                            <input type="hidden" class="iprice" value="<?php echo $value['price']; ?>">
                                        </td>
                                        <!-- quantity -->
                                        <form action="manage_cart.php" method="post">
                                            <td><input type="number" pattern="[1-9]\d*" class="text-center iquantity"
                                                    name="Mod_Quantity" onchange="this.form.submit();"
                                                    value="<?php echo $value['quantity']; ?>" min="1" step="1"
                                                    oninput="validity.valid||(value='');"></td>
                                            <input type="hidden" name="service_title"
                                                value="<?php echo $value['service_title']; ?>">
                                        </form>
                                        <!-- line Total -->
                                        <td class="itotal"></td>
                                        <!-- remove button -->
                                        <td>
                                            <form action="manage_cart.php" method="post">
                                                <button class="btn btn-sm btn-outline-danger"
                                                    name="remove_service">Remove</button>
                                                <input type="hidden" name="service_title"
                                                    value="<?php echo $value['service_title']; ?>">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="border bg-light rounded p-4">
                        <h4>Grand Total:</h4>
                        <div class="text-right">
                            <h6 class="text-secondary" style="display:inline-block;">Item Total: Rs. <span
                                    id="item_total">0</span></h6><br>
                            <h6 class="text-secondary" style="display:inline-block;">Platform Fee (5%): Rs. <span
                                    id="commission_total">0</span></h6><br>
                            <hr>
                            <h6 style="display:inline-block;">Rs. </h6>
                            <h5 style="display:inline-block;" id="gtotal"></h5>
                            <h5 style="display:inline-block;" id="">/-</h5>
                        </div>

                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            ?>
                            <form action="order.php" method="post">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="fullname" required
                                        data-correct="<?php echo $db_name; ?>" oninput="validateField(this, 'Name mismatch')">
                                    <div class="invalid-feedback">Invalid Name (Must match registered name)</div>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" class="form-control" required pattern="^[0-9-+\s()]{10}" name="phone"
                                        aria-describedby="phoneFeedback" data-for="phoneNumber"
                                        data-correct="<?php echo $db_phone; ?>" oninput="validateField(this, 'Phone mismatch')">
                                    <div class="invalid-feedback">Invalid Phone (Must match registered phone)</div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="address" cols="25" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" pattern="\d{5}" name="pincode" id="pincode" required
                                        data-correct="<?php echo $db_pincode; ?>"
                                        oninput="validateField(this, 'Pincode mismatch')">
                                    <div class="invalid-feedback">Invalid Pincode (Must match registered pincode)</div>
                                </div>

                                <div class="form-group">
                                    <label>Service Date:-</label>
                                    <input type="datetime-local" class="form-control" name="due_date" id="due_date" required>
                                    <small class="text-secondary">which DATE & TIME you want a service</small>
                                    <div class="invalid-feedback">
                                        <p id="error-message"></p>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pay_mode" id="exampleRadios1" value="COD"
                                        checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Cash On Delivery
                                    </label>
                                </div>
                                <!-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pay_mode" id="exampleRadios2" value="Gpay">
                                    <label class="form-check-label" for="exampleRadios2">
                                        GPay
                                    </label>
                                </div> -->
                                <br>
                                <button type="submit" class="btn btn-primary btn-block" name="order">Make Order</button>
                                <input type="hidden" id="total" name="total">

                            </form>
                            <?php
                        }
                        ?>


                    </div>
                </div>



            </div>
        </div>


        <?php
                //first session cart start che k nai te check krti vakhate else loop no end
            }
            ?>
    <script>
        var gt = 0;
        var iprice = document.getElementsByClassName('iprice');
        var iquantity = document.getElementsByClassName('iquantity');
        var itotal = document.getElementsByClassName('itotal');
        var gtotal = document.getElementById('gtotal');

        function subTotal() {
            gt = 0;
            for (i = 0; i < iprice.length; i++) {
                itotal[i].innerText = (iprice[i].value) * (iquantity[i].value);
                gt = gt + (iprice[i].value) * (iquantity[i].value);
                var myVariable = gt;
                localStorage.setItem("myVar", myVariable);
            }

            var commission = gt * 0.05;
            var totalWithCommission = gt + commission;

            // Update breakdown if elements exist
            if (document.getElementById('item_total')) {
                document.getElementById('item_total').innerText = gt;
            }
            if (document.getElementById('commission_total')) {
                document.getElementById('commission_total').innerText = commission.toFixed(0);
            }

            //print grand total
            gtotal.innerText = totalWithCommission.toFixed(0);
            document.getElementById("total").value = totalWithCommission.toFixed(0);
        }

        subTotal();
    </script>


    <!-- date time validation  -->
    <script>
        const datetimeInput = document.getElementById("due_date");
        const errorMessage = document.getElementById("error-message");

        datetimeInput.addEventListener("input", function () {
            const selectedDatetime = new Date(datetimeInput.value);
            const now = new Date();
            if (selectedDatetime < now) {
                errorMessage.textContent = "Please select a future date and time.";
                datetimeInput.setCustomValidity("Please select a future date and time.");
            } else {
                errorMessage.textContent = "";
                datetimeInput.setCustomValidity("");
            }
        });

        function validateField(input, msg) {
            var correctVal = input.getAttribute('data-correct');
            // Remove spaces/trim for better comparison
            if (input.value.trim() !== correctVal.trim()) {
                input.setCustomValidity(msg);
                input.classList.add('is-invalid');
            } else {
                input.setCustomValidity("");
                input.classList.remove('is-invalid');
            }
        }
    </script>


    <?php
    include '../includes/footer.php';
    include 'includes/navfooter.php';
    ?>