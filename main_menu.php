
<?php
include 'include/databaselogin.php';
//$get_gps_data = mysqli_query($con,"SELECT position_vehicle_id,position_latitude,position_longitude FROM positions");
//$get_gps_data = mysqli_query($con,"SELECT p.position_vehicle_id,p.position_latitude,p.position_longitude,v.fleet_number FROM positions p, vehicle v
//WHERE p.position_vehicle_id = v.fm_id");

$get_gps_data = mysqli_query($con,"SELECT driver.driver_fm_id,positions.position_driver_id,positions.position_vehicle_id,positions.position_latitude,positions.position_longitude,vehicle.fleet_number,driver.driver_name
    FROM positions
    INNER JOIN vehicle 
            ON vehicle.fm_id = positions.position_vehicle_id
    INNER JOIN driver 
            ON driver.driver_fm_id = positions.position_driver_id");

   $_str = (string) "";
    $_str .= "[";
    while ($gps_data = mysqli_fetch_array($get_gps_data)) {
        $_str .= "{
        driver:'".$gps_data['driver_name']."',
        city :'".$gps_data['fleet_number']."',
        desc : '".$gps_data['fleet_number']."',
        lat : ".$gps_data['position_latitude'].",
        long : ".$gps_data['position_longitude']."},";
        //push the values in the array
    }
      $_str .= "]";
      $positions = str_replace(",]", "]", $_str);
//echo $positions;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>Rainbow Nav  - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/main_menu.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="css/sidebar_map.css"> <!-- CSS reset -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaXcU2kk32QssbtXNMeacowDsKkFNUdsg"></script>
   <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular.min.js"></script>
   
    <script type="text/javascript" src="/js/markerwithlabel.js"></script>
   <style type="text/css">

   .labels {
     color: white;
     background-color: red;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
     width: 40px;
     border: 1px solid black;
     white-space: nowrap;
   }
  #vehicle_box {
        border-radius: 1px;
        border: 3px solid #bbb;
        font-size: 20px;
        font-family: calibri;
        padding: 1px;
        width: 270px;
        height: 80px; 
        margin-top: 2px ;
        color: red;
        text-decoration: none; 
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f6f8f9+0,e5ebee+50,d7dee3+51,f5f7f9+100;White+Gloss */
background: rgb(246,248,249); /* Old browsers */
background: -moz-linear-gradient(-45deg,  rgba(246,248,249,1) 0%, rgba(229,235,238,1) 50%, rgba(215,222,227,1) 51%, rgba(245,247,249,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg,  rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg,  rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9', endColorstr='#f5f7f9',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */



}

*{margin:0;}
#container1{
     width: 90%;
    height: 950px;
    overflow: hidden;
    padding:10px;
}

#container2{
    width: 15%;
    height: 950px;
    overflow: auto;
    padding-right: 30px;
}


 #map {
    
    height:1050px;
    width:1600px;
}

#headbar{
    width:15%;
    top:1px;
    background: blue;
    text-align: left;
}


</style>
<script type='text/javascript'>
  

            //Populates data
        var vehicles = <?php echo $positions; ?>;
         var infoBubbleSample;

        var myApp = angular.module('myApp', []);
        function mapCtrl($scope, $http){
           $scope.markers = [
                {
                   "latitude":33.22,
                   "longitude":35.33
                }
            ];
          
            var mapOptions = {
                zoom: 3,
                center: new google.maps.LatLng(24.6609756,-17.3552936),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
    $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var createMarker = function (info){
        var marker = new MarkerWithLabel({
            position: new google.maps.LatLng(info.lat, info.long),
            map: $scope.map,
            title: info.city,
            labelContent: info.city,
            //animation: google.maps.Animation.DROP,
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            icon: "images/lorry_flatbed.png"
        });
        marker.content = '<div class="infoWindowContent">Driver :' + info.driver + '</div>';
        google.maps.event.addListener(marker, 'click', function(){
            $scope.map.setCenter(marker.getPosition());
            $scope.map.setZoom(15);
            infoWindow.setContent(marker.content);
            infoWindow.open($scope.map, marker);
        });
        
        $scope.markers.push(marker);
       
    }  
    
    for (i = 0; i < vehicles.length; i++){
        createMarker(vehicles[i]);
    }

    $scope.openInfoWindow = function(e, selectedMarker){
        e.preventDefault();
        google.maps.event.trigger(selectedMarker, 'click');
    }
}



//$(document).ready(function() {});
        
        </script>
</head>
<body>


<!-- Start of Header -->
    <div class="navbar-wrapper">
    <div class="container-fluid">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Smart Track</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#" class="">Home</a></li>
                        <li class=" dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vehicles <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=" dropdown">
                                    <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">All Business Units</a>
                                </li>
                                <li><a href="#">Dedicated</a></li>
                                <li><a href="#">Manline Energy</a></li>
                                <li><a href="#">Manline Freight</a></li>
                                <li><a href="#">Aspen</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Vehicle Scheduling</a></li>
                        <li><a href="#">Vehicle Map</a></li>
                       
                        
                        
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Signed in as  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Change Password</a></li>
                                <li><a href="#">My Profile</a></li>
                            </ul>
                        </li>
                        <li class=""><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- End of Header -->

    
 <div class="container-fluid" ng-app="myApp"> 
   <div class="row" ng-controller="mapCtrl">


  <div class="vehicle_list panel panel-default" id="vehicle_list">
    <div class="panel-heading">Vehicles<a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="text-align:right; ">   <i class="fa fa-times"></i></a></div>
    <div class="panel-body">
             <div id="class" ng-repeat="marker in markers | orderBy : 'title'">
                  <div id="vehicle_box">
                            <a href="#" ng-click="openInfoWindow($event, marker)"> {{marker.title}} </a>  <br>
                  </div>
             </div>



    </div>
  </div>




     
<div id="main">
  <span style="font-size:20px;cursor:pointer;color:red;" onclick="openNav()">☰ Click for Vehicle List</span></div>
  <div id="map">
</div>
</div>
</div>

  
  </body>













<script>
function openNav() {
    document.getElementById("vehicle_list").style.width = "250px";
   
    document.getElementById("map").style.marginLeft = "250px";
   

}

function closeNav() {
    document.getElementById("vehicle_list").style.width = "0";
   
    document.getElementById("map").style.marginLeft= "0";
    
}
</script>

</body>
</html>
