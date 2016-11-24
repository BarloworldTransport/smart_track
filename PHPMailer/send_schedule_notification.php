<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php
include '../include/databaselogin.php';
require 'PHPMailerAutoload.php';
require("../common.php"); 
$name=htmlentities($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8');
$surname=htmlentities($_SESSION['user']['surname'], ENT_QUOTES, 'UTF-8');
$cc_user=htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8');
$contacts=$_POST['contacts'];
$arrlength = count($contacts);
$sr_number=$_POST['sr_number'];

$sql_get_repair=mysqli_query($con,"SELECT * FROM vehicle_repair_schedule WHERE vehicle_schedule_sr_number='$sr_number'");
$data_get_repair=mysqli_fetch_array($sql_get_repair);


$_content = (string) "";
$_content .= $data_get_repair['vehicle_schedule_vehicle']." has been booked for a telematics repair. Details are as follows : <br><br>";
$_content .= "<table>";
$_content .= "<tr>";
$_content .= "<td>Vehicle</td>";
$_content .= "<td>".$data_get_repair['vehicle_schedule_vehicle']."</td>";
$_content .= "</tr>";
$_content .= "<tr>";
$_content .= "<td>Location</td>";
$_content .= "<td>".$data_get_repair['vehicle_schedule_location']."</td>";
$_content .= "</tr>";
$_content .= "<td>Date and Time</td>";
$_content .= "<td>".$data_get_repair['vehicle_schedule_date']." ".$data_get_repair['vehicle_schedule_time']."</td>";
$_content .= "</tr>";
$_content .= "</table>";
$_content .= "<br>";
$_content .= "Please contact ".$name." ".$surname." (".$cc_user.") if you have any queries or there are any changes.";


//echo $_content;


$mail = new PHPMailer;
//$attachment ='zimbulk/trip/trip_documents/Fuel Orders - Lusaka.pdf';


//$mail->SMTPDebug = 3;                                 // Enable verbose debug output

$mail->isSMTP();                                        // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                 // Enable SMTP authentication
$mail->Username = 'bwt.telematics';                     // SMTP username
$mail->Password = 'kaluma';                             // SMTP password
$mail->SMTPSecure = 'ssl';                              // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                      // TCP port to connect to

$mail->From = 'bwt.telematics@gmail.com';
$mail->FromName = 'BWT Telematics';

for($x = 0; $x < $arrlength; $x++)
{
$sql_email_add=mysqli_query($con,"SELECT contact_name FROM contacts WHERE contact_email='$contacts[$x]'");
$data_email_add=mysqli_fetch_array($sql_email_add);
$email_name=$data_email_add['contact_name'];
$mail->addAddress($contacts[$x], $email_name);
}



   // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('$cc_user');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment($attachment);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Vehicle Repair';
$mail->Body = "Good Day, <br><br>";

$mail->Body .= $_content;
$mail->Body .= "<br><br>Thank you<br><br>Regards,<br> BWT Telematics";
 
                 
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  echo "A schedule notication has been sent.";
  echo " <button class='btn btn-primary' onclick='self.close()'' >Close</button>";
    
	}
?>


 
 
 
 
 
 
 