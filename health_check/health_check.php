<?php 

    // First we execute our common code to connection to the database and start the session 
    require("../common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: ../index.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can display the user's username to them by reading it from the session array.  Remember that because 
    // a username is user submitted content we must use htmlentities on it before displaying it to the user. 
?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Health Check</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/guage.css">
  <script src="https://code.jquery.com/jquery-1.12.3.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/nav_login.css">
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
width:100%;
}

  </style>
  <script>
$(document).ready(function() {
    $('#health_check').DataTable(


    	);
} );
</script>
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Smart Track</a>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="../index.php">Home</a></li>
                <li class=""><a href="../schedule/fault_list.php">Fault List</a></li>
                <li class=""><a href="../schedule/planning.php">Schedule Board</a></li>
                 <li class=""><a href="../health_check/health_check.php">Health Check</a></li>
            </ul>
           <ul class="nav navbar-nav navbar-right">
           	 <li class="dropdown">
           	 	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        <strong><?php 
                $name=htmlentities($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8');
                $surname=htmlentities($_SESSION['user']['surname'], ENT_QUOTES, 'UTF-8');
                echo $name." ".$surname; 
                ?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?php echo $name." ".$surname;?></strong></p>
                                        <p class="text-left small">
                                        <?php	
                                        echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8');
                                        ?>
                                        </p>
                                      
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider navbar-login-session-bg"></li>
                        <li class="navbar-login-session-bg">
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="../logout.php" class="btn btn-danger btn-block">Logout</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
              
            </ul>
        </div>
    </div>
</div>



<div align="center">
	  <div class="GaugeMeter" id="opened" data-percent="40"  data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="FM Updating" data-style="Full" data-label_color="#FFF"></div>

	  <div class="GaugeMeter" id="opened" data-percent="40"  data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Skytrack Updating" data-style="Full" data-label_color="#FFF"></div>

	  <div class="GaugeMeter" id="completed" data-percent="95" data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Drivecam Updating" data-style="Full" data-label_color="#FFF"></div>

	   <div class="GaugeMeter" id="completed" data-percent="85" data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="MX Updating" data-style="Full" data-label_color="#FFF"></div>

	    <div class="GaugeMeter" id="completed" data-percent="90" data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Beame Updating" data-style="Full" data-label_color="#FFF"></div>

	     <div class="GaugeMeter" id="completed" data-percent="98" data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Vehicle Uptime" data-style="Full" data-label_color="#FFF"></div>
</div>

<div class="table-responsive .col-xs-12 .col-sm-12 .col-md-12 .col-lg-12">
<table class="table table-bordered table-hover table-striped" id="health_check">
	<thead>
	<tr>
		<th>Vehicle</th>
		<th>Registraion</th>
		<th>FM ID</th>
		<th>Last AVL Time</th>
		<th>Last Download Time</th>
		<th>Skytrack ID</th>
		<th>Skytrack</th>
		<th>Drivecam S/N</th>
		<th>Drivecam Status</th>
		<th>MX1 Serial Number</th>
		<th>MX1 Report Date</th>
		<th>BM Serial Number</th>
		<th>BM Report Date</th>
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
 
include '../include/databaselogin.php';
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
				echo "<td>Not Available</td>";
				echo "<td>Not Available</td>";
				echo "<td>Not Available</td>";
				echo "<td>Not Available</td>";
				echo "<td>Not Available</td>";
				echo "<td>Not Available</td>";
				//echo "<td>". $get_data['trip_download_fm_odometer']."</td>";
				//echo "<td>". $latitude ."</td>";
				//echo "<td>". $longitude ."</td>";
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

<script src="../js/guage.js"></script>
<script>
$(".GaugeMeter").gaugeMeter();
</script>

</html>