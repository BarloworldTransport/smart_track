<?php
include 'databaselogin.php';
$vehicle='F437';
$position_sql=mysqli_query($con,"SELECT * from vehicles WHERE vehicle_fleet_number='$vehicle'");
$position_data=mysqli_fetch_array($position_sql);

?>
<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/"></iframe>