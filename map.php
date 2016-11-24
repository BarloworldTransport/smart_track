<?php
include 'include/databaselogin.php';
$get_gps_data = mysqli_query($con,"SELECT pos_fleet_number,pos_latitude,pos_longitude,pos_unit_id,pos_date_time FROM tel_positions");
   $_str = (string) "";
    $_str .= "[";
    while ($gps_data = mysqli_fetch_array($get_gps_data)) {
        $_str .= "{
        driver:'".$gps_data['pos_fleet_number']."',
        city :'".$gps_data['pos_fleet_number']."',
        desc : '".$gps_data['pos_fleet_number']."',
        lat : ".$gps_data['pos_latitude'].",
        long : ".$gps_data['pos_longitude']."},";
        //push the values in the array
    }
      $_str .= "]";
      $positions = str_replace(",]", "]", $_str);
  // echo $positions;
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Smart Track</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  		 <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
     <!-- Custom CSS -->
    
   <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaXcU2kk32QssbtXNMeacowDsKkFNUdsg"></script>
   <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular.min.js"></script>
    <script type="text/javascript" src="/js/markerwithlabel.js"></script>
  
    <link rel="stylesheet" href="css/menu/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/menu/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="css/sidebar_map.css"> <!-- CSS reset -->

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
 	padding-left: 0.5em;
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
   $(document).ready(
            function() {
                setInterval(function() {

            //Populates data
        var vehicles = <?php echo $positions; ?>;
         

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
            infoWindow.setContent('<h4>' + marker.title +'</h4>' + marker.content);
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

  }, 3000);
            });

//$(document).ready(function() {});
        
        </script>

</head>
<body>
	<header class="cd-main-header">
		<a class="cd-logo" href="#0">Smart Track </a>

		<ul class="cd-header-buttons">
			<li><a class="cd-search-trigger" href="#cd-search">Search<span></span></a></li>
			<li><a class="cd-nav-trigger" href="#cd-primary-nav">Menu<span></span></a></li>
		</ul> <!-- cd-header-buttons -->
	</header>

<main class="cd-main-content">
<!-- 
<br>
   
  <a href="#" onclick="$('.aside').asidebar('open')"> <button type="button" class="btn btn-info">View Vehicle List</button>   </a>

	<div class="container-fluid" ng-app="myApp"> 
    	<div class="row" ng-controller="mapCtrl">

    <div class="aside">
      <div class="aside-header">
        Vehicle List
        <span class="close" data-dismiss="aside" aria-hidden="true">&times;</span>
      </div>
      <div class="aside-contents">
       
      	<div id = "container2">   
                <div id="class" ng-repeat="marker in markers | orderBy : 'title'">
                     <div id="vehicle_box">
                        <a href="#" ng-click="openInfoWindow($event, marker)">     {{marker.title}} </a>  <br>
                     </div>
                </div>
        </div>
      </div>
    </div>

    <div class="aside-backdrop"><div id="map">Loading Map</div></div>
-->


<div class="container-fluid" ng-app="myApp"> 
   <div class="row" ng-controller="mapCtrl">







	 
<div id="main">
  <span style="font-size:20px;cursor:pointer;color:red;" onclick="openNav()">☰ Click for Vehicle List</span></div>
  <div id="map">
</div>

		
	 <div id="sidebar">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="text-align:right; ">   <i class="fa fa-times"></i></a>
	 <div id="mySidenav" class="sidenav">
	 
				
			                <div id="class" ng-repeat="marker in markers | orderBy : 'title'">
			                     <div id="vehicle_box">
			                        <a href="#" ng-click="openInfoWindow($event, marker)">     {{marker.title}} </a>  <br>
			                     </div>
			                </div>
			     

        </div>
        </div>
			
	</div>

