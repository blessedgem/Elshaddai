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


</div>

<?php

require "general2.php";


?>

<form class="form-horizontal" role="form" method="post" action="conditions.php">
    <div class="row">
<div class="span4">
        <label for="ip" class="col-sm-2 control-label">Selected </label>
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


</body>
</html>