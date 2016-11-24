<?php 

   
    require("../common.php"); 
     
    
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: ../index.php"); 
         
   
        die("Redirecting to login.php"); 
    } 
     
   
?> 
<html>
<head>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
   <script src="export/tableExport.js"></script>
   <script src="export/jquery.base64.js"></script>
 	<script src="export/jspdf/libs/sprintf.js"></script>
 	<script src="export/jspdf/jspdf.js"></script>
 	<script src="export/jspdf/libs/base64.js"></script>

 


<script>
function OpenPopup (c) {
window.open(c,
'window',
'width=1000,height=700,scrollbars=yes,status=yes');
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
table{
  width:100%;
}
th {
    background-color:  #337ab7;
    color: white;
    text-align: center;
  } 
td{
	text-align: center;
}

.navbar-login
{
    width: 305px;
    padding: 10px;
    padding-bottom: 0px;
}

.navbar-login-session
{
    padding: 10px;
    padding-bottom: 0px;
    padding-top: 0px;

}
.navbar-footer 
{
    background-color:#DDD;
}
.navbar-footer-content { padding:15px 15px 15px 15px; }
.dropdown-menu {
padding: 0px;
overflow: hidden;
}

.icon-size
{
    font-size: 87px;
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
                <li class="active"><a href="index.php">Home</a></li>
                
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
      include 'databaselogin.php';
       $vehicle_desc=$_POST['vehicle'];
       $vehicle1=strrpos($vehicle_desc,"(");
       $vehicle2=strrpos($vehicle_desc,")");
       $num_to_copy=$vehicle2 - $vehicle1;
       $registration_number=substr($vehicle_desc,$vehicle1+1, $num_to_copy-1);
      $sql_fm_id=mysqli_query($con,"SELECT fleet_number,fm_id,vehicle_business_unit,registration_number,fleet_group FROM vehicle WHERE registration_number='$registration_number'");
        $vehicle_data=mysqli_fetch_array($sql_fm_id);
        $fm_vehicle=$vehicle_data['fm_id'];
        $vehicle_fleet_number=$vehicle_data['fleet_number'];
        $vehicle_reg_number=$vehicle_data['registration_number'];
        $vehicle_bu=$vehicle_data['vehicle_business_unit'];
        $vehicle_fleet=$vehicle_data['fleet_group'];


        $s_date=$_POST['start_date'];
        $e_date=$_POST['end_date'];
        $start_date=(substr($s_date,0,10)."T".substr($s_date,11,5).":00+02:00");
        $end_date=(substr($e_date,0,10)."T".substr($e_date,11,5).":00+02:00");

        $wsdl = "http://api.fm-web.co.za/webservices/CoreWebSvc/CoreWS.asmx?WSDL";
           $client = new SoapClient($wsdl, 
    array(
          "trace"      => 1,        
          "exceptions" => 0,        
          "cache_wsdl" => 0)  
    );
   
    $cred_sql=mysqli_query($con,"SELECT mix_database_username,mix_database_password,mix_database_id FROM mix_credentials WHERE mix_database_business_unit='$vehicle_bu'");
    $cred_data=mysqli_fetch_array($cred_sql);
    $username= $cred_data['mix_database_username'];
    $password= $cred_data['mix_database_password'];
    $org_id= $cred_data['mix_database_id'];
  

    $result = $client->Login(array("UserName" => $username, "Password" =>$password, "ApplicationID"=>$org_id));
       $token = (string)"";
            if (isset($result->LoginResult->Token)) {
                $token = $result->LoginResult->Token;
            }           
        $clientparams = (array)array(
            'soap_version' => SOAP_1_2,
            'connection_timeout' => '25600',
            'default_socket_timeout' => '25600',
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'exceptions' => true,
            'trace' => 1
        );
      
        $api_call = new SoapClient("http://api.fm-web.co.za/webservices/AssetDataWebSvc/TripProcessesWS.asmx?wsdl", $clientparams);
        $header = new SoapHeader('http://www.omnibridge.com/SDKWebServices/AssetData', 'TokenHeader', array('Token'=>preg_replace('/\s/', '', $token)), TRUE);
        $api_call->__setSoapHeaders($header);
        $api_call->GetTripsWithTotalsForVehicleInDateRange (
          array(
          'vehicleId'=> $fm_vehicle,
          'StartDateTime'=> $start_date,
          'EndDateTime'=> $end_date  
           )
        );
        $trip_data=htmlentities($api_call->__getLastResponse());
        $string1=str_replace("&lt;", "<",$trip_data);
        $string2=str_replace("&gt;", ">",$string1);
        $string3=str_replace("&quot;", '"',$string2);

        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($string3);
        $xmlObject = $xmlDoc->getElementsByTagName('TripWithTotals');
        $itemCount = $xmlObject->length;

       $gps_data = [];
        for ($i=0; $i <= $itemCount-1; $i++){
           $gps_data[] = $xmlObject->item($i)->getElementsByTagName('EndGPSID')->item(0)->childNodes->item(0)->nodeValue;
        }

        $api_gps_data = new SoapClient("http://api.fm-web.co.za/webservices/PositioningWebSvc/PositioningWS.asmx?wsdl", $clientparams);
        $header_gps = new SoapHeader('http://www.omnibridge.com/SDKWebServices/Positioning', 'TokenHeader', array('Token'=>preg_replace('/\s/', '', $token)), TRUE);
        $api_gps_data->__setSoapHeaders($header_gps);
       
            $api_gps_data->GetGPSPositionsInList   (
            array('SpecificGPSIDs'=>array(
            'long'=>$gps_data))
    
      );
            //print_r($locations_list);

           // print_r($locations_list);
      $gpsfile= htmlentities($api_gps_data->__getLastResponse());
       $stringgps1=str_replace("&lt;", "<",$gpsfile);
        $stringgps2=str_replace("&gt;", ">",$stringgps1);
        $stringgps3=str_replace("&quot;", '"',$stringgps2);
      //echo $gpsfile;
      $gpsxmlDoc = new DOMDocument();
        $gpsxmlDoc->loadXML($stringgps3);
       $gpsxmlObject = $gpsxmlDoc->getElementsByTagName('GPSPosition');
       $itemCountgps = $gpsxmlObject->length;


?>

<div class="row">
<div class="col-md-9">
<table  id="trip_table" class='table table-bordered table-striped'>
<thead>
<tr>
<th>Vehicle</th>
<th>Driver</th>
<th>Trip Start</th>
<th>Trip End</th>
<th>Distance</th>
<th>Fuel</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Stop Duration (Minutes)</th>
<th>Map</th>
</tr>
</thead>
<tbody>
<?php

$total_distance=0;
$total_fuel=0;
$row_count=0;
$gps_data = [];
//echo $itemCount-1;
for ($i=0; $i <= $itemCount-1; $i++){
 
  $vehicle = $xmlObject->item($i)->getElementsByTagName('VehicleID')->item(0)->childNodes->item(0)->nodeValue;
  $driver = $xmlObject->item($i)->getElementsByTagName('DriverID')->item(0)->childNodes->item(0)->nodeValue;
  $trip_start = $xmlObject->item($i)->getElementsByTagName('TripStart')->item(0)->childNodes->item(0)->nodeValue;
  $trip_end = $xmlObject->item($i)->getElementsByTagName('TripEnd')->item(0)->childNodes->item(0)->nodeValue;
  if($i <= ($itemCount-2))
      {
      $stop_time = $xmlObject->item($i+1)->getElementsByTagName('TripStart')->item(0)->childNodes->item(0)->nodeValue;
      }
      else
      {
        $stop_time = "";
      }

  $distance = $xmlObject->item($i)->getElementsByTagName('TripDistance')->item(0)->childNodes->item(0)->nodeValue;
  $fuel = $xmlObject->item($i)->getElementsByTagName('Litres')->item(0)->childNodes->item(0)->nodeValue;
  $gps_id = $xmlObject->item($i)->getElementsByTagName('EndGPSID')->item(0)->childNodes->item(0)->nodeValue;

      for ($j=0; $j <= $itemCountgps-1; $j++){
        $gps_id_list = $gpsxmlObject->item($i)->getElementsByTagName('ID')->item(0)->childNodes->item(0)->nodeValue;
         IF ($gps_id=$gps_id_list)
         {
          $gps_latitude = $gpsxmlObject->item($i)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
         $gps_longitude = $gpsxmlObject->item($i)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
         }
         else
         {
          $gps_latitude = "x";
         $gps_longitude = "x";
         }

      }

   $gps_data[] = $xmlObject->item($i)->getElementsByTagName('EndGPSID')->item(0)->childNodes->item(0)->nodeValue;

  $total_distance= $total_distance+$distance;
  $total_fuel=$total_fuel+$fuel;

    $get_vehicle=mysqli_query($con,"SELECT fleet_number FROM vehicle WHERE fm_id='$vehicle'");
    $vehicle_data=mysqli_fetch_array($get_vehicle);
    $get_driver=mysqli_query($con,"SELECT driver_name FROM driver WHERE driver_fm_id='$driver'");
    $driver_data=mysqli_fetch_array($get_driver);

    $time1=str_replace("T", " ",$trip_start);
     $time_start=str_replace("+02:00", "",$time1);

    $time2=str_replace("T", " ",$trip_end);
     $time_end=str_replace("+02:00", "",$time2);
   
  $stop_time1=str_replace("T", " ",$stop_time);
    $stop_time_final=str_replace("+02:00", "",$stop_time1);
    
     $stop_duration=strtotime($stop_time_final)-strtotime($time_end);

     $row_count = $row_count + 1;

   echo "<tr data-toggle='collapse' data-target='#".$row_count."' class='accordion-toggle'>";
  
   echo "<td>".$vehicle_data['fleet_number']."</td>";
   echo "<td>".$driver_data['driver_name']."</td>";
   echo "<td>".$time_start."</td>";
   echo "<td>".$time_end."</td>";
   echo "<td>".ROUND($distance,2)."</td>";
   echo "<td>".ROUND($fuel,2)."</td>";
  echo "<td>".$gps_id."</td>";
  echo "<td>".$gps_id_list."</td>";
    echo "<td>".$gps_latitude."</td>";
    echo "<td>".$gps_longitude."</td>";
    IF ($stop_duration < 0)
    {
 	 echo "<td></td>";
	}
	else
	{
		IF (ROUND(($stop_duration)/60,2)> 30)
		{
		echo "<td bgcolor='red'>".ROUND(($stop_duration)/60,2)."</td>";	
		}
		else
		{
		echo "<td>".ROUND(($stop_duration)/60,2)."</td>";		
		}
	}

  echo"<td><button class='btn btn-default btn-xs'><span class='glyphicon glyphicon-eye-open'></span></button></td>";

  
   echo '</tr>';
echo '<tr>';
    echo "<td colspan='10' class='hiddenRow'><div class='accordian-body collapse' id='".$row_count."'><iframe
  width='600'
  height='450'
  frameborder='0' style='border:0'
  src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBhjodw2Xl2ss2rR7qfbwPe6gx0Ac2AK9c
    &q=".$gps_latitude.",".$gps_longitude."&zoom=8' allowfullscreen>
</iframe></td>";
   echo '</tr>';  
}

?>
	<tr>
		<td colspan="4" align="center"><h3>Total Summary for Trip</h3></td>
		<td  align="center"><h3><?php echo $total_distance; ?></h3></td>
		<td  align="center"><h3><?php echo $total_fuel; ?></h3></td>
		<td colspan="4"  align="center"><h4><?php 
		If ($total_distance==0)
		{
			echo "No Data Found";
		}
		else
		{
		echo ROUND(($total_fuel/$total_distance)*100,2)." L/100kms";
		}
		?></h4></td>
	</tr>
  </tbody>
</table>

</div>
<div class="col-md-3">
        <div class="panel panel-primary" style="position:fixed;">
            <div class="panel-heading"><h3 class="panel-title" style="text-align:center;"><b>Summary</b> <br><br><?php echo $s_date ?> to <?php echo $e_date ?></h3> </div>
                <div class="panel-body">
                Fleet Number : <b> <?php  echo $vehicle_fleet_number ?> </b> <br>
                Registration : <b> <?php  echo $vehicle_reg_number ?> </b> <br>
                Business Unit : <b> <?php  echo $vehicle_bu ?> </b> <br>
                Fleet: <b> <?php  echo $vehicle_fleet ?> </b> <br>
                Total Kilometres Travelled : <b> <?php  echo $total_distance ?> Kms </b> <br>
                Total Fuel Burnt : <b><?php  echo $total_fuel ?> Litres </b><br>
                Fuel Consumption : <b><?php  
		                If ($total_distance==0)
				{
					echo "No Data Found";
				}
				else
				{
                echo ROUND(($total_fuel/$total_distance)*100,2)." L/100kms";
            	}
                 ?> </b>
                </div>
            </div>
                
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>


          <div class="panel panel-warning class" style="position:fixed;">
            <div class="panel-heading"><h3 class="panel-title">Tools</div>
                <div class="panel-body">
            	  <p align="center">
               		 <a href='route_movement.php?vehicle=<?php echo $vehicle_desc; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>' onclick='OpenPopup(this.href); return false'>
         			 <button type="button" class="btn btn-primary btn-sm"> View Trip on map</button></a>
         		 </p>
         		 <div class="btn-group">
           <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" align="center"><i class="fa fa-bars"></i> Export Trip Data</button>
        
              <ul class="dropdown-menu " role="menu">
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'json',escape:'false'});"> <img src='../images/icons/json.png' width='24px'> JSON</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});"> <img src='../images/icons/json.png' width='24px'> JSON (ignoreColumn)</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'json',escape:'true'});"> <img src='../images/icons/json.png' width='24px'> JSON (with Escape)</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'xml',escape:'false'});"> <img src='../images/icons/xml.png' width='24px'> XML</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'sql'});"> <img src='../images/icons/sql.png' width='24px'> SQL</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'csv',escape:'false'});"> <img src='../images/icons/csv.png' width='24px'> CSV</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'txt',escape:'false'});"> <img src='../images/icons/txt.png' width='24px'> TXT</a></li>
                <li class="divider"></li>       
                
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'excel',escape:'false'});"> <img src='../images/icons/xls.png' width='24px'> XLS</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'doc',escape:'false'});"> <img src='../images/icons/word.png' width='24px'> Word</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'powerpoint',escape:'false'});"> <img src='../images/icons/ppt.png' width='24px'> PowerPoint</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'png',escape:'false'});"> <img src='../images/icons/png.png' width='24px'> PNG</a></li>
                <li><a href="#" onClick ="$('#trip_table').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='../images/icons/pdf.png' width='24px'> PDF</a></li>
                
              </ul>
             
            </div>   

                </div>



         </div>
         
         
           

</div>
</div>
</body>
</html>

