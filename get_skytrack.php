<?php
/*
 * // Get cURL resource
 * $curl = curl_init();
 * // Set some options - we are passing in a useragent too here
 * curl_setopt_array($curl, array(
 * CURLOPT_RETURNTRANSFER => 1,
 * CURLOPT_URL => 'http://skyq1.skygistics.com/SkygisticsAPI/SkygisticsAPI.asmx/Login?username=qcicmanlineint&password=M@nLin3',
 * CURLOPT_USERAGENT => 'Skytrack'
 * ));
 * // Send the request & save response to $resp
 * $resp = curl_exec($curl);
 * // Close request to clear up some resources
 * curl_close($curl);
 * $session = $resp;
 *
 * echo $session;
 */
$xmlDoc = new DOMDocument();
$xmlDoc->load("http://skyq1.skygistics.com/SkygisticsAPI/SkygisticsAPI.asmx/GetUnitList?sessionid=33886-18");
$mysql_hostname = 'localhost';
$mysql_user = 'root';
$mysql_password = 'BWTsm@rttrucking';
$mysql_database = 'smart_track';

$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die('Oops some thing went wrong');
mysqli_select_db($bd, $mysql_database) or die("Oops some thing went wrong");

$xmlObject = $xmlDoc->getElementsByTagName('UnitInfo');
$itemCount = $xmlObject->length;

$empty_table = "TRUNCATE TABLE skytrack_positions";
mysqli_query($bd, $empty_table);

echo $itemCount;

for ($i = 0; $i <= $itemCount - 1; $i ++) {
    
    $name = $xmlObject->item($i)
        ->getElementsByTagName('Name')
        ->item(0)->childNodes->item(0)->nodeValue;
    $unit_id = $xmlObject->item($i)
        ->getElementsByTagName('IMEI')
        ->item(0)->childNodes->item(0)->nodeValue;
    $Latitude = $xmlObject->item($i)
        ->getElementsByTagName('Latitude')
        ->item(0)->childNodes->item(0)->nodeValue;
    $Longitude = $xmlObject->item($i)
        ->getElementsByTagName('Longitude')
        ->item(0)->childNodes->item(0)->nodeValue;
    $Time = $xmlObject->item($i)
        ->getElementsByTagName('Time')
        ->item(0)->childNodes->item(0)->nodeValue;
    
    $sql = "INSERT INTO skytrack_positions (skytrack_positions_truck,skytrack_positions_unit_id,skytrack_positions_latitude,skytrack_positions_longitude,skytrack_positions_time) VALUES ('$name','$unit_id','$Latitude','$Longitude','$Time')";
    mysqli_query($bd, $sql);
    echo $name;
}

?>
