<?php
include '../DataBase/dbconnect.php';

if (isset($_POST['city_id'])) {
    $city_id = $_POST['city_id'];
    $sql = "SELECT * FROM `area` WHERE city_id = $city_id";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        // Output for datalist: value is the name
        echo '<option value="' . $row['area_name'] . '">';
    }
}
?>