<!DOCTYPE html>
<html>
<head>
     <title>GemSoft</title>
     <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="css/conditions.css" type="text/css">


   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/conditions.js"></script>
 


</head>


<body>

<div class="container" style="width:100% !important;">


<h1><a href="#">GemSoft </a></h1>
   
<div class="navbar">
<div class="navbar-inner">
<div class="container">
<ul class="nav">
<li><a href="#">Home</a></li>


<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Database
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="form.html">Postgres</a></li>
        <li><a href="form.html">MySQL</a></li>
        <li><a href="sqform.html">Sqlite</a></li>
    </ul>
</li>


</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Hadoop
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="form.html">Export</a></li>
        <li><a href="form.html">Import</a></li>
        
    </ul>
</li>
   
</ul>
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
    $data = $atiaa->query("SELECT * FROM $tablename limit 10");
    $columnType = $atiaa->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$tablename'");
     
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    
    $columns = array();
    foreach($columnType as $key) {
        $columns[] = ucwords(str_replace("_", " ", $key['column_name']));
        $dataTypes[] = $key['data_type'];
	}

    //$eliminatedFields = array("user_id","bank_name","description");
    
    $col="#F1F1F1";
?>

<script>

	var selectedFields = {};
	var selectedColumns = [];
   	var columns = <?php echo json_encode($columns); ?>;
	var dataTypes = <?php echo json_encode($dataTypes); ?>;
	
</script>
 
<!-- Where the page division goes-->

<!--Div contains the form where columns are displayed -->

<div class="formdiv">

 
<button id="button" onclick="myFunction()"><img src="img/add2.jpeg" alt="Select Column"
		 width="10" height="10" /> 
</button>	


<button class="button1" onclick="myFunction2()"><img src="img/add2.jpeg" alt="Set Condition"
	 	width="10" height="10" /> 
</button>	
</div>

<!--Div contains where the selected columns are displayed -->
<div class="selecteddiv">
	<div class="selected">
		
	</div>

	<div class="conditions">
		
	</div>
</div>

<!--Div contains where other activities are displayed -->
<div class="anotherfield">
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
	?>
</div>

<div class="mask" id="mask_all"></div>




</div>
<div class="popup" id='selection_popup'>
	<div id="accept_selection" ><i class = "fa fa-check"></i></div>
	<div class="close" id="close_selection" >x</div>
</div>

<div class="popup" id='conditions_popup'>
	<div class="close" id="close_condition">x</div>
</div>

</body>
</html>