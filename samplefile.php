<?php

require "vendor/autoload.php";

$username =$_POST['username'];
$database =$_POST['databasename'];
$password =$_POST['password'];
$host=$_POST['host'];


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
//var_dump($atiaa);
    
// Get the description of the database
    $description = $atiaa->describe();
    //foreach($description as $key => $desc) {
    //  var_dump($desc);
    //}
    
    $data = $atiaa->query('SELECT * FROM categories');
    //var_dump($data) ;
    $col="##FF0000";
echo "<div class='example'>";
echo "<table  class='table' >";
echo "<tr class='header' bgcolor=$col size=15>
            <th> Category ID</th>
            <th>Category Name</th>
            </tr>";

   while($row=$data->fetch_assoc()){
    echo '<tr>
    <td>'.$row[category_id].'</td>
    <td>'.$row[category_name].'</td>

    </tr>';
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
    // Connect to a database
