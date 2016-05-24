<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/slippry.css" type="text/css">
    <link rel="stylesheet" href="css/gem.css" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/slippry.min.js"></script>
   <script>
    $(document).ready(function(){
      $('#slippry').slippry();

      $('#home').width($(window).width());
     $('#home').height($(window).height());
     $('#close').click(function(){
        $('#home').slideUp('slow');
     });
    });


  </script>

  <style>

  #home{
    background-image:url("img/home.jpg");
    background-position: center;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 99999;
  }

  #close{
    display: block;
    margin: 40% auto;
  }

  </style>

   <title>GemSoft</title>
</head>
<body>
<div class="container">


<h1><a href="index.php">GemSoft </a></h1>
   
<div class="navbar">
<div class="navbar-inner">
<div class="container">
<ul class="nav">
<li><a href="index.php">Home</a></li>


<li><a href="form.php">Database</a></li>
<li><a href="form.php">View</a></li>


</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Hadoop
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="sqoopForm.php">Export To Hadoop</a></li>
        <li><a href="tableImportForm.php">Import From Hadoop </a></li>
        
    </ul>
</li>
   
</ul>
</div>
   </div>
</div>

<div  id="dkanui">

<ul id="slippry">
  
  <li>
    <a href="#slide2"><img src="img/gem.png"></a>
  </li>
  <li>
    <a href="#slide1"><img src="img/gem.jpg"></a>
  </li>
</ul>

       
     </div>


     <div id="home">
       <button id="close" type = "submit" class = "btn btn-primary">Next</button>
     </div>
<hr>
<div class="footer">
<p>&copy; 2016</p>
<p>Version 1.0</p>
</div

</div>



</body>
<html>
