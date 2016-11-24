<?php
include '../include/databaselogin.php'; 
$vehicle=$_GET['vehicle'];
$repair_sql=mysqli_query($con,"SELECT * FROM vehicle_repairs WHERE vehicle_repair_fleet_number='$vehicle'");
IF(mysqli_num_rows($repair_sql) == 0)
	{
	echo "No SR found for ".$vehicle.". Please click to add a SR.";
	}
ELSE 
	{
	$repair_data=mysqli_fetch_array($repair_sql);
	echo "SR Number : ".$repair_data['vehicle_repair_SR_number']."<br>";
	echo "Vehicle : ".$repair_data['vehicle_repair_fleet_number']."<br>";
	echo "Unit : ".$repair_data['vehicle_repair_unit']."<br>";
	echo "Repair Description : ".$repair_data['vehicle_repair_description']."<br>";
	}

?>
