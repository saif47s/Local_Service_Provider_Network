<?php

include __DIR__ . '/../../../DataBase/dbconnect.php';

header('Content-Type: text/html; charset=UTF-8');

$category_id = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
if ($category_id <= 0) {
    echo '<option value="" selected disabled>select service</option>';
    exit;
}

$servicesql = "SELECT * FROM `service` WHERE category_id = '$category_id' ORDER BY `service_name`";
$result = mysqli_query($conn, $servicesql);

$output = '<option selected disabled>select service</option>';
while($service_row = mysqli_fetch_assoc($result)){
    $output .= '<option value="'.$service_row['service_id'].'">'.$service_row['service_name'].'</option>';
}
echo $output;
?>