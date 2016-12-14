<?php
include 'databaselogin.php';

$sql_vehicles = mysqli_query($con, "SELECT vehicle.fleet_number,
    	    vehicle.registration_number 
    	    FROM vehicle 
			WHERE (fleet_number LIKE '%" . $_GET['query'] . "%') 
        `   OR (registration_number LIKE '%" . $_GET['query'] . "%')
			LIMIT 10");
$json = [];
WHILE ($row = mysqli_fetch_array($sql_vehicles)) {
    $json[] = $row['fleet_number'] . " (" . $row['registration_number'] . ")";
}
echo json_encode($json);

/*
 *
 * $sql = "SELECT vehicle.fleet_number FROM vehicle
 * WHERE fleet_number LIKE '%".$_GET['query']."%'
 * LIMIT 10";
 * $result = $mysqli->query($sql);
 *
 * $json = [];
 * while($row = $result->fetch_assoc()){
 * $json[] = $row['fleet_number'];
 * }
 *
 * echo json_encode($json);
 */
?>