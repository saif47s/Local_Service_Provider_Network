<?php
define('MYSITE', true);
include '../db/dbconnect.php';

// Fetch dynamic fuel price
$fuel_price = 7;
$fuel_sql = "SELECT setting_value FROM settings WHERE setting_key = 'fuel_price' LIMIT 1";
$fuel_result = mysqli_query($conn, $fuel_sql);
if ($fuel_result && mysqli_num_rows($fuel_result) > 0) {
    $fuel_row = mysqli_fetch_assoc($fuel_result);
    $fuel_price = (float)$fuel_row['setting_value'];
}

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
                <div class="text-center border rounded bg-light my-4 p-3">
                    <h4 class="mb-2">CART</h4>
                    <span class="badge badge-info p-2" style="font-size: 0.9em;">Note: Fuel price is Rs <?php echo $fuel_price; ?> per kilometer.</span>
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
                                        <td>
                                            <?php echo $value['sp_name']; ?><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($value['sp_location'] ?? ''); ?></small>
                                        </td>
                                        <td>
                                            <small>Rs. </small><?php echo $value['price']; ?>
                                            <input type="hidden" class="iprice" value="<?php echo $value['price']; ?>">
                                            <input type="hidden" class="service-id" value="<?php echo (int) $value['service_id']; ?>">
                                            <input type="hidden" class="sp-id" value="<?php echo (int) $value['sp_id']; ?>">
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


                        <?php
                        $cities = [];
                        $cityResult = mysqli_query($conn, "SELECT city_id, city_name FROM city ORDER BY city_name");
                        if ($cityResult) {
                            while ($cityRow = mysqli_fetch_assoc($cityResult)) {
                                $cities[] = $cityRow;
                            }
                        }
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
                                    <input type="text" class="form-control" pattern="\d{5}" maxlength="5" name="pincode" id="pincode" required
                                        data-correct="<?php echo $db_pincode; ?>"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); validateField(this, 'Pincode mismatch')">
                                    <div class="invalid-feedback">Invalid Pincode (Must match registered pincode)</div>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control" name="city_id" id="city_id" required>
                                        <option value="">Choose City</option>
                                        <?php foreach ($cities as $city): ?>
                                            <option value="<?php echo (int) $city['city_id']; ?>">
                                                <?php echo htmlspecialchars($city['city_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Area / Zone</label>
                                    <select class="form-control" name="area_id" id="area_id" required>
                                        <option value="">Choose Area</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Urgency</label>
                                    <select class="form-control" name="urgency" id="urgency" required>
                                        <option value="normal">Normal</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="emergency">Emergency</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Service Date:-</label>
                                    <input type="datetime-local" class="form-control" name="due_date" id="due_date" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
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
                                <hr>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="fuelTerms" required>
                                    <label class="form-check-label small text-muted" for="fuelTerms">
                                        I agree to pay the additional fuel charges based on the distance from the Service Provider's location to my address.
                                    </label>
                                    <div class="invalid-feedback">You must agree to the fuel charges to place the order.</div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" name="order">Make Order</button>
                                <input type="hidden" id="total" name="total">

                            </form>
                            <hr>
                            <h6>Dynamic Pricing Estimate</h6>
                            <small class="text-secondary d-block mb-2">Live estimate updates on area/urgency/date
                                changes.</small>
                            <div id="estimateSummary" class="small text-muted">Select city, area and urgency to see
                                estimate.</div>
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
            if (gtotal) {
                gtotal.innerText = totalWithCommission.toFixed(0);
            }
            if (document.getElementById("total")) {
                document.getElementById("total").value = totalWithCommission.toFixed(0);
            }
        }

        subTotal();
    </script>

    <script>
        const citySelect = document.getElementById('city_id');
        const areaSelect = document.getElementById('area_id');
        const urgencySelect = document.getElementById('urgency');
        const dueDateInput = document.getElementById('due_date');
        const estimateSummary = document.getElementById('estimateSummary');

        async function loadAreas() {
            if (!citySelect || !areaSelect || !citySelect.value) {
                return;
            }
            const formData = new FormData();
            formData.append('city_id', citySelect.value);
            const response = await fetch('../assets/ajax/get_areas.php', {
                method: 'POST',
                body: formData
            });
            const html = await response.text();
            areaSelect.innerHTML = html || '<option value="">Choose Area</option>';
        }

        async function fetchEstimateForItem(serviceId, spId, qty, basePrice) {
            const areaId = areaSelect ? areaSelect.value : '';
            if (!serviceId || !areaId) {
                return null;
            }
            const body = new FormData();
            body.append('service_id', serviceId);
            if (spId) body.append('sp_id', spId);
            body.append('area_id', areaId);
            body.append('base_price', basePrice);
            body.append('urgency', urgencySelect ? urgencySelect.value : 'normal');
            if (dueDateInput && dueDateInput.value) {
                body.append('request_time', dueDateInput.value.replace('T', ' ') + ':00');
            }

            const response = await fetch('../api/dynamic_pricing/calculate_price.php', {
                method: 'POST',
                body: body
            });
            const data = await response.json();
            if (!data.success) {
                return null;
            }
            return {
                total: (parseFloat(data.data.final_price) || 0) * qty,
                breakdown: data.data.breakdown
            };
        }

        async function refreshDynamicEstimate() {
            if (!estimateSummary) {
                return;
            }
            if (!areaSelect || !areaSelect.value) {
                estimateSummary.innerText = 'Select area to view estimate.';
                return;
            }
            if (!dueDateInput || !dueDateInput.value) {
                estimateSummary.innerText = 'Select service date & time to view estimate.';
                return;
            }

            const serviceIds = document.querySelectorAll('.service-id');
            const spIds = document.querySelectorAll('.sp-id');
            const quantities = document.querySelectorAll('.iquantity');
            const basePrices = document.querySelectorAll('.iprice');
            let total = 0;
            let multiplierNotes = [];

            for (let i = 0; i < serviceIds.length; i++) {
                const serviceId = parseInt(serviceIds[i].value, 10);
                const spId = spIds[i] ? parseInt(spIds[i].value, 10) : null;
                const qty = parseInt(quantities[i].value, 10) || 1;
                const basePrice = parseFloat(basePrices[i].value) || 0;
                const result = await fetchEstimateForItem(serviceId, spId, qty, basePrice);
                if (result !== null) {
                    total += result.total;
                    // Collect significant multipliers (> 1.0)
                    const m = result.breakdown.multipliers;
                    if (m.time > 1) multiplierNotes.push("Peak/Weekend Surcharge");
                    if (m.demand > 1) multiplierNotes.push("High Demand in Area");
                    if (m.urgency > 1) multiplierNotes.push("Urgency Fee");
                    if (m.availability > 1) multiplierNotes.push("Low Provider Availability");
                    if (m.zone > 1) multiplierNotes.push("Zone Premium");
                }
            }

            // Deduplicate notes
            multiplierNotes = [...new Set(multiplierNotes)];
            let notesHtml = multiplierNotes.length > 0 ?
                '<div class="mt-2 text-info">Factors: ' + multiplierNotes.join(', ') + '</div>' : '';

            const commission = total * 0.05;
            const grand = total + commission;
            estimateSummary.innerHTML =
                'Estimated Item Total: <b>Rs. ' + total.toFixed(2) + '</b><br>' +
                'Estimated Platform Fee (5%): <b>Rs. ' + commission.toFixed(2) + '</b><br>' +
                'Estimated Final Total: <b>Rs. ' + grand.toFixed(2) + '</b>' +
                notesHtml;
        }

        if (citySelect) {
            citySelect.addEventListener('change', async function () {
                await loadAreas();
                await refreshDynamicEstimate();
            });
        }
        if (areaSelect) {
            areaSelect.addEventListener('change', refreshDynamicEstimate);
        }
        if (urgencySelect) {
            urgencySelect.addEventListener('change', refreshDynamicEstimate);
        }
        if (dueDateInput) {
            dueDateInput.addEventListener('change', refreshDynamicEstimate);
        }
    </script>


    <!-- date time validation  -->
    <script>
        const datetimeInput = document.getElementById("due_date");
        const errorMessage = document.getElementById("error-message");

        // Set min attribute to current time on page load to prevent selecting past times
        function updateMinDateTime() {
            const now = new Date();
            // Adjust to local ISO string format YYYY-MM-DDTHH:mm
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            datetimeInput.min = minDateTime;
        }

        window.addEventListener('load', updateMinDateTime);

        datetimeInput.addEventListener("change", function () {
            const selectedDatetime = new Date(datetimeInput.value);
            const now = new Date();
            
            if (selectedDatetime < now) {
                errorMessage.textContent = "Please select a future date and time.";
                datetimeInput.setCustomValidity("Please select a future date and time.");
                datetimeInput.classList.add('is-invalid');
                // Optional: Clear value if invalid to force correct selection
                // datetimeInput.value = ""; 
            } else {
                errorMessage.textContent = "";
                datetimeInput.setCustomValidity("");
                datetimeInput.classList.remove('is-invalid');
            }
        });

        // Also check on input for real-time feedback
        datetimeInput.addEventListener("input", function() {
            if(datetimeInput.classList.contains('is-invalid')) {
                const selectedDatetime = new Date(datetimeInput.value);
                if(selectedDatetime >= new Date()) {
                    errorMessage.textContent = "";
                    datetimeInput.setCustomValidity("");
                    datetimeInput.classList.remove('is-invalid');
                }
            }
        });
    </script>
    <script>
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