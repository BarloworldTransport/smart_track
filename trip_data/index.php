<?php 

    // First we execute our common code to connection to the database and start the session 
    require("../common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: ../index.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can display the user's username to them by reading it from the session array.  Remember that because 
    // a username is user submitted content we must use htmlentities on it before displaying it to the user. 
?> 

<!DOCTYPE>
<html lang="en">

<head>
    <title>Mixtelematics Canbus Data</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="generator"/>
</head>
<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
 
<style>
.tt-query,
.tt-hint {
    width: 396px;
    height: 30px;
    padding: 8px 12px;
    font-size: 16px;
    line-height: 30px;
    border: 2px solid #ccc;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    outline: none;
}

.tt-query {
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
    color: #999
}

.tt-dropdown-menu {
    width: 422px;
    margin-top: 12px;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
    padding: 3px 20px;
    font-size: 16px;
    line-height: 24px;
}

.tt-suggestion.tt-is-under-cursor {
    color: #fff;
    background-color: #0097cf;

}


body {
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#4c4c4c+0,595959+12,666666+25,474747+39,2c2c2c+50,000000+51,111111+60,2b2b2b+76,1c1c1c+91,131313+100;Black+Gloss+%231 */
background: rgb(76,76,76); /* Old browsers */
background: -moz-linear-gradient(-45deg, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(44,44,44,1) 50%, rgba(0,0,0,1) 51%, rgba(17,17,17,1) 60%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg, rgba(76,76,76,1) 0%,rgba(89,89,89,1) 12%,rgba(102,102,102,1) 25%,rgba(71,71,71,1) 39%,rgba(44,44,44,1) 50%,rgba(0,0,0,1) 51%,rgba(17,17,17,1) 60%,rgba(43,43,43,1) 76%,rgba(28,28,28,1) 91%,rgba(19,19,19,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
#loading {
width: 100%;
height: 100%;
   margin: 0;
   padding: 0;
  top: 0;
   left: 0;
  

  
   position: fixed;
  
   opacity: 0.7;
   background-color: #fff;
   z-index: 150;
   text-align: center;
}

#loading-image {
  width: 500px;
  height: 200px;
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
<script>
$(document).ready(function(){
    $("#vehicle").typeahead({
        name : 'search',
        remote: {
            url : 'get_vehicle.php?query=%QUERY'
        }
        
    });
});
</script>

<body>
<div id="loading"  style="display:none;align: center;" >
 <img src="loading_circle.gif" id="loading_image">
</div>
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
                 <li class=""><a href="../schedule/fault_list.php">Fault List</a></li>
                 <li class=""><a href="../schedule/planning.php">Schedule Board</a></li>
                  <li class=""><a href="../health_check/health_check.php">Health Check</a></li>
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





 <div class="container">
    <div class="row">
       <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
        <div class="panel panel-primary" style="width:100%; margin-top:30%;margin-right:30%; margin-left:30%;">
          <div class="panel-heading">
            <h3 class="panel-title">Can Bus Fuel Data</h3>
          </div>
          <div class="panel-body">

          	<form class="form-horizontal" name ="fuel_data" id="fuel_data" action = "fuel_report_investigation.php" method="POST"> 
              <div class="form-group">
                <label for="vehicle" class="col-sm-3 col-xs-3 control-label">Vehicle</label>
                <div class="col-sm-6">
              
                 <input type="text" class=" col-sm-3 col-sm-3 col-xs-3 form-control" name="vehicle" id="vehicle"  placeholder="Enter Truck Fleet number" required="true">  

                </div>
              </div>
             
             
              <div class="form-group">
                <label class="col-sm-3 col-xs-3 control-label">Dates range</label>
                <div class="col-sm-9">
                  <div class="input-daterange" id="datepicker">
                    <div class="input-group">
                         <input  type="text" class="input-small form-control" id="datetimepicker0" name="start_date" placeholder="Enter Trip/Refuel Start" required="true"><br>
                         <span class="input-group-addon">to</span> 
                        <input  type="text" class="input-small form-control" id="datetimepicker1" name="end_date" placeholder="Enter Trip/Refuel End" required="true"><br>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Run</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>


</body>
<script src="../js/jquery.datetimepicker.js"></script>
<script>
window.onerror = function(errorMsg) {
	$('#console').html($('#console').html()+'<br>'+errorMsg)
}
var d = new Date();
$('#datetimepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:	'd'
});

$('#datetimepicker0').datetimepicker({value:'',step:10});
$('#datetimepicker1').datetimepicker({value:'',step:10});

$('.some_class').datetimepicker();

</script>
<script language="javascript" type="text/javascript">
$('#fuel_data').submit(function() {
    $('#loading').show(); // show animation
    return true; // allow regular form submission
});
</script>
</html>