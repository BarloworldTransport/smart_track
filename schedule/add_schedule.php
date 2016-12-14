
<style>
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

.notification_window {
	margin: 70px auto;
	padding: 20px;
	border-radius: 5px;
	width: 70%;
	height: 70%;
	position: relative;
	transition: all 5s ease-in-out;
}
</style>
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<body>
<?php
include "../include/databaselogin.php";
$sr_number = $_POST['unit_fault_sr_number'];

$vehicle = $_POST['fleet_number'];

$repair = $_POST['repair_desc'];

$schedule_date_time = $_POST['schedule_date'];
$schedule_date = substr($schedule_date_time, 0, 10);
$schedule_time = substr($schedule_date_time, 11);

$location = $_POST['repair_location'];

$sql = "INSERT INTO vehicle_repair_schedule(
	vehicle_schedule_sr_number,
	vehicle_schedule_vehicle,
	vehicle_schedule_repair_description,
	vehicle_schedule_date,
	vehicle_schedule_time,
	vehicle_schedule_location
	) VALUES (
	'$sr_number',
	'$vehicle',
	'$repair',
	'$schedule_date',
	'$schedule_time',
	'$location'
	)";

$sql_update = "UPDATE unit_faults SET unit_fault_status='Scheduled',unit_fault_date_scheduled='$schedule_date' WHERE unit_fault_sr_number='$sr_number'";
mysqli_query($con, $sql_update);

if (mysqli_query($con, $sql)) {
    echo "
    <div class='notification_window'>
        <div class='panel-group'>
            <div class='panel panel-default'>
                <div class='panel-heading'> <strong>Vehicle has been scheduled</strong></div>
                <div class='panel-body'>
		              Would you like to send a schedule notification ? <br><br>
            		<a href='notification_form.php?sr_number=" . $sr_number . "'>
                	    <button type='button' class='btn btn-success'>Yes</button>
            	    </a>
            		<button type='button' class='btn btn-danger' id='close'>No</button>
                </div>
            </div>
        </div>";
} else {
    echo "<div class='alert alert-danger fade in'>
              <strong>An Error has occured.</strong>.
          </div>";
}

?>




</body>
<script type="text/javascript">
    $(document).ready(function () {
        $('#close').click(function () {
            window.opener.location.reload(true);
            window.close();
        });
    });
</script>




