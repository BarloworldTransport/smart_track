    
<html>
<head>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<style>
body {
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#4c4c4c+0,595959+12,666666+25,474747+39,2c2c2c+50,000000+51,111111+60,2b2b2b+76,1c1c1c+91,131313+100;Black+Gloss+%231 */
background: rgb(76,76,76); /* Old browsers */
background: -moz-linear-gradient(-45deg, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(44,44,44,1) 50%, rgba(0,0,0,1) 51%, rgba(17,17,17,1) 60%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
</style>
</head>
 <body>
<div class="container">
<div class="row">
<div> </div>
  <div class="col-lg-8 col-md-8 col-sm-8">
    <?php 
      include 'databaselogin.php';
       $vehicle=$_POST['vehicle'];
       $vehicle1=strrpos($vehicle,"(");
       $vehicle2=strrpos($vehicle,")");
       $num_to_copy=$vehicle2 - $vehicle1;
       $registration_number=substr($vehicle,$vehicle1+1, $num_to_copy-1);
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
      $gpsfile= htmlentities($api_gps_data->__getLastResponse());
       $stringgps1=str_replace("&lt;", "<",$gpsfile);
        $stringgps2=str_replace("&gt;", ">",$stringgps1);
        $stringgps3=str_replace("&quot;", '"',$stringgps2);
      // echo $gpsfile;

        
//$gps1 = $gps_xml_doc->getElementsByTagName('DriverID');
        $gpsxmlDoc = new DOMDocument();
        $gpsxmlDoc->loadXML($stringgps3);
       $gpsxmlObject = $gpsxmlDoc->getElementsByTagName('TripWithTotals');
       $gpsitemCount = $gpsxmlObject->length;


//echo $itemCount-1;
//$fm_pos_id = $xmlObject->item(960)->getElementsByTagName('ID')->item(0)->childNodes->item(0)->nodeValue;
//echo $fm_pos_id;

$gps_data = [];
echo $gpsitemCount-1;
for ($i=0; $i <= $gpsitemCount-1; $i++){
 
  $vehicle = $gpsxmlObject->item($i)->getElementsByTagName('VehicleID')->item(0)->childNodes->item(0)->nodeValue;
  $driver = $gpsxmlObject->item($i)->getElementsByTagName('DriverID')->item(0)->childNodes->item(0)->nodeValue;
  $stoptime = $gpsxmlObject->item($i)->getElementsByTagName('Time')->item(0)->childNodes->item(0)->nodeValue;
  $stop_latitude = $gpsxmlObject->item($i)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
  $stop_longitude = $gpsxmlObject->item($i)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
  

   $gps_data[] = $xmlObject->item($i)->getElementsByTagName('EndGPSID')->item(0)->childNodes->item(0)->nodeValue;


    $get_vehicle=mysqli_query($con,"SELECT fleet_number FROM vehicle WHERE fm_id='$vehicle'");
    $vehicle_data=mysqli_fetch_array($get_vehicle);
    $get_driver=mysqli_query($con,"SELECT driver_name FROM driver WHERE driver_fm_id='$driver'");
    $driver_data=mysqli_fetch_array($get_driver);

    $time1=str_replace("T", " ",$stoptime);
     $time_stop=str_replace("+02:00", "",$time1);

    


 
   echo "<div id='map'>

http://maps.googleapis.com/maps/api/staticmap?zoom=17&size=512x512&maptype=hybrid&markers=icon:http://cdn.sstatic.net/stackoverflow/img/favicon.ico|34.052230,%20-118.243680





   </div>";

}


/*
echo "<h3>Total Distance = " .$total_distance." Kms</h3>";
echo "<br>";
echo  "<h3>Total Fuel = " .$total_fuel . " Litres";
echo "<br>";
echo "<h3>Consumption = ". ROUND(($total_fuel/$total_distance)*100,2) . " L/100km";
*/
echo json_encode($gps_data);

       


?>


</div>
</div>
</div>



</div>
</div>

</body>
</html>