</div>




	</main>

	<div class="cd-overlay"></div>

	<nav class="cd-nav">
		<ul id="cd-primary-nav" class="cd-primary-nav is-fixed">
			<li class="has-children">
				<a href="">Vehicles</a>

				<ul class="cd-secondary-nav is-hidden">
					<li class="go-back"><a href="#0">Menu</a></li>
					<li class="see-all"><a href="">All Vehicles</a></li>
					<li class="has-children">
						<a href="h">Manline Freight</a>

						<ul class="is-hidden">
							<li class="go-back"><a href="#0">Back</a></li>
							<li class="see-all"><a href="">All Freight Flats</a></li>
							<li class="has-children">
								<a href="#0">Freight Flats</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Freight Flats</a></li>
									<li class="see-all"><a href="">Freight Flats Consolidated</a></li>
									<li><a href="">Flat 1<span class="label label-success">10</span></a></li>
									<li><a href="">Flat 2<span class="label label-success">10</span></a></li>
									<li><a href="">Flat 3<span class="label label-success">10</span></a></li>
									<li><a href="">Flat 4<span class="label label-success">10</span></a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Freight Tauts</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Freight Tauts</a></li>
									<li class="see-all"><a href="">Freight Tauts Consolidated</a></li>
									<li><a href="">Ashton</a></li>
									<li><a href="">Taut 1</a></li>
									<li><a href="">Taut 2</a></li>
									<li><a href="">Taut 3</a></li>
									<li><a href="">Taut 4</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Freight - Warehousing</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Freight Warehousing</a></li>
									<li class="see-all"><a href="">Freight Warehousing Consolidated</a></li>
									<li><a href="">Freight - Germiston</a></li>
								</ul>
							</li>

								<li class="has-children">
								<a href="#0">Freight OPS Overheads</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Freight OPS Overheads</a></li>
									<li class="see-all"><a href="">Freight OPS Overheads Consolidated</a></li>
									<li><a href="">Freight OPS Overheads</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Manline Kumkani</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Manline Kumkani</a></li>
									<li class="see-all"><a href="">Manline Kumkani Consolidated</a></li>
									<li><a href="">Manline Kumkani</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Manline Mega</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Manline Mega</a></li>
									<li class="see-all"><a href="">Manline Mega Consolidated</a></li>
									<li><a href="">Manline Mega</a></li>
								</ul>
							</li>
							
						</ul>
					</li>

					<li class="has-children">
						<a href="">Manline Energy</a>

						<ul class="is-hidden">
							<li class="go-back"><a href="#0">Manline Energy</a></li>
							<li class="see-all"><a href="">All Energy</a></li>

							<li class="has-children">
								<a href="#0">Chemical</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Chemical</a></li>
									<li class="see-all"><a href="">Chemical Consolidated</a></li>
									<li><a href="">Buckman</a></li>
									<li><a href="">Manline Chemical Tankers</a></li>
									<li><a href="">NCP</a></li>
									<li><a href="">South 32</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Fuel & Gas</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Fuel & Gas</a></li>
									<li class="see-all"><a href="">Fuel & Gas Consolidated</a></li>
									<li><a href="">Easigas (LPG)</a></li>
									<li><a href="">Energy BP</a></li>
									<li><a href="">Energy Langlaagte</a></li>
									<li><a href="">Energy Naledi</a></li>
									<li><a href="">Energy Adhoc 1</a></li>
									<li><a href="">Energy Adhoc 2</a></li>
								</ul>
							</li>
							</ul>
							</li>


					<li class="has-children">
						<a href="">Dedicated</a>

						<ul class="is-hidden">
							<li class="go-back"><a href="#0">Dedicated</a></li>
							<li class="see-all"><a href="">Dedicated Consolidated</a></li>

							<li class="has-children">
								<a href="#0">Agriculture</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Agriculture</a></li>
									<li class="see-all"><a href="">Agriculture Consolidated</a></li>
									<li><a href="">Festive Chickens</a></li>
									<li><a href="">Goldi - Standerton (Catching)</a></li>
									<li><a href="">Goldi - Standerton (Hatching)</a></li>
									<li><a href="">Meadow Feeds - Delmas</a></li>
									<li><a href="">Meadow Feeds - Paarl & Ladismith</a></li>
									<li><a href="">Meadow Feeds - PE</a></li>
									<li><a href="">Meadow Feeds - Pmb</a></li>
									<li><a href="">Meadow Feeds - Randfontein</a></li>
									<li><a href="">Meadow Feeds - Standerton</a></li>
									<li><a href="">Wilmar</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Automotive</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Automotive</a></li>
									<li class="see-all"><a href="">Automotive Consolidated</a></li>
									<li><a href="">Toyota - Tsusho</a></li>
									<li><a href="">Toyota - X Dock</a></li>
								</ul>
							</li>

							<li class="has-children">
								<a href="#0">Building & Construction</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Building & Construction</a></li>
									<li class="see-all"><a href="">Building & Construction Consolidated</a></li>
									
									<li><a href="">Afrisam - Delpoorthoops</a></li>
									<li><a href="">Corobrick - Avoca</a></li>
									<li><a href="">Idwala - Bloemhof</a></li>
									<li><a href="">Idwala - Vereeniging</a></li>
									<li><a href="">PPC - Dwaalboom</a></li>
									<li><a href="">PPC - Dwaalboom Owner Drivers</a></li>
									<li><a href="">PPC - George</a></li>
									<li><a href="">PPC - Hercules</a></li>
									<li><a href="">PPC - Heriotdale</a></li>
									<li><a href="">PPC - Kraaifontein</a></li>
									<li><a href="">PPC - PE</a></li>
									<li><a href="">PPC - Slurry</a></li>

								</ul>
							</li>


							<li class="has-children">
								<a href="#0">Enviromental</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Enviromental</a></li>
									<li class="see-all"><a href="">Enviromental Consolidated</a></li>
									<li><a href="">Smart Matta - Cape Town</a></li>
									<li><a href="">Smart Matta - Denver</a></li>
									<li><a href="">Smart Matta - KZN</a></li>
								</ul>
							</li>

							




						</li>
					</ul>



