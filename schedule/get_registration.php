<?php
include "../include/databaselogin.php";
$fleet_number=$_GET['fleet_number'];

$sql_reg_number=mysqli_query($con,"SELECT registration_number,fleet_group FROM vehicle WHERE fleet_number='$fleet_number'");
$data_reg_number=mysqli_fetch_array($sql_reg_number);
echo $data_reg_number['registration_number'].";".$data_reg_number['fleet_group'];

?>