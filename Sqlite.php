<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<?php include 'general.php' ?>
<?php 

$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $temp,
       'file' => '/home/jemima/Grace/test.sqlite',
        'user' => $username,
        'dbname' => $database,
        'host'=> $host,
        'password'=>$password
    )
);















</body>
</html>

