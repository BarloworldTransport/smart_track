<!DOCTYPE html>
<html>
<head>
	<title>Schedule Vehicle</title>
	  <link rel="stylesheet" type="text/css" href="../css/pop_style_faults.css">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/bootstrap-select.css">

        
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	 <script src="../js/bootstrap-select.js"></script>  

<script>    
function get_registration () {
 var fleet_number = document.getElementById("unit_fault_fleet_number").value;
    if (fleet_number == "") {
        document.getElementById("unit_fault_registration_number").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	string=xmlhttp.responseText;
            	registration_number=string.substring(0, string.indexOf(';'));
            	fleet_a=string.substr(string.indexOf(";") + 1); 
              	document.getElementById("unit_fault_registration_number").value = registration_number;
                 document.getElementById("unit_fault_fleet").value = fleet_a;
            }
        }
        xmlhttp.open("GET","get_registration.php?fleet_number="+fleet_number,true);
        xmlhttp.send();
    }
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
.schedule_window {
  margin: 70px auto;
  padding: 20px;
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f6f8f9+0,e5ebee+6,e5ebee+11,e5ebee+20,e5ebee+20,e5ebee+24,e5ebee+24,d7dee3+30,d7dee3+30,e5ebee+44,e5ebee+53,d7dee3+63,d7dee3+80,e5ebee+87,f5f7f9+100 */
background: rgb(246,248,249); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(246,248,249,1) 0%, rgba(229,235,238,1) 6%, rgba(229,235,238,1) 11%, rgba(229,235,238,1) 20%, rgba(229,235,238,1) 20%, rgba(229,235,238,1) 24%, rgba(229,235,238,1) 24%, rgba(215,222,227,1) 30%, rgba(215,222,227,1) 30%, rgba(229,235,238,1) 44%, rgba(229,235,238,1) 53%, rgba(215,222,227,1) 63%, rgba(215,222,227,1) 80%, rgba(229,235,238,1) 87%, rgba(245,247,249,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(246,248,249,1) 0%,rgba(229,235,238,1) 6%,rgba(229,235,238,1) 11%,rgba(229,235,238,1) 20%,rgba(229,235,238,1) 20%,rgba(229,235,238,1) 24%,rgba(229,235,238,1) 24%,rgba(215,222,227,1) 30%,rgba(215,222,227,1) 30%,rgba(229,235,238,1) 44%,rgba(229,235,238,1) 53%,rgba(215,222,227,1) 63%,rgba(215,222,227,1) 80%,rgba(229,235,238,1) 87%,rgba(245,247,249,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(246,248,249,1) 0%,rgba(229,235,238,1) 6%,rgba(229,235,238,1) 11%,rgba(229,235,238,1) 20%,rgba(229,235,238,1) 20%,rgba(229,235,238,1) 24%,rgba(229,235,238,1) 24%,rgba(215,222,227,1) 30%,rgba(215,222,227,1) 30%,rgba(229,235,238,1) 44%,rgba(229,235,238,1) 53%,rgba(215,222,227,1) 63%,rgba(215,222,227,1) 80%,rgba(229,235,238,1) 87%,rgba(245,247,249,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9', endColorstr='#f5f7f9',GradientType=0 ); /* IE6-9 */
  border-radius: 5px;
  width: 70%;
  height: 70%;
  position: relative;
  transition: all 5s ease-in-out;
}



#searchinput {
    width: 200px;
}
#searchclear {
    position: absolute;
    right: 5px;
    top: 0;
    bottom: 0;
    height: 14px;
    margin: auto;
    font-size: 14px;
    cursor: pointer;
    color: #ccc;
}

</style>


</head>
<body>
<?php
include "../include/databaselogin.php";
$sr_number=$_GET['sr_number'];
$sql_data=mysqli_query($con,"SELECT * FROM unit_faults WHERE unit_fault_sr_number='$sr_number'");
$get_data=mysqli_fetch_array($sql_data);

?>

<div class="schedule_window">
    <div class="panel panel-primary">
    <div class="panel-heading ">Edit Vehicle Fault</div>
    <div class="panel-body">
        <form class="contact" name="contact">
       
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">SR Number</div>
              <input type="text" class="form-control" id="unit_fault_sr_number" placeholder="Enter Vehicle" name="unit_fault_sr_number" value="<?php echo $get_data['unit_fault_sr_number']; ?>" readonly>
            </div>
        </div>

       <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Fleet Number</div>
               <select id="unit_fault_fleet_number" class=" form-control selectpicker" data-live-search="true" name="unit_fault_fleet_number" onchange="get_registration()" >
              		<option value="<?php echo $get_data['unit_fault_fleet_number']; ?>" selected="<?php echo $get_data['unit_fault_fleet_number']; ?>"><?php echo $get_data['unit_fault_fleet_number']; ?></option>";
                    <?php
                    $sql_fleet=mysqli_query($con,"SELECT fleet_number FROM vehicle");
                    WHILE ($get_fleet=mysqli_fetch_array($sql_fleet))
                      {
                        echo "<option value=".$get_fleet['fleet_number'].">".$get_fleet['fleet_number']."</option>";
                      }
                    ?>
                </select>
            </div>
        </div>


        <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Registration  </div>
               <input type="text" class="form-control" id="unit_fault_registration_number" name="unit_fault_registration_number" value="<?php echo $get_data['unit_fault_registration_number']; ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Fleet  </div>
               <input type="text" class="form-control" id="unit_fault_fleet" name="unit_fault_fleet" value="<?php echo $get_data['unit_fault_fleet']; ?>">
            </div>
        </div>


         <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Unit Type</div>
                 <select id="unit_fault_unit_type" class=" form-control selectpicker" data-live-search="true" name="unit_fault_unit_type">
                 <option value="<?php echo $get_data['unit_fault_unit_type']; ?>" selected="<?php echo $get_data['unit_fault_unit_type']; ?>"><?php echo $get_data['unit_fault_unit_type']; ?></option>";
              
                    <?php
                    $sql_fleet=mysqli_query($con,"SELECT unit_type_name FROM unit_type");
                    WHILE ($get_fleet=mysqli_fetch_array($sql_fleet))
                      {
                        echo "<option value='".$get_fleet['unit_type_name']."'>".$get_fleet['unit_type_name']."</option>";
                      }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Fault Description</div>
                <input type="text" class="form-control" id="unit_fault_fault_desc" name="unit_fault_fault_desc" placeholder="Enter Location" value="<?php echo $get_data['unit_fault_fault_desc']; ?>">
            </div>
        </div>

          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">Comments </div>
              <textarea class="form-control" id="unit_fault_comments" name="unit_fault_comments" rows="3"><?php echo $get_data['unit_fault_comments']; ?></textarea>
            </div>
        </div>

           <div class="form-group">
            <div class="input-group">
                  <div class="input-group-addon">Repair Status</div>
                 <select id="unit_fault_status" class=" form-control selectpicker" data-live-search="true" name="unit_fault_status">
                 <option value="<?php echo $get_data['unit_fault_status']; ?>" selected="<?php echo $get_data['unit_fault_status']; ?>"><?php echo $get_data['unit_fault_status']; ?></option>";
                 <option value="Open">Open</option>";
                 <option value="Scheduled">Scheduled</option>";
                  <option value="Completed">Completed</option>";
              
              
                </select>
            </div>
        </div>

         
 


        </form>
   	


    </div>
     
    </div>
     <button class="btn btn-success" >Update Fault</button>
      <button class="btn btn-primary" onclick="self.close()" >Close</button>
</div>

</body>

</html>




