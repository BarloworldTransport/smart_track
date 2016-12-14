<!DOCTYPE html>
<html>
<head>
<title>Schedule Notification</title>
<link rel="stylesheet" type="text/css"
	href="../css/pop_style_faults.css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-select.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.js"></script>
<style>
body {
	padding-top: 70px;
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
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f6f8f9+0,e5ebee+6,e5ebee+11,e5ebee+20,e5ebee+20,e5ebee+24,e5ebee+24,d7dee3+30,d7dee3+30,e5ebee+44,e5ebee+53,d7dee3+63,d7dee3+80,e5ebee+87,f5f7f9+100 */
	background: rgb(246, 248, 249); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(246, 248, 249, 1) 0%,
		rgba(229, 235, 238, 1) 6%, rgba(229, 235, 238, 1) 11%,
		rgba(229, 235, 238, 1) 20%, rgba(229, 235, 238, 1) 20%,
		rgba(229, 235, 238, 1) 24%, rgba(229, 235, 238, 1) 24%,
		rgba(215, 222, 227, 1) 30%, rgba(215, 222, 227, 1) 30%,
		rgba(229, 235, 238, 1) 44%, rgba(229, 235, 238, 1) 53%,
		rgba(215, 222, 227, 1) 63%, rgba(215, 222, 227, 1) 80%,
		rgba(229, 235, 238, 1) 87%, rgba(245, 247, 249, 1) 100%);
	/* FF3.6-15 */
	background: -webkit-linear-gradient(top, rgba(246, 248, 249, 1) 0%,
		rgba(229, 235, 238, 1) 6%, rgba(229, 235, 238, 1) 11%,
		rgba(229, 235, 238, 1) 20%, rgba(229, 235, 238, 1) 20%,
		rgba(229, 235, 238, 1) 24%, rgba(229, 235, 238, 1) 24%,
		rgba(215, 222, 227, 1) 30%, rgba(215, 222, 227, 1) 30%,
		rgba(229, 235, 238, 1) 44%, rgba(229, 235, 238, 1) 53%,
		rgba(215, 222, 227, 1) 63%, rgba(215, 222, 227, 1) 80%,
		rgba(229, 235, 238, 1) 87%, rgba(245, 247, 249, 1) 100%);
	/* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, rgba(246, 248, 249, 1) 0%,
		rgba(229, 235, 238, 1) 6%, rgba(229, 235, 238, 1) 11%,
		rgba(229, 235, 238, 1) 20%, rgba(229, 235, 238, 1) 20%,
		rgba(229, 235, 238, 1) 24%, rgba(229, 235, 238, 1) 24%,
		rgba(215, 222, 227, 1) 30%, rgba(215, 222, 227, 1) 30%,
		rgba(229, 235, 238, 1) 44%, rgba(229, 235, 238, 1) 53%,
		rgba(215, 222, 227, 1) 63%, rgba(215, 222, 227, 1) 80%,
		rgba(229, 235, 238, 1) 87%, rgba(245, 247, 249, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9',
		endColorstr='#f5f7f9', GradientType=0); /* IE6-9 */
	border-radius: 5px;
	width: 90%;
	height: 70%;
	position: relative;
	transition: all 5s ease-in-out;
}

#loading {
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	top: 0;
	left: 0;
	position: fixed;
	opacity: 0.7;
	background-color: #fff;
	z-index: 150;
	text-align: center;
}

#loading-image {
	width: 500px;
	height: 200px;
}

#message {
	border: 1px solid #E9EAEE;
	padding: 10px;
	width: 600px;
	height: 150px;
}
</style>
</head>
<body>
 <?php
include "../include/databaselogin.php";
$sr_number = $_GET['sr_number'];
$sql_message = mysqli_query($con, "SELECT * FROM  vehicle_repair_schedule WHERE vehicle_schedule_sr_number='$sr_number'");
$data_message = mysqli_fetch_array($sql_message);
$email_message = "Vehicle : " . $data_message['vehicle_schedule_vehicle'] . "<br>Date and Time : " . $data_message['vehicle_schedule_date'] . " " . $data_message['vehicle_schedule_time'] . "<br>
Location : " . $data_message['vehicle_schedule_location'] . "<br>";
?>
 <div id="loading" style="display: none; align: center;">
		<img src="sending_email.gif" id="loading_image">
	</div>
	<div class="notification_window">
		<div class="panel panel-primary">
			<div class="panel-heading ">Send Notification</div>
			<div class="panel-body">
				<form class="schedule_notification" name="schedule_notification"
					method="post" action="../PHPMailer/send_schedule_notification.php">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">To :</div>
							<select id="unit_fault_unit_type"
								class=" form-control selectpicker" multiple
								data-live-search="true" name="contacts[]"
								Title="Please select a contact" required>
                                <?php
                                $sql_contact = mysqli_query($con, "SELECT * FROM contacts");
                                WHILE ($get_contact = mysqli_fetch_array($sql_contact)) {
                                    echo "<option value='" . $get_contact['contact_email'] . "'>" . $get_contact['contact_name'] . " (" . $get_contact['contact_fleet'] . ")</option>";
                                }
                                ?>
                    		</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Message</div>
							<div id="message"><?php echo $email_message; ?></div>
						</div>
					</div>
					<input type="hidden" name="sr_number"
						value="<?php echo $sr_number ?>">
				</form>
			</div>
		</div>
		<button class="btn btn-success" type="submit" id="send">Send
			Notification</button>
		<button class="btn btn-primary" onclick="self.close()">Close</button>
	</div>
</body>
<script language="javascript" type="text/javascript">
    $('#schedule_notification').submit(function() {
        $('#loading').show(); // show animation
        return true; // allow regular form submission
    });
</script>
</html>
