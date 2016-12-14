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
    $api_call = new SoapClient("http://api.fm-web.co.za/webservices/AssetDataWebSvc/VehicleProcessesWS.asmx?wsdl", $clientparams);
    $header = new SoapHeader('http://www.omnibridge.com/SDKWebServices/AssetData', 'TokenHeader', array(
        'Token' => preg_replace('/\s/', '', $token)
    ), TRUE);
    $api_call->__setSoapHeaders($header);
    
    $api_call->GetVehiclesList();
    
    // echo htmlentities($api_call->__getLastResponse());
    $trip_file = fopen("trip_data.xml", "w") or die("Error");
    $trip_data = htmlentities($api_call->__getLastResponse());
    
    $string1 = str_replace("&lt;", "<", $trip_data);
    $string2 = str_replace("&gt;", ">", $string1);
    $string3 = str_replace("&quot;", '"', $string2);
    $string4 = str_replace("&nbsp;", "", $string3);
    fwrite($trip_file, $string4);
    echo $string3;
    
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadXML($string4);
    $mysql_hostname = 'localhost';
    $mysql_user = 'root';
    $mysql_password = 'BWTsm@rttrucking';
    $mysql_database = 'smart_track';
    
    $bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die('Oops some thing went wrong');
    mysqli_select_db($bd, $mysql_database) or die("Oops some thing went wrong");
    
    $xmlObject = $xmlDoc->getElementsByTagName('Vehicle');
    $itemCount = $xmlObject->length;
    
    echo $itemCount - 1;
    // $fm_pos_id = $xmlObject->item(960)->getElementsByTagName('ID')->item(0)->childNodes->item(0)->nodeValue;
    // echo $fm_pos_id;
    
    $empty_table = "TRUNCATE TABLE unit_trip_download";
    mysqli_query($bd, $empty_table);
    
    for ($i = 0; $i <= $itemCount - 1; $i ++) {
        $fm_vehicle_id = $xmlObject->item($i)
            ->getElementsByTagName('ID')
            ->item(0)->childNodes->item(0)->nodeValue;
        $fm_last_download_date = $xmlObject->item($i)
            ->getElementsByTagName('LastTrip')
            ->item(0)->childNodes->item(0)->nodeValue;
        $fm_odometer_reading = $xmlObject->item($i)
            ->getElementsByTagName('LastOdometer')
            ->item(0)->childNodes->item(0)->nodeValue;
        
        $time1 = str_replace("T", " ", $fm_last_download_date);
        $time_download = str_replace("+02:00", "", $time1);
        
        $sql = "INSERT INTO unit_trip_download (
                  trip_download_fm_id,
                  trip_download_download_date,
                  trip_download_fm_odometer
                  ) VALUES (
                  '$fm_vehicle_id',
                  '$time_download',
                  '$fm_odometer_reading'
                  )";
        
        mysqli_query($bd, $sql);
    }
    
    echo mysqli_error($bd);
    
    ?>



