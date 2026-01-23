<?php
include '../DataBase/dbconnect.php';
session_start();

// if (isset($_GET['approve']) && isset($_GET[''])) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // APPROVE BUTTON PRESS CODE
    if (isset($_POST['approve'])) {
        $order_id = $_POST['order_id'];
        $sp_id = $_POST['sp_id'];
        $status = $_POST['status'];
        $service_id = $_POST['service_id'];

        $sql1 = "UPDATE `user_order` SET `status` = 'inprogress' WHERE `user_order`.`order_id` = $order_id AND `user_order`.`service_id` = $service_id AND `user_order`.`sp_id` = $sp_id";
        $result1 = mysqli_query($conn, $sql1);
        if ($result1) {
            $_SESSION['status_done'] = "Order Approved.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        } else {
            $_SESSION['status_undone'] = "Order not Approved.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        }
    }


    // REJECT BUTTON PRESS CODE
    if (isset($_POST['reject'])) {
        $order_id = $_POST['order_id'];
        $sp_id = $_POST['sp_id'];
        $status = $_POST['status'];
        $service_id = $_POST['service_id'];

        $sql2 = "UPDATE `user_order` SET `status` = 'rejected' WHERE `user_order`.`order_id` = $order_id AND `user_order`.`service_id` = $service_id AND `user_order`.`sp_id` = $sp_id";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {
            $_SESSION['status_done'] = "Order Rejected.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        } else {
            $_SESSION['status_undone'] = "Order not Rejected.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        }
    }


    // COMPLETED BUTTON PRESS CODE
    if (isset($_POST['completed'])) {
        $order_id = $_POST['order_id'];
        $sp_id = $_POST['sp_id'];
        $status = $_POST['status'];
        $service_id = $_POST['service_id'];

        $sql3 = "UPDATE `user_order` SET `status` = 'completed' WHERE `user_order`.`order_id` = $order_id AND `user_order`.`service_id` = $service_id AND `user_order`.`sp_id` = $sp_id";
        $result3 = mysqli_query($conn, $sql3);
        if ($result3) {

            // WALLET DEDUCTION LOGIC
            // 1. Get Order Total
            $price_sql = "SELECT total FROM order_master WHERE order_id = $order_id";
            $price_res = mysqli_query($conn, $price_sql);
            $price_row = mysqli_fetch_assoc($price_res);
            $total_amount = $price_row['total'];

            // 2. Calculate Commission (10%)
            $commission = $total_amount * 0.10;

            // 3. Deduct from SP Wallet
            $wallet_sql = "UPDATE sp SET wallet_balance = wallet_balance - $commission WHERE sp_id = $sp_id";
            mysqli_query($conn, $wallet_sql);

            // 4. Update Commission in Order Master (for Admin Revenue)
            $comm_sql = "UPDATE order_master SET commission = $commission WHERE order_id = $order_id";
            mysqli_query($conn, $comm_sql);

            $_SESSION['status_done'] = "Order Completed.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        } else {
            $_SESSION['status_undone'] = "Order not Completed.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        }
    }

    //UNCOMPLETED BUTTON PRESS CODE
    if (isset($_POST['uncompleted'])) {
        $order_id = $_POST['order_id'];
        $sp_id = $_POST['sp_id'];
        $status = $_POST['status'];
        $service_id = $_POST['service_id'];

        $sql4 = "UPDATE `user_order` SET `status` = 'uncompleted' WHERE `user_order`.`order_id` = $order_id AND `user_order`.`service_id` = $service_id AND `user_order`.`sp_id` = $sp_id";
        $result4 = mysqli_query($conn, $sql4);
        if ($result4) {
            $_SESSION['status_done'] = "Order Uncompleted.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        } else {
            $_SESSION['status_undone'] = "Order not Uncompleted.";
            header("location: order_details.php?order_id= $order_id &sp_id= $sp_id");
        }
    }



}


