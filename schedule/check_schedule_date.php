 <!DOCTYPE html>
 <html>

 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 </head>
 <body>
  <div class="panel panel-primary">
    <div class="panel-heading ">Bookings</div>
      <div class="panel-body">
 <?php
$date=$_GET['date'];
include "../include/databaselogin.php";
$sql_data=mysqli_query($con,"SELECT * FROM vehicle_repair_schedule WHERE vehicle_schedule_date='$date'");
IF (mysqli_num_rows($sql_data) > 0)
{
echo "<h5>The following vehicles have been booked for ".$date." :</h5> <br>";
echo "<table class='table table-bordered table-hover table-striped table-nowrap'>
<thead>
	<tr>
		<th>Vehicle</th>
		<th>Repair Description</th>
		<th>Location</th>
		<th>Time</th>
	</tr> 
	</thead><tbody>";


WHILE ($get_data=mysqli_fetch_array($sql_data))
{
	echo "<tr>";
	echo "<td>".$get_data['vehicle_schedule_vehicle']."</td>";
	echo "<td>".$get_data['vehicle_schedule_repair_description']."</td>";
	echo "<td>".$get_data['vehicle_schedule_location']."</td>";
	echo "<td>".$get_data['vehicle_schedule_time']."</td>";
	echo "</tr>";
}



echo "</tbody></table>";
}
Else 

{
	echo "No Vehicles booked for this day.";
}
?>
</div>
</div>

 </body>
 </html>
