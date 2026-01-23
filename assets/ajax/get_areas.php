<?php
include '../../db/dbconnect.php';

if (isset($_POST['city_id']) || isset($_POST['city_name'])) {

    $city_id = $_POST['city_id'] ?? null;
    $city_name = $_POST['city_name'] ?? null;

    if (!$city_id && $city_name) {
        $sql = "SELECT city_id FROM city WHERE city_name = '$city_name'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $city_id = $row['city_id'];
        }
    }

    if ($city_id) {
        $sql = "SELECT * FROM area WHERE city_id = $city_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<option value="">Choose Area</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['area_id'] . '">' . $row['area_name'] . '</option>';
            }
        } else {
            echo '<option value="">No areas found</option>'; // Or leave empty/default
        }
    }
}
?>