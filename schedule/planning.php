<?php

// First we execute our common code to connection to the database and start the session
require ("../common.php");

// At the top of the page we check to see whether the user is logged in or not
if (empty($_SESSION['user'])) {
    // If they are not, we redirect them to the login page.
    header("Location: ../index.php");
    
    // Remember that this die statement is absolutely critical. Without it,
    // people can view your members-only content without logging in.
    die("Redirecting to login.php");
}

// Everything below this point in the file is secured by the login system

// We can display the user's username to them by reading it from the session array. Remember that because
// a username is user submitted content we must use htmlentities on it before displaying it to the user.
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Repair Scheduling</title>
<link rel="stylesheet" type="text/css" href="../css/pop_style.css">
<link rel="stylesheet" type="text/css" href="../css/style_scheduler.css">
<link rel="stylesheet" type="text/css"
	href="../css/jquery.datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="../css/nav_login.css">
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<script type="text/javascript">
        function change_week () {
         	var date = document.getElementById("date_selector").value;
            if (date == "") {
                document.getElementById("container").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("container").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","week_change.php?date_selction="+date,true);
                xmlhttp.send();
            }
        }
        
        function get_repair_details () {
         	var vehicle = document.getElementById("fleet_number").value;
            if (vehicle == "") {
                document.getElementById("repair_info").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("repair_info").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","get_repair_details.php?vehicle="+vehicle,true);
                xmlhttp.send();
            }
        }
        
        </script>
