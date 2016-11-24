<!DOCTYPE html>
<html lang="en">
<head>
  <title>Vehicle Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-1.12.3.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
 
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
body {
	padding-top: 70px;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#4c4c4c+0,595959+12,666666+25,474747+39,2c2c2c+50,000000+51,111111+60,2b2b2b+76,1c1c1c+91,131313+100;Black+Gloss+%231 */
background: rgb(76,76,76); /* Old browsers */
background: -moz-linear-gradient(-45deg, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(44,44,44,1) 50%, rgba(0,0,0,1) 51%, rgba(17,17,17,1) 60%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
th {
    background-color:  #337ab7;
    color: white;
    text-align: center;
  } 
td{
	text-align: center;
}
div.dataTables_wrapper {
	padding: 10px;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f2f6f8+0,d8e1e7+50,b5c6d0+51,e0eff9+100;Grey+Gloss+%232 */
background: rgb(242,246,248); /* Old browsers */
background: -moz-linear-gradient(-45deg, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 50%, rgba(181,198,208,1) 51%, rgba(224,239,249,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f6f8', endColorstr='#e0eff9',GradientType=1 ) 
}

  </style>
</head>
<body>

<div class="table-responsive .col-xs-12 .col-sm-6 .col-lg-8">
<table class="table table-bordered table-hover table-striped table-nowrap" id="health_check">
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
 
include 'include/databaselogin.php';
$sql_data=mysqli_query($con,"SELECT skytrack_positions.skytrack_positions_latitude,skytrack_positions.skytrack_positions_longitude,skytrack_positions.skytrack_positions_unit_id,skytrack_positions.skytrack_positions_time,vehicle.fm_id,unit_trip_download.trip_download_fm_odometer,unit_trip_download.trip_download_download_date,vehicle.fleet_number,positions.position_time,vehicle.fleet_group,vehicle.registration_number,positions.position_latitude,positions.position_longitude
	FROM vehicle
	INNER JOIN positions 
	ON positions.position_vehicle_id = vehicle.fm_id
	INNER JOIN unit_trip_download
	ON trip_download_fm_id = vehicle.fm_id
	INNER JOIN skytrack_positions
	ON (skytrack_positions_unit_id = vehicle.vehicle_skytrack_id)
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

</body>
<script>
$(document).ready(function() {
    $('#health_check').DataTable(


    	);
} );
</script>
</html>