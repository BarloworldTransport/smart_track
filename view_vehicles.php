<!DOCTYPE html>
<html lang="en">
<head>
  <title>Vehicle Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
<div class="table-responsive .col-xs-12 .col-sm-6 .col-lg-8">
<table class="table table-bordered table-hover table-striped table-nowrap">
	<thead>
	<tr>
		<th>Vehicle</th>
		<th>Registraion</th>
		<th>FM ID</th>
		<th>Last AVL Time</th>
		<th>Last Download Time</th>
		<th>Skytrack ID</th>
		<th>Skytrack</th>
		<th>Vehicle Odometer</th>
		<th>Latitude</th>
		<th>Longitude</th>
		<th>Fleet Group</th>
		<th>Location</th>
		<th>Status</th>
	</tr>

	</thead>
<tbody>


<?php
$current_date = date("Y-m-d");
$date_check = strtotime ( '-2 day' , strtotime ( $current_date ) ) ;
$date_check = date ( 'Y-m-d' , $date_check );
$date_check_skytrack = strtotime ( '-1 day' , strtotime ( $current_date ) ) ;
$date_check_skytrack = date ( 'Y-m-d' , $date_check_skytrack );
 

echo $date_check;
include 'include/databaselogin.php';
$sql_data=mysqli_query($con,"SELECT skytrack_positions.skytrack_positions_latitude,skytrack_positions.skytrack_positions_longitude,skytrack_positions.skytrack_positions_unit_id,skytrack_positions.skytrack_positions_time,vehicle.fm_id,unit_trip_download.trip_download_fm_odometer,unit_trip_download.trip_download_download_date,vehicle.fleet_number,positions.position_time,vehicle.fleet_group,vehicle.registration_number,positions.position_latitude,positions.position_longitude
	FROM vehicle
	INNER JOIN positions 
	ON positions.position_vehicle_id = vehicle.fm_id
	INNER JOIN unit_trip_download
	ON trip_download_fm_id = vehicle.fm_id
	INNER JOIN skytrack_positions
	ON (skytrack_positions_unit_id = vehicle.vehicle_skytrack_id) OR (skytrack_positions_unit_id IS NULL)
	ORDER BY vehicle.fleet_group
	");
	while ($get_data=mysqli_fetch_array($sql_data)) {
 				$latitude=$get_data['position_latitude'];
				$longitude=$get_data['position_longitude'];
			echo "<tr>";
				echo "<td>". $get_data['fleet_number']."</td>";
				echo "<td>". $get_data['registration_number']."</td>";
				echo "<td>". $get_data['fm_id']."</td>";

				IF ($get_data['position_time'] < $date_check){
						echo "<td class='danger'>". $get_data['position_time']."</td>";
					}
					else{
					echo "<td>". $get_data['position_time']."</td>";
					}

				IF ($get_data['trip_download_download_date'] < $date_check){
						echo "<td class='danger'>". $get_data['trip_download_download_date']."</td>";
					}
					else{
						echo "<td>". $get_data['trip_download_download_date']."</td>";
					}

				IF ($get_data['skytrack_positions_time'] < $date_check_skytrack){
						echo "<td class='danger'>". $get_data['skytrack_positions_time']."</td>";
					}
					else{
					echo "<td>". $get_data['skytrack_positions_time']."</td>";
					}


				echo "<td>". $get_data['skytrack_positions_unit_id']."</td>";
				echo "<td>". $get_data['trip_download_fm_odometer']."</td>";
				echo "<td>". $latitude ."</td>";
				echo "<td>". $longitude ."</td>";
				echo "<td>". $get_data['fleet_group']."</td>";
				
$sql_location = mysqli_query($con,"SELECT location_name FROM locations WHERE ($latitude BETWEEN location_latitude1 AND location_latitude2) AND ($longitude BETWEEN location_longitude1 AND location_longitude2)");
					$location_data =mysqli_fetch_array($sql_location);

				echo "<td>". $location_data['location_name']."</td>";

				IF ($get_data['skytrack_positions_latitude'] >'-22.222224')
				{
				echo "<td>Across Border</td>";
				}
				else
				{
				echo "<td>SA</td>";
				}


			echo "</tr>";
	

	}
?>




	

</tbody>
</table>
</div>
</div>
</body>
</html>