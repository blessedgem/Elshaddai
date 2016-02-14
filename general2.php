<!DOCTYPE html>
<html>
<head>
     <title>GemSoft</title>
     <link rel="stylesheet" href="css/bootstrap.css" type="text/css">


   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
   <script src="js/bootstrap.js"></script>
 


</head>
<body>

<div class="container" style="width:100% !important;">


<h1><a href="#">GemSoft </a></h1>
   
<div class="navbar">
<div class="navbar-inner">
<div class="container">
<ul class="nav">
<li><a href="index.php">Home</a></li>


<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Database
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="form.php">Postgres</a></li>
        <li><a href="form.php">MySQL</a></li>
        <li><a href="sqform.php">Sqlite</a></li>
    </ul>
</li>


</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Hadoop
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="ExportParameters.php">Export</a></li>
        <li><a href="form.html">Import</a></li>
        
    </ul>
</li>
   
</ul>
</div>
   </div>
</div>


</div>



<?php

require "vendor/autoload.php";



 
    

$username =$_POST['username'];
$database =$_POST['databasename'];
$password =$_POST['password'];
$host=$_POST['host'];
$tablename=$_POST['tablename'];
$temp = $_POST['databasetype'];

//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $temp,
        'user' => $username,
        'dbname' => $database,
        'host'=> $host,
        'password'=>$password
    )
);
    //Make the query
    $data = $atiaa->query("SELECT * FROM $tablename limit 100");


    
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    
    $columns = array();
    $eliminatedFields = array("user_id","bank_name","description");
    
    $col="#F1F1F1";
    ?>


<form class="form-horizontal" role="form" method="post" action="conditions.php">
    <div class="row">
<div class="span4">
        <label for="ip" class="col-sm-2 control-label">Add New</label>
        <div class="col-sm-10">
             <select multiple name=columntype>
            <?php
        foreach($data[0] as $key => $colName) {
           
            echo "<option value = ".$key.">". ucwords(str_replace("_", " ", $key)) ."</option> ";
            $columns[] = $key;

        }
    ?>  
        </select> 
</div>
    
        </div>
         <button type = "submit" class = "btn btn-primary" style = "vertical-align:bottom;">Generate</button>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <!--Will be used to display an alert to the user-->
        </div>
    </div>
    </div>
   
</form>

<form class="form-horizontal" role="form" method="post" action="conditions.php">
    <div class="row">
<div class="span4">
        <label for="ip" class="col-sm-2 control-label">Conditions</label>
        <div class="col-sm-10">
             <select multiple name=columntype>
            <?php
        foreach($data[0] as $key => $colName) {
           
            echo "<option value = ".$key.">". ucwords(str_replace("_", " ", $key)) ."</option> ";
            $columns[] = $key;

        }
    ?>  
        </select> 
</div>
    
        </div>
         <button type = "submit" class = "btn btn-primary" style = "vertical-align:bottom;">Generate</button>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <!--Will be used to display an alert to the user-->
        </div>
    </div>
    </div>
   
</form>






<table  class='table' >
<tr bgcolor=<?php echo $col; ?> size=15>
    <?php
        foreach($data[0] as $key => $colName) {
           // var_dump(array_search($key, $eliminatedFiels));
            if(array_search($key, $eliminatedFields)) {
                continue;
            }

            echo "<th>". ucwords(str_replace("_", " ", $key)) ."</th>";
            $columns[] = $key;

        }
    ?>            
</tr>


<?php
   foreach($data as $row){
    echo '<tr>';

    foreach($columns as $col) {
        echo '<td>'.$row[$col].'</td>';
    }
    echo '</tr>';

   } 

   echo "</table>";
   echo "</div>";        


    
if (isset($_POST["connect"])) {
        $username = $_POST['username'];
        $database= $_POST['databasename'];
        $password= $_POST['password'];
        $ipaddress=$_POST['ip'];
        
        $subject = 'Connection Information ';
        
       
 
        // Check if name has been entered
        if (!$_POST['username']) {
            $errName = 'Please enter your name';
        }
        
        // Check if email has been entered and is valid
        if (!$_POST[''] || !filter_var($_POST['ip'], FILTER_VALIDATE_IP)) {
            $errIP = 'Please enter a valid ip address';
        }
        
        //Check if message has been entered
        if (!$_POST['databasename']) {
            $errDB = 'Please enter your database name';
        }
        //Check if password is right
        if (!$_POST['password']) {
            $errPSWD = 'Please enter your database password';
        }       
 
// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
    if (mail ($to, $subject, $body, $from)) {
        $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
    } else {
        $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
    }
}
    }

?>
 

</body>
</html>
