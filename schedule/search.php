<?php
$dbHost = 'localhost';
  $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'kaluma';
    $dbName = 'smart_track';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT * FROM vehicles WHERE vehicle_fleet_number LIKE '%".$searchTerm."%' ORDER BY vehicle_fleet_number ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['vehicle_fleet_number'];
}
//return json data
echo json_encode($data);


?>