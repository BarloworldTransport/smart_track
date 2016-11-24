<?php 
  

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
    
    if(empty($_SESSION['user'])) 
    { 

    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here 
    // to an empty value, which will be shown if the user has not submitted the form. 
    $submitted_username = ''; 
     
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST)) 
    { 
        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                id,
                name,
                surname, 
                username, 
                password, 
                salt, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(); 
        if($row) 
        { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) 
        { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 
             
            // Redirect the user to the private members-only page. 
            header("Location: trip_data/index.php"); 
            die("Redirecting to: trip_data/index.php"); 
        } 
        else 
        { 
            // Tell the user they failed 
           // echo  ("Login Failed."); 


            echo "
              <div class='alert alert-danger fade in'>
    <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    <strong> You have entered the wrong username or password !. </strong>
  </div>
            ";
          

             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Smart Track Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
 <link href='https://fonts.googleapis.com/css?family=Monofett' rel='stylesheet' type='text/css'>
 

<style>
.modal-content {
    background: #3a3a3a;
    -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
    border: 0;
    text-align: left;
}

.modal-header {
    padding: 25px 25px 15px 25px;
    background: #333;
    border: 0;
    -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;
    color: #888;
}

.modal-header .close {
    font-size: 36px;
    color: #eee;
    font-weight: 300;
    text-shadow: none;
    opacity: 1;
}

.modal-title {
    margin-bottom: 10px;
    line-height: 30px;
    color: #eee;
}

.modal-body {
    padding: 25px 25px 30px 25px;
    background: #3a3a3a;
    text-align: left;
    -moz-border-radius: 0 0 4px 4px; -webkit-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;
}

.modal-body img {
    margin-bottom: 15px;
}

.modal-body form textarea {
    height: 100px;
}

.modal-body form .input-error {
    border-color: #399599;
}
.form-group {
    color:white;
}

.nav navbar-nav navbar-right {
    color:white;
}
footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 50px;
  background-color: #f5f5f5;
}
H1 {
 font-family: 'Monofett', cursive; font-weight: 200;
  }

</style>


</head>
<body>

<nav class="navbar navbar-default" role="navigation">
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
        <ul class="nav navbar-nav navbar-left">
      <li><h1>Smart Track</h1></li>
    </ul>

      <ul class="nav navbar-nav navbar-right">
      <li><h2><button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#LoginModal">Click to Login</button></h2></li>
    </ul>
  </div>
</nav>
 


<div class="modal fade" id="LoginModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Smart Track Login</h4>
        </div>
        <div class="modal-body">



          <div class="form-group">
          <form action="index.php" method="post"> 
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="email" placeholder="Enter email" type="email" name="username" value='<?php echo $submitted_username; ?>'>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="password" placeholder="Password" type="password" name="password" value="">
          </div>
        </div>
        <div class="modal-footer">
          <<button type="submit" class="btn btn-primary btn-lg btn-block" >Login</button>
        </div>
      </div>
    </div>
</div>
  </form>
<script>
$('#openBtn').click(function(){
    $('#LoginModal').modal({show:true})
});


</script>

  <footer>
      <div class="container" style="float: left;">
      <h4>
      Smart Track 2016 V1.1
      </h4>
      </div>
    </footer>
 


    </body>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/background.cycle.js"></script>



   <script type="text/javascript">
            $(document).ready(function() {
                $("body").backgroundCycle({
                    imageUrls: [
                        'res/img/bg1.jpg',
                        'res/img/bg2.jpg',
                        'res/img/bg3.jpg',
                        'res/img/bg4.jpg',
                        'res/img/bg5.jpg',
                        'res/img/bg6.jpg',
                        'res/img/bg7.jpg',
                        'res/img/bg8.jpg'
                    ],
                    fadeSpeed: 2000,
                    duration: 3000,
                    backgroundSize: SCALING_MODE_COVER
                });
            });
    </script>

</html>
<?php

}
else
{

     header("Location: trip_data/index.php"); 
}
?>