<style type="text/css">
body {
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#4c4c4c+0,595959+12,666666+25,474747+39,2c2c2c+50,000000+51,111111+60,2b2b2b+76,1c1c1c+91,131313+100;Black+Gloss+%231 */
	background: rgb(76, 76, 76); /* Old browsers */
	background: -moz-linear-gradient(-45deg, rgba(76, 76, 76, 1) 0%,
		rgba(89, 89, 89, 1) 12%, rgba(102, 102, 102, 1) 25%,
		rgba(71, 71, 71, 1) 39%, rgba(44, 44, 44, 1) 50%, rgba(0, 0, 0, 1) 51%,
		rgba(17, 17, 17, 1) 60%, rgba(43, 43, 43, 1) 76%, rgba(28, 28, 28, 1)
		91%, rgba(19, 19, 19, 1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(-45deg, rgba(76, 76, 76, 1) 0%,
		rgba(89, 89, 89, 1) 12%, rgba(102, 102, 102, 1) 25%,
		rgba(71, 71, 71, 1) 39%, rgba(44, 44, 44, 1) 50%, rgba(0, 0, 0, 1) 51%,
		rgba(17, 17, 17, 1) 60%, rgba(43, 43, 43, 1) 76%, rgba(28, 28, 28, 1)
		91%, rgba(19, 19, 19, 1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(135deg, rgba(76, 76, 76, 1) 0%,
		rgba(89, 89, 89, 1) 12%, rgba(102, 102, 102, 1) 25%,
		rgba(71, 71, 71, 1) 39%, rgba(44, 44, 44, 1) 50%, rgba(0, 0, 0, 1) 51%,
		rgba(17, 17, 17, 1) 60%, rgba(43, 43, 43, 1) 76%, rgba(28, 28, 28, 1)
		91%, rgba(19, 19, 19, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c',
		endColorstr='#131313', GradientType=1);
	/* IE6-9 fallback on horizontal gradient */
}
</style>
</head>
<body>
    	<?php include '../include/databaselogin.php'; ?>
    	<div id="container">
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" data-target="#navbarCollapse"
						data-toggle="collapse" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">Smart Track</a>
				</div>
				<!-- Collection of nav links and other content for toggling -->
				<div id="navbarCollapse" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="../index.php">Home</a></li>
						<li class=""><a href="../schedule/fault_list.php">Fault List</a></li>
						<li class=""><a href="../schedule/planning.php">Schedule Board</a></li>
						<li class=""><a href="../health_check/health_check.php">Health
								Check</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown"><a href="#" class="dropdown-toggle"
							data-toggle="dropdown"> <span class="glyphicon glyphicon-user"></span>
								<strong><?php
        $name = htmlentities($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8');
        $surname = htmlentities($_SESSION['user']['surname'], ENT_QUOTES, 'UTF-8');
        echo $name . " " . $surname;
        ?>
                                    </strong> 
                                    <span
								class="glyphicon glyphicon-chevron-down"></span>
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
												<p class="text-left">
													<strong><?php echo $name." ".$surname;?></strong>
												</p>
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

		<div id="popup1" class="overlay">
			<div class="popup">
				<h2>Repair details</h2>
				<a class="close" href="#">&times;</a>
				<div id="content">
					Repair Status<input type="text" id="update_status">
				</div>
			</div>
		</div>

		<div id="new_repair" class="overlay_new_repair">

			<div class="popup_new_repair">
				<a class="close" href="#">&times;</a>
				<div class="new_repair_content">
					<div class="panel panel-default">
						<div class="panel-heading">Add New Repair</div>
						<div class="panel-body">
							<form class="contact" name="contact" action="">

								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">Vehicles</div>
										<input type="text" class="form-control" id="fleet_number"
											placeholder="Enter Vehicle">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">Location</div>
										<input type="text" class="form-control" id="location"
											placeholder="Enter Location">
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">Date</div>
										<input type="date" class="form-control"
											id="exampleInputAmount">
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">Repair</div>
										<textarea class="form-control" id="exampleTextarea" rows="3"
											cols=""></textarea>
									</div>
								</div>

								<select class="js-data-example-ajax">
									<option value="3620194" selected="selected">select2/select2</option>
								</select>
								<div class="panel panel-default">
            						<div class="panel-heading">Repair Details</div>
            						<div class="panel-body">
            							<div id="repair_info">test</div>
            						</div>
            					</div>
            					<div class="modal-footer">
            						<input class="btn btn-success btn-lg btn-block" type="submit"
            							value="Save" id="submit">
            					</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
            <?php
            $date = date("Y/m/d");
            ?>
            <div id="heading">
			<input type="date" id="date_selector" onchange="change_week()"
				placeholder="Date" value='&lt;?php echo $date ?&gt;'> 
			<a class='button' href='#new_repair' title='View More'>
				<button type="button" class="btn btn-alert">Add Repair</button>
			</a>
		</div>

		<table class="table table-responsive">
			<tr>
                    <?php
                    include '../include/databaselogin.php';
                    date_default_timezone_set("Africa/Johannesburg");
                    // $current_day=$_GET['date_selection'];
                    
                    $day_check = date('l', strtotime($date));
                    If ($day_check == 'Sunday') {
                        $week_start = date("Y-m-d", strtotime('last week', strtotime($date)));
                    } else {
                        $week_start = date("Y-m-d", strtotime('monday this week', strtotime($date)));
                    }
                    for ($x = 0; $x <= 6; $x ++) {
                        echo "<td align='center'>";
                        If ($date == date('Y-m-d', strtotime($week_start . ' + ' . $x . 'days'))) {
                            echo "<div class ='selection'>";
                            $day = date('Y-m-d', strtotime($week_start . ' + ' . $x . 'days'));
                            echo "<h4>" . $day . "</h4>";
                            echo "<h4>";
                            echo date('l', strtotime($day));
                            echo "</h4></div>";
                        } else {
                            echo "<div class ='top'>";
                            $day = date('Y-m-d', strtotime($week_start . ' + ' . $x . 'days'));
                            echo "<h4>" . $day . "</h4>";
                            echo "<h4>";
                            echo date('l', strtotime($day));
                            echo "</h4></div>";
                        }
                        echo "<div class='day_lanes'>";
                        $get_repair_sql = mysqli_query($con, "SELECT * FROM vehicle_repair_schedule WHERE (vehicle_schedule_date='$day')");
                        while ($get_repair_data = mysqli_fetch_array($get_repair_sql)) {
                            echo "<div class='repair_box'>";
                            echo "<h4>";
                            echo " Vehicle : " . $get_repair_data['vehicle_schedule_vehicle'] . " <br>";
                            echo "Location : " . $get_repair_data['vehicle_schedule_location'] . "<br>";
                            echo "Time : " . $get_repair_data['vehicle_schedule_time'] . "<br>";
                            echo "</h4>";
                            echo " <a class='button' href='#popup1' > <img src ='../res/icon_info.png'  Title='Info'></img></a>";
                            echo "<a class='button' href='#popup1' Title='View More'> <img src ='../res/icon_info.png'Title=''></img></a>";
                            echo "</div>";
                        }
                        echo "</td>";
                    }
                    echo "</div>";
                    ?>
    			</tr>
		</table>
	</div>

	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"
		type="text/javascript"></script>
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
		type="text/javascript"></script>

	<script type="text/javascript">
            /* must apply only after HTML has loaded */
            $(document).ready(function () {
                $("#new_repair").on("submit", function(e) {
                    var postData = $(this).serializeArray();
                    var formURL = $(this).attr("action");
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        data: postData,
                        success: function(data, textStatus, jqXHR) {
                            $('#contact_dialog .modal-header .modal-title').html("Result");
                            $('#contact_dialog .modal-body').html(data);
                            $("#submitForm").remove();
                        },
                        error: function(jqXHR, status, error) {
                            console.log(status + ": " + error);
                        }
                    });
                    e.preventDefault();
                });
                 
                $("#submitForm").on('click', function() {
                    $("#new_repair").submit();
                });
            });
        </script>


</body>

</html>

