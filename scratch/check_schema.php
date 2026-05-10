<?php
include 'DataBase/dbconnect.php';

echo "--- SP Columns ---\n";
$res = mysqli_query($conn, "SHOW COLUMNS FROM sp");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}

echo "\n--- SP Sample Data ---\n";
$res = mysqli_query($conn, "SELECT sp_id, sp_name, city_id, area, status FROM sp LIMIT 5");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}

echo "\n--- Area Table Sample ---\n";
$res = mysqli_query($conn, "SELECT * FROM area LIMIT 5");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