<li class="has-children">
						<a href="">Refrigerated</a>

						<ul class="is-hidden">
							<li class="go-back"><a href="#0">Back</a></li>
							<li class="see-all"><a href="">Refridgerated Consolidated</a></li>

							<li class="has-children">
								<a href="#0">Aspen</a>

								<ul class="is-hidden">
									<li class="go-back"><a href="#0">Back</a></li>
									<li class="see-all"><a href="">Aspen Consolidated</a></li>
									<li><a href="">Botswana Longhaul</a></li>
									<li><a href="">Botswana Shorthaul</a></li>
									<li><a href=""> Cross Border Trucks</a></li>
									<li><a href="">Longhaul Trucks 1</a></li>
									<li><a href="">Longhaul Trucks 2</a></li>
									<li><a href="">Shorthaul Trucks</a></li>
								</ul>
							</li>

							
							</ul>

				</ul>
			</li>

			<li class="has-children">
				<a href="">Scheduling</a>

				<ul class="cd-nav-gallery is-hidden">
					<li class="go-back"><a href="#0">Menu</a></li>
					<li class="see-all"><a href="">Browse Gallery</a></li>
					<li>
						<a class="cd-nav-item" href="">
							<img src="img/img.jpg" alt="Product Image">
							<h3>Product #1</h3>
						</a>
					</li>

					<li>
						<a class="cd-nav-item" href="">
							<img src="img/img.jpg" alt="Product Image">
							<h3>Product #2</h3>
						</a>
					</li>

					<li>
						<a class="cd-nav-item" href="">
							<img src="img/img.jpg" alt="Product Image">
							<h3>Product #3</h3>
						</a>
					</li>

					<li>
						<a class="cd-nav-item" href="">
							<img src="img/img.jpg" alt="Product Image">
							<h3>Product #4</h3>
						</a>
					</li>
				</ul>
			</li>

			<li class="has-children">
				<a href="">Tracking Map</a>
				<ul class="cd-nav-icons is-hidden">
					<li class="go-back"><a href="#0">Menu</a></li>
					<li class="see-all"><a href="">Browse Services</a></li>
					<li>
						<a class="cd-nav-item item-1" href="">
							<h3>Service #1</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-2" href="">
							<h3>Service #2</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-3" href="">
							<h3>Service #3</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-4" href="">
							<h3>Service #4</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-5" href="">
							<h3>Service #5</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-6" href="">
							<h3>Service #6</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-7" href="">
							<h3>Service #7</h3>
							<p>This is the item description</p>
						</a>
					</li>

					<li>
						<a class="cd-nav-item item-8" href="">
							<h3>Service #8</h3>
							<p>This is the item description</p>
						</a>
					</li>
				</ul>
			</li>

			<li><a href="">Standard</a></li>
		</ul> <!-- primary-nav -->
	</nav> <!-- cd-nav -->

	<div id="cd-search" class="cd-search">
		<form>
			<input type="search" placeholder="Search...">
		</form>
	</div>
<script src="js/menu/jquery-2.1.1.js"></script>
 
<script src="js/menu/jquery.mobile.custom.min.js"></script>
<script src="js/menu/main.js"></script> <!-- Resource jQuery -->
<script src="js/menu/modernizr.js"></script> <!-- Modernizr -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/markerwithlabel.js"></script>
 <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
  

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
   
    document.getElementById("map").style.marginLeft = "250px";
   

}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
   
    document.getElementById("map").style.marginLeft= "0";
    
}
</script>

</body>
</html>