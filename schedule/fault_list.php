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
  <title>Vehicle Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="stylesheet" href="../css/guage.css">
   <link rel="stylesheet" type="text/css" href="../css/pop_style_faults.css">
   <link rel="stylesheet" type="text/css" href="../css/nav_login.css">
 <script src="https://code.jquery.com/jquery-1.12.3.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
 
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#vehicle_faults').DataTable(

   	);
} );

function schedule_pop_up (c) {
window.open(c,
'window',
'width=1000,height=900,scrollbars=yes,status=yes');
}

function update_pop_up (c) {
window.open(c,
'window',
'width=1000,height=900,scrollbars=yes,status=yes');
}
</script>
 

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






<?php
include '../include/databaselogin.php';
$sql_count_open=mysqli_query($con,"SELECT COUNT(unit_fault_sr_number) AS open_count 
	FROM unit_faults 
	WHERE unit_fault_status='Open'");
$sql_count_scheduled=mysqli_query($con,"SELECT COUNT(unit_fault_sr_number) AS total_count 
  FROM unit_faults 
  WHERE unit_fault_status='Scheduled' ");
$data_count_open=mysqli_fetch_array($sql_count_open);
$data_count_scheduled=mysqli_fetch_array($sql_count_scheduled);
$open_faults= $data_count_open['open_count'];
$scheduled_faults= $data_count_scheduled['total_count'];
$open_percentage=ROUND(($open_faults/($scheduled_faults+$open_faults)*100),0);
$scheduled_percentage=ROUND(($scheduled_faults/($scheduled_faults+$open_faults)*100),0);
?>
<div align="center">
	  <div class="GaugeMeter" id="opened" data-percent="<?php echo $scheduled_percentage; ?>"   data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Opened" data-style="Full" data-label_color="#FFF"></div>

	  <div class="GaugeMeter" id="opened" data-percent="<?php echo $open_percentage; ?>"  data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Opened" data-style="Full" data-label_color="#FFF"></div>

	  <div class="GaugeMeter" id="completed" data-percent="10" data-append="%" data-size="200" data-theme="DarkBlue-LightBlue" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="Completed" data-style="Full" data-label_color="#FFF"></div>
	</div>
<button class="btn btn-success" data-toggle="modal" data-target="#add_new_record_modal">Add New Record</button>
   <br>    
    <br>   




<div class="table-responsive .col-xs-12 .col-sm-6 .col-lg-8">
<table class="table table-bordered table-hover table-striped table-nowrap" id="vehicle_faults">
	<thead>
	<tr>
		<th></th>
		<th>SR Number</th>
		<th>Vehicle</th>
		<th>Registration Number</th>
		<th>Fleet</th>
		<th>Unit Type</th>
		<th>Fault Description</th>
		<th>Date Logged</th>
		<th>Days Opened</th>
		<th>Date Scheduled</th>
		<th>Date Completed</th>
		<th>Comments</th>
		<th>Status</th>
		
		
	</tr>

	</thead>
<tbody>


<?php
$current_date = date("Y-m-d");
$sql_data=mysqli_query($con,"SELECT * FROM unit_faults");
	while ($get_data=mysqli_fetch_array($sql_data)) {
		$days_open=((strtotime($current_date) - strtotime($get_data['unit_fault_date_logged']))/86400);
		IF ($get_data['unit_fault_status']=='Open')
			{
			echo "<tr class='danger'>";
			}
				elseif  ($get_data['unit_fault_status']=='Scheduled')
				{
				echo "<tr class='warning'>";
				}
					Else
						{
						echo "<tr class='success'>";
						}
							echo " <td><div class='btn-group'>
           <button class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown' align='center'><i class='fa fa-bars'></i> <span class='glyphicon glyphicon-wrench'></span></button>
        
              <ul class='dropdown-menu ' role='menu'>";
              IF ($get_data['unit_fault_status'] == 'Scheduled')
              {
                echo "<li><a href='schedule_window.php?sr_number=".$get_data['unit_fault_sr_number']."' onclick='schedule_pop_up(this.href); return false'> <img src='../images/icons/calender_icon.jpg' width='24px'> Reschedule</a></li>";
              }
              Else
              {
                echo "<li><a href='schedule_window.php?sr_number=".$get_data['unit_fault_sr_number']."' onclick='schedule_pop_up(this.href); return false'> <img src='../images/icons/calender_icon.jpg' width='24px'> Schedule</a></li>";
              }

              	
                echo " <li><a href='update_fault.php?sr_number=".$get_data['unit_fault_sr_number']."' onclick='update_pop_up(this.href); return false'> <img src='../images/icons/edit_icon.jpg' width='24px'> Edit</a></li>
                  <li><a href='#'' onClick ='$('#trip_table').tableExport({type:'excel',escape:'false'});'> <img src='../images/icons/delete_icon.jpg' width='24px'> Delete</a></li>  
           
              </ul>
             
            </div></td>";
						echo "<td>". $get_data['unit_fault_sr_number']."</td>";
						echo "<td>". $get_data['unit_fault_fleet_number']."</td>";
						echo "<td>". $get_data['unit_fault_registration_number']."</td>";
						echo "<td>". $get_data['unit_fault_fleet']."</td>";
						echo "<td>". $get_data['unit_fault_unit_type']."</td>";
						echo "<td>". $get_data['unit_fault_fault_desc']."</td>";
						echo "<td>". $get_data['unit_fault_date_logged']."</td>";
					IF ($days_open > 3)
					{
						echo "<td style='bgcolor:'red';'><b>". $days_open."</b></td>";
					}
					Else
					{
						echo "<td>". $days_open."</td>";
					}
						echo "<td>". $get_data['unit_fault_date_scheduled']."</td>";
						echo "<td>". $get_data['unit_fault_date_completed']."</td>";
						echo "<td>". $get_data['unit_fault_comments']."</td>";
						echo "<td>". $get_data['unit_fault_status']."</td>";

					


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