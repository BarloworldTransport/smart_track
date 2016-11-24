<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service (complex)</title>
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

            $gpsxmlDoc = new DOMDocument();
        $gpsxmlDoc->loadXML($stringgps3);
       $gpsxmlObject = $gpsxmlDoc->getElementsByTagName('GPSPosition');
       $itemCountgps = $gpsxmlObject->length;
		$_str = (string) "";
  		  $_str .= "[";
       for ($j=0; $j <= $itemCountgps-1; $j++){
       	$gps_start_latitude = $gpsxmlObject->item(0)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
       		$gps_start_longitude = $gpsxmlObject->item(0)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
       		$gps_end_latitude = $gpsxmlObject->item($itemCountgps-1)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
       		$gps_end_longitude = $gpsxmlObject->item($itemCountgps-1)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
             $gps_latitude = $gpsxmlObject->item($j)->getElementsByTagName('Latitude')->item(0)->childNodes->item(0)->nodeValue;
         		$gps_longitude = $gpsxmlObject->item($j)->getElementsByTagName('Longitude')->item(0)->childNodes->item(0)->nodeValue;
         	$_str .="{location:new google.maps.LatLng(".$gps_latitude.",".$gps_longitude.")},";
        }
         $_str .= "]";
         $way_points = str_replace(",]", "]", $_str);
         echo $way_points;
         $gps_start = $gps_start_latitude.",".$gps_start_longitude;
         $gps_end = $gps_end_latitude.",".$gps_end_longitude;
         echo $gps_start;
          echo $gps_end;
         
        ?>


    <div id="map"></div>
    &nbsp;
    <div id="warnings-panel"></div>
    <script>
      function initMap() {
        var markerArray = [];

        // Instantiate a directions service.
        var directionsService = new google.maps.DirectionsService;

        // Create a map and center it on Manhattan.
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 40.771, lng: -73.974}
        });

        // Create a renderer for directions and bind it to the map.
        var directionsDisplay = new google.maps.DirectionsRenderer({map: map});

        // Instantiate an info window to hold step text.
        var stepDisplay = new google.maps.InfoWindow;

        // Display the route between the initial start and end selections.
        calculateAndDisplayRoute(
            directionsDisplay, directionsService, markerArray, stepDisplay, map);
        // Listen to change events from the start and end lists.
        var onChangeHandler = function() {
          calculateAndDisplayRoute(
              directionsDisplay, directionsService, markerArray, stepDisplay, map);
        };
        document.getElementById('start').addEventListener('change', onChangeHandler);
        document.getElementById('end').addEventListener('change', onChangeHandler);
      }

      function calculateAndDisplayRoute(directionsDisplay, directionsService,
          markerArray, stepDisplay, map) {
      		var org=new google.maps.LatLng(<?php echo $gps_start?>);
			var dest=new google.maps.LatLng(<?php echo $gps_end?>);
			var point1=new google.maps.LatLng(-33.8975098545041,151.09962701797485);
			var point2=new google.maps.LatLng(-33.8584421519279,151.0693073272705);
			var point3=new google.maps.LatLng(-33.87312358690301,151.99952697753906);
			var point4=new google.maps.LatLng(-33.84525521656404,151.0421848297119);
			//var wps=[{location:point1},{location:point2},{location:point4}];
			//var wps=[{location:new google.maps.LatLng(-33.8975098545041,151.09962701797485)},
			//{location:new google.maps.LatLng(-33.8584421519279,151.0693073272705)},
			//{location:new google.maps.LatLng(-33.87312358690301,151.99952697753906)}];

		var wps = 	<?php echo $way_points ?>;	
		//var wps = JSON.parse(test);

        // First, remove any existing markers from the map.
        for (var i = 0; i < markerArray.length; i++) {
          markerArray[i].setMap(null);
        }

        // Retrieve the start and end locations and create a DirectionsRequest using
        // WALKING directions.
        directionsService.route({
          origin:  org,
          destination:dest,
         // waypoints:wps,
          travelMode:google.maps.DirectionsTravelMode.DRIVING
        }, function(response, status) {
          // Route the directions and pass the response to a function to create
          // markers for each step.
          if (status === 'OK') {
            document.getElementById('warnings-panel').innerHTML =
                '<b>' + response.routes[0].warnings + '</b>';
            directionsDisplay.setDirections(response);
            showSteps(response, markerArray, stepDisplay, map);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }

      function showSteps(directionResult, markerArray, stepDisplay, map) {
        // For each step, place a marker, and add the text to the marker's infowindow.
        // Also attach the marker to an array so we can keep track of it and remove it
        // when calculating new routes.
        var myRoute = directionResult.routes[0].legs[0];
        for (var i = 0; i < myRoute.steps.length; i++) {
          var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
          marker.setMap(map);
          marker.setPosition(myRoute.steps[i].start_location);
          attachInstructionText(
              stepDisplay, marker, myRoute.steps[i].instructions, map);
        }
      }

      function attachInstructionText(stepDisplay, marker, text, map) {
        google.maps.event.addListener(marker, 'click', function() {
          // Open an info window when the marker is clicked on, containing the text
          // of the step.
          stepDisplay.setContent("Test");
          stepDisplay.open(map, marker);
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaXcU2kk32QssbtXNMeacowDsKkFNUdsg&callback=initMap">
    </script>
  </body>
</html>