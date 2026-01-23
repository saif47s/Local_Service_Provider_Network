<?php
define('MYSITE', true);
include 'DataBase/dbconnect.php';


$title = 'Main';
$css_directory = 'css/main.min.css';
$css_directory2 = 'css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';
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
                    <h4>Fixed Fuel Price = 7 rupees per kilometer</h4>

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
                                        <img src="img/EMPTY_CART.png" width="130" height="130" class="img-fluid mb-4 mr-3">
                                        <h3><strong>Your Cart is Empty</strong></h3>
                                        <h5 class="text-secondary">You will find a lot of interesting services on our
                                            "Service" page :)</h5>
                                        <a href="index.php" class="btn btn-c1-1 cart-btn-transform m-3"
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

                <div class="col-lg-9 col-12 table-responsive">

                    <table class="table">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service</th>
                                <th scope="col">Service Provider</th>
                                <th scope="col">Location</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Operation</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $php_total = 0;
                            foreach ($_SESSION['cart'] as $key => $value) {
                                $sr = $key + 1;
                                $line_price = (float) $value['price'];
                                $line_quantity = (int) $value['quantity'];
                                $line_total = $line_price * $line_quantity;
                                $php_total += $line_total;
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $sr; ?></th>
                                    <td><?php echo $value['service_title']; ?></td>
                                    <td><?php echo $value['sp_name']; ?></td>
                                    <td><?php echo isset($value['sp_location']) ? $value['sp_location'] : '-'; ?></td>
                                    <td>
                                        <small>Rs. </small><?php echo $value['price']; ?>
                                        <input type="hidden" class="iprice" value="<?php echo $value['price']; ?>">
                                    </td>
                                    <!-- quantity -->
                                    <form action="manage_cart.php" method="post">
                                        <td><input type="number" class="text-center iquantity" name="Mod_Quantity"
                                                onchange="this.form.submit();" value="<?php echo $value['quantity']; ?>" min="1"
                                                max="20" step="1" oninput="validity.valid||(value='');"></td>
                                        <input type="hidden" name="service_title"
                                            value="<?php echo $value['service_title']; ?>">
                                    </form>
                                    <!-- line Total -->
                                    <td class="itotal"><?php echo $line_total; ?></td>
                                    <!-- remove button -->
                                    <td>
                                        <form action="manage_cart.php" method="post">
                                            <button class="btn btn-sm btn-outline-danger" name="remove_service">Remove</button>
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

                <div class="col-lg-3 col-12 mt-4 mt-lg-0">
                    <div class="border bg-light rounded p-4">
                        <h4>Grand Total:</h4>
                        <?php
                        $commission = $php_total * 0.05;
                        $grand_total = $php_total + $commission;
                        ?>
                        <div class="text-right">
                            <h6 class="text-secondary" style="display:inline-block;">Item Total: Rs. <span
                                    id="item_total"><?php echo $php_total; ?></span></h6><br>
                            <h6 class="text-secondary" style="display:inline-block;">Platform Fee (5%): Rs. <span
                                    id="commission_total"><?php echo round($commission); ?></span></h6><br>

                            <hr>
                            <h6 style="display:inline-block;">Rs. </h6>
                            <h5 style="display:inline-block;" id="gtotal"><?php echo round($grand_total); ?></h5>
                            <h5 style="display:inline-block;" id="">/-</h5>
                        </div>

                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            ?>
                            <form action="order.php" method="post">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" required pattern="^[0-9-+\s()]{10}" name="phone"
                                        aria-describedby="phoneFeedback" data-for="phoneNumber">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Address</label>
                                    <textarea name="address" id="address" cols="25" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" pattern="\d{6}" name="pincode" id="pincode"
                                        required>
                                </div>


                                <div class="form-group">
                                    <label>Service Date:-</label>
                                    <?php
                                    // Set strict min attribute to current date-time
                                    $min_date = date('Y-m-d\TH:i');
                                    ?>
                                    <input type="datetime-local" class="form-control" name="due_date" id="due_date"
                                        min="<?php echo $min_date; ?>" required>
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
                                <button class="btn btn-primary btn-block" name="order">Make Order</button>
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
                let p = parseFloat(iprice[i].value) || 0;
                let q = parseFloat(iquantity[i].value) || 0;
                let lineTotal = p * q;

                itotal[i].innerText = lineTotal;
                gt = gt + lineTotal;

                // Update local storage (optional, but keeping existing logic)
                localStorage.setItem("myVar", gt);
            }

            var commission = gt * 0.05;

            // Update breakdown if elements exist
            if (document.getElementById('item_total')) {
                document.getElementById('item_total').innerText = gt;
            }

            if (document.getElementById('commission_total')) {
                document.getElementById('commission_total').innerText = commission.toFixed(0);
            }

            // Total = Item Total + Commission
            var totalWithCommission = gt + commission;

            //print grand total
            gtotal.innerText = totalWithCommission.toFixed(0);
            if (document.getElementById("total")) {
                document.getElementById("total").value = totalWithCommission.toFixed(0);
            }
        }

        subTotal();
    </script>


    <!-- date time validation  -->
    <script>
        const datetimeInput = document.getElementById("due_date");
        const errorMessage = document.getElementById("error-message");

        // Set Minimum Date to Current Date/Time
        window.addEventListener('load', () => {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            datetimeInput.min = now.toISOString().slice(0, 16);
        });

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
    </script>


    <?php
    include 'includes/footer.php';
    // include 'includes/navfooter.php';
    ?>