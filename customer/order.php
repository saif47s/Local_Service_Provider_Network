<?php
session_start();
include '../db/dbconnect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['order'])) {
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                        // header("location: ../login.php");
                        echo "<script>
                        window.location.href = '../login.php';
                        </script>";
                        exit;
                } else {

                        $customer_id = $_SESSION['customer_id'];
                        $full_name = $_POST['full_name'];
                        $phone = $_POST['phone'];
                        $address = $_POST['address'];
                        $pincode = $_POST['pincode'];
                        $pay_mode = $_POST['pay_mode'];
                        date_default_timezone_set('Asia/Kolkata');
                        $order_date = date('Y-m-d h:i:s');
                        $order_date = date('Y-m-d h:i:s');
                        $due_date = $_POST['due_date'];
                        // $total = $_POST['total']; 

                        // Recalculate total to ensure security and calculate commission
                        $base_total = 0;
                        if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $key => $value) {
                                        $base_total += ($value['price'] * $value['quantity']);
                                }
                        }
                        $commission = $base_total * 0.05;
                        $commission = $base_total * 0.05;
                        // Fuel Charge Removed
                        $total = $base_total + $commission; // Total to save (Base + 5%)

                        $masterquery = "INSERT INTO `order_master`(`customer_id`, `full_name`, `phone`, `address`, `pincode`, `pay_mode`,`total`, `commission`, `order_date`, `due_date`) VALUES ($customer_id, '$full_name','$phone','$address','$pincode','$pay_mode','$total', '$commission', '$order_date', '$due_date')";
                        $result = mysqli_query($conn, $masterquery);
                        if ($result) {
                                $order_id = mysqli_insert_id($conn);
                                $query2 = "INSERT INTO `user_order`(`order_id`, `service_id`, `sp_id`, `service_title`, `price`, `qty`, `status`) VALUES (?,?,?,?,?,?,?)";
                                $stmt = mysqli_prepare($conn, $query2);
                                // if query prepare ho gayi ho to ...
                                if ($stmt) {
                                        mysqli_stmt_bind_param($stmt, "iiissis", $order_id, $service_id, $sp_id, $service_title, $price, $quantity, $status);
                                        foreach ($_SESSION['cart'] as $key => $value) {
                                                $service_id = $value['service_id'];
                                                $sp_id = $value['sp_id'];
                                                $service_title = $value['service_title'];
                                                $price = $value['price'];
                                                $quantity = $value['quantity'];
                                                $status = "pending";
                                                mysqli_stmt_execute($stmt);
                                        }
                                        unset($_SESSION['cart']);
                                        // alert("Order Placed");
                                        echo '
                                        <script>
                                                window.location.href="order_placed.php?order_id=' . $order_id . '&customer_id=' . $customer_id . '";
                                        </script>';
                                } else {
                                        echo '
                                        <script>
                                                alert("SQL Query prepare Error");
                                                window.location.href="mycart.php";
                                        </script>';
                                }
                        } else {
                                echo '
                                <script>
                                        alert("SQL Error");
                                        window.location.href="mycart.php";
                                </script>';
                        }

                        $sp_id = $_POST['sp_id'];
                        $service_id = $_POST['service_id'];

                        $quantity = $_POST['quantity'];
                        $service_title = $_POST['service_title'];
                }
        }
}
