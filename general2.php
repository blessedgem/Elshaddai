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
<li><a href="#">Hadoop</a></li>
   
</ul>
</div>
   </div>
</div>


</div>



<?php

require "vendor/autoload.php";


//require_once 'pagination.php';
 
    

$username =$_POST['username'];
$database =$_POST['databasename'];
$password =$_POST['password'];
$host=$_POST['host'];
$tablename=$_POST['tablename'];


//var_dump($_POST);
$temp = $_POST['databasetype'];





$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $temp,
        'user' => $username,
        'dbname' => $database,
        'host'=> $host,
        'password'=>$password
    )
);

    $data = $atiaa->query("SELECT * FROM $tablename limit 100");


    //pagination
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    
    $columns = array();
    $eliminatedFiels = array("user_id","bank_name","description");
    // $pagination  = new pagination( $atiaa, $data );
 
    // $results    = $pagination->getData( $page, $limit );
    //var_dump($data) ;
    $col="#F1F1F1";
    ?>
<table  class='table' >
<tr bgcolor=<?php echo $col; ?> size=15>
    <?php
        foreach($data[0] as $key => $colName) {
           // var_dump(array_search($key, $eliminatedFiels));
            if(array_search($key, $eliminatedFiels)) {
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


    //foreach ($data as $key => $cat) {
    //  echo $cat['category_id'] ;
    //echo $cat['category_name'] , '<br/>';

    
    //}
    //echo $data[0][category_name];
    //echo $data[5][category_name];
    //$data2 = $atiaa->query('SELECT * FROM products WHERE product_id =2 ');
    //echo $data2;

// Perform a query while quoting the literals.
//$data3 = $atiaa->quoteQuery('SELECT "First Name" from "Users Table" ');

    



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
