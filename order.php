<?php
session_start();
include 'DataBase/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['order'])) {
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
                        echo "<script>
            window.location.href = 'login.php';
            </script>";
                        exit;
                } else {
                        // Get Customer Details
                        $customer_id = $_SESSION['customer_id'];
                        $full_name = mysqli_real_escape_string($conn, $_POST['fullname']);
                        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                        $address = mysqli_real_escape_string($conn, $_POST['address']) . " - " . mysqli_real_escape_string($conn, $_POST['pincode']);
                        $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
                        $pay_mode = mysqli_real_escape_string($conn, $_POST['pay_mode']);
                        $order_date = date('Y-m-d H:i:s');

                        // Calculate Totals form Session Cart
                        $total_price = 0;
                        if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $key => $values) {
                                        $total_price += ($values['quantity'] * $values['price']);
                                }
                        }

                        // Commission (Platform Fee 5%)
                        $commission = $total_price * 0.05;
                        $grand_total = $total_price + $commission;

                        // Insert into order_master
                        $sql1 = "INSERT INTO `order_master`(`customer_id`, `full_name`, `phone`, `address`, `pay_mode`, `order_date`, `due_date`, `total`, `commission`, `status`) 
                     VALUES ('$customer_id','$full_name','$phone','$address','$pay_mode','$order_date','$due_date','$grand_total', '$commission', 'Pending')";

                        if (mysqli_query($conn, $sql1)) {
                                $order_id = mysqli_insert_id($conn);

                                // Insert into user_order (Items)
                                foreach ($_SESSION['cart'] as $key => $values) {
                                        $service_title = mysqli_real_escape_string($conn, $values['service_title']);
                                        $price = $values['price'];
                                        $qty = $values['quantity'];
                                        $sp_id = $values['sp_id'];

                                        $sql2 = "INSERT INTO `user_order`(`order_id`, `service_title`, `price`, `qty`, `status`, `sp_id`) 
                             VALUES ('$order_id','$service_title','$price','$qty','Pending','$sp_id')";
                                        mysqli_query($conn, $sql2);

                                        // ==============================
                                        // WALLET DEDUCTION LOGIC
                                        // ==============================
                                        // Calculate deduction for this specific item/SP
                                        // Assuming 5% platform fee is shared across items based on value
                                        $item_total = $price * $qty;
                                        $item_commission = $item_total * 0.05;

                                        // Deduct from SP Wallet
                                        $update_wallet = "UPDATE sp SET wallet_balance = wallet_balance - $item_commission WHERE sp_id = '$sp_id'";
                                        mysqli_query($conn, $update_wallet);

                                        // Log Transaction
                                        $txn_desc = "Commission for Order #$order_id ($service_title)";
                                        $txn_sql = "INSERT INTO wallet_transactions (sp_id, amount, type, status, description, created_at) 
                                VALUES ('$sp_id', '$item_commission', 'debit', 'approved', '$txn_desc', NOW())";
                                        mysqli_query($conn, $txn_sql);
                                }

                                // Clear Cart
                                unset($_SESSION['cart']);

                                // Redirect to Success / Invoice
                                echo "<script>
                alert('Order Placed Successfully! Commission deducted from SP.');
                window.location.href = 'customer/customer_index.php';
                </script>";
                        } else {
                                echo "<script>
                alert('SQL Error: " . mysqli_error($conn) . "');
                window.location.href = 'mycart.php';
                </script>";
                        }
                }
        }
}
?>