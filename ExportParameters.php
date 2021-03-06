<!DOCTYPE html>
<html>

<head>
    <title>GemSoft</title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

   <style>
        .form-group {
            width:100%;
            margin-bottom: 20px;
        }

        .form-group input{
            width:60%;
        }

        .form-group label{
            width:30%;
            margin-right: 20px;
        }

        button{
            margin-left: 19%;
        }
   </style>
</head>

<body>

<div class="container">


    <h1><a href="#">GemSoft </a></h1>
       
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                <li><a href="index.html">Home</a></li>


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

                <li><a href="#">Hadoop</a></li>
                   
                </ul>
            </div>
        </div>
    </div>

    <form class="form-horizontal" role="form" method="post" action="addJob.php">
    <div class="form-group">
        <label for="ip" class="col-sm-2 control-label">Localhost IPAddress</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="ip" name="ipAddress" placeholder="IPAddress" value="">
        </div>
    </div>

    <div class="form-group">
        <label for="ip" class="col-sm-2 control-label">Virtual Machine IPAddress</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="vmhost" name="vmhost" placeholder="VMIP" value="">
        </div>
    </div>


    <div class="form-group">
        <label for="folder" class="col-sm-2 control-label">Folder Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="folder" name="foldername" placeholder="folderName" value="">
        </div>
    </div>

    
    


    <button type = "submit" class = "btn btn-primary">Connect</button>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <!--Will be used to display an alert to the user-->
        </div>
    </div>

</div>


</form>
</body>
</html>


