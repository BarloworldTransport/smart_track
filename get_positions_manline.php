    <?php
    $wsdl = "http://api.fm-web.co.za/webservices/CoreWebSvc/CoreWS.asmx?WSDL";
    $client = new SoapClient($wsdl, array(
        "trace" => 1, // enable trace to view what is happening
        "exceptions" => 0, // disable exceptions
        "cache_wsdl" => 0
    )) // disable any caching on the wsdl, encase you alter the wsdl server
;
    // Login
    $result = $client->Login(array(
        "UserName" => "CFMISDK1080",
        "Password" => "Compass1",
        "ApplicationID" => "1080"
    ));
    // Get the API Token
    $token = (string) "";
    if (isset($result->LoginResult->Token)) {
        $token = $result->LoginResult->Token;
    }
    $fp = fopen('token.txt', 'w');
    fwrite($fp, $token);
    fclose($fp);
    
    $clientparams = (array) array(
        'soap_version' => SOAP_1_2,
        'connection_timeout' => '25600',
        'default_socket_timeout' => '25600',
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
        'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
        'exceptions' => true,
        'trace' => 1
    );
    $api_call = new SoapClient("http://api.fm-web.co.za/WebServices/PositioningWebSvc/PositioningWS.asmx?wsdl", $clientparams);
    $header = new SoapHeader('http://www.omnibridge.com/SDKWebServices/Positioning', 'TokenHeader', array(
        'Token' => preg_replace('/\s/', '', $token)
    ), TRUE);
    $api_call->__setSoapHeaders($header);
    
    $api_call->GetLatestPositionPerVehicle();
    
    // echo htmlentities($api_call->__getLastResponse());
    $position_file = fopen("data.xml", "w") or die("Error");
    $position_data = htmlentities($api_call->__getLastResponse());
    
    $string1 = str_replace("&lt;", "<", $position_data);
    $string2 = str_replace("&gt;", ">", $string1);
    $string3 = str_replace("&quot;", '"', $string2);
    fwrite($position_file, $string3);
    echo $position_data;
    
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadXML($string3);
    $mysql_hostname = 'localhost';
    $mysql_user = 'root';
    $mysql_password = 'BWTsm@rttrucking';
    $mysql_database = 'smart_track';
    
    $bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die('Oops some thing went wrong');
    mysqli_select_db($bd, $mysql_database) or die("Oops some thing went wrong");
    
    $xmlObject = $xmlDoc->getElementsByTagName('GPSPosition');
    $itemCount = $xmlObject->length;
    
    echo $itemCount - 1;
    // $fm_pos_id = $xmlObject->item(960)->getElementsByTagName('ID')->item(0)->childNodes->item(0)->nodeValue;
    // echo $fm_pos_id;
    
    // $empty_table = "TRUNCATE TABLE positions";
    // mysqli_query($bd,$empty_table);
    
    for ($i = 0; $i <= $itemCount - 1; $i ++) {
        $fm_pos_id = $xmlObject->item($i)
            ->getElementsByTagName('ID')
            ->item(0)->childNodes->item(0)->nodeValue;
        $vehicle_id = $xmlObject->item($i)
            ->getElementsByTagName('VehicleID')
            ->item(0)->childNodes->item(0)->nodeValue;
        $driver_id = $xmlObject->item($i)
            ->getElementsByTagName('DriverID')
            ->item(0)->childNodes->item(0)->nodeValue;
        $mix_time = $xmlObject->item($i)
            ->getElementsByTagName('Time')
            ->item(0)->childNodes->item(0)->nodeValue;
        $latitude = $xmlObject->item($i)
            ->getElementsByTagName('Latitude')
            ->item(0)->childNodes->item(0)->nodeValue;
        $longitude = $xmlObject->item($i)
            ->getElementsByTagName('Longitude')
            ->item(0)->childNodes->item(0)->nodeValue;
        $heading = $xmlObject->item($i)
            ->getElementsByTagName('Heading')
            ->item(0)->childNodes->item(0)->nodeValue;
        $speed = $xmlObject->item($i)
            ->getElementsByTagName('Velocity')
            ->item(0)->childNodes->item(0)->nodeValue;
        $altitude = $xmlObject->item($i)
            ->getElementsByTagName('Altitude')
            ->item(0)->childNodes->item(0)->nodeValue;
        
        $time1 = str_replace("T", " ", $mix_time);
        $time = str_replace("+02:00", "", $time1);
        
        $sql = "INSERT INTO positions (
    position_fm_pos_id,
    position_vehicle_id,
    position_driver_id,
    position_time,
    position_latitude,
    position_longitude,
    position_heading,
    position_speed,
    position_altitude

    ) VALUES (
    '$fm_pos_id',
    '$vehicle_id',
    '$driver_id',
    '$time',
    '$latitude',
    '$longitude',
    '$heading',
    '$speed',
    '$altitude'
    )";
        
        mysqli_query($bd, $sql);
    }
    
    echo mysqli_error($bd);
    
    ?>



