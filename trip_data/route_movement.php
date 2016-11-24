<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Trip Route</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #warnings-panel {
        width: 100%;
        height:10%;
        text-align: center;
      }
    </style>

  </head>
  <body>
      <?php 

      include 'databaselogin.php';
      // $vehicle=$_POST['vehicle'];
      $vehicle=$_GET['vehicle'];
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
          $s_date=$_GET['start_date'];
        $e_date=$_GET['end_date'];

        //$s_date=$_POST['start_date'];
        //$e_date=$_POST['end_date'];
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
        $api_call = new SoapClient("http://api.fm-web.co.za/WebServices/PositioningWebSvc/PositioningWS.asmx?wsdl", $clientparams);
        $header = new SoapHeader('http://www.omnibridge.com/SDKWebServices/Positioning', 'TokenHeader', array('Token'=>preg_replace('/\s/', '', $token)), TRUE);
        $api_call->__setSoapHeaders($header);
        $api_call->GetGPSPositionsForVehicleInDateRange (
          array(
          'VehicleID'=> $fm_vehicle,
          'StartDate'=> $start_date,
          'EndDate'=> $end_date  
           )
        );
        $trip_data=htmlentities($api_call->__getLastResponse());
        $string1=str_replace("&lt;", "<",$trip_data);
        $string2=str_replace("&gt;", ">",$string1);
        $string3=str_replace("&quot;", '"',$string2);
       // echo $trip_data;

        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($string3);
        $xmlObject = $xmlDoc->getElementsByTagName('GPSPosition');
        $itemCount = $xmlObject->length;

 		$_str = (string) "";
  		  $_str .= "[";
       for ($i=0; $i <= $itemCount-1; $i++){
       	$gps_latitude = $xmlObject->item($i)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
       		$gps_longitude = $xmlObject->item($i)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
          $gps_time = $xmlObject->item($i)->getElementsByTagName('Time')->item(0)->childNodes->item(0)->nodeValue;
          $time1=str_replace("T", " ",$gps_time);
           $position_start=str_replace("+02:00", "",$time1);

       		
         	$_str .= '{"latlng":['.$gps_latitude.','.$gps_longitude.'],name:"'.$position_start.'"},';
        }
         $_str .= "]";
         $way_points = str_replace(",]", "]", $_str);
         //echo $way_points;
       
    
         
        ?>


    <div id="map"></div>
    &nbsp;
    <div id="warnings-panel"></div>
   <script>

      // This example creates a 2-pixel-wide red polyline showing the path of William
      // Kingsford Smith's first trans-Pacific flight between Oakland, CA, and
      // Brisbane, Australia.

      function initMap() {
        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 3,
          center: {lat: -25.5453812, lng: 28.1898941},
         mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var markers = <?php echo $way_points ?>;

       
        var marker, i;

// Loop through our array of markers & place each one on the map  
    for( i in markers) {
          positions = markers[i];
            latlng = new google.maps.LatLng(positions.latlng[0], positions.latlng[1]);
        bounds.extend(latlng);
        var marker = createMarker(
          map,latlng ,positions.name
            );
    
      }

function createMarker(map, latlng, name ,label) {
  //Creates a marker
  var marker = new google.maps.Marker({
    position : latlng,
    map : map,
    title : "test"
   
  });


  var infowindow = new google.maps.InfoWindow({
  content:name
  });

google.maps.event.addListener(marker, 'click', function() {
  infowindow.open(map,marker);
  });

 }


 // Allow each marker to have an info window    
    

        var flightPath = new google.maps.Polyline({
          path: markers,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          map : map,
          strokeWeight: 2
        });


//marker.setMap(map);
flightPath.setMap(map);



      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaXcU2kk32QssbtXNMeacowDsKkFNUdsg&callback=initMap">
    </script>
  </body>
</html>