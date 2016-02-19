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


    <h1><a href="index.php">GemSoft </a></h1>
       
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <ul class="nav">
                <li><a href="index.php">Home</a></li>


                <li><a href="form.php">Database</a></li>
                                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-th-large"></i> Hadoop
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="form.php">Export</a></li>
                        <li><a href="form.php">Import</a></li>
                        
                    </ul>
                </li>
                                   
                </ul>
            </div>
        </div>
    </div>

    <form class="form-horizontal" role="form" method="post" action="conditions.php">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">User Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="usrname" name="username" placeholder="UserName" value="">
            </div>
        </div>
    <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Database Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="dbname" name="databasename" placeholder="DBName" value="">
                </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Table Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="tablename" name="tablename" placeholder="TBName" value="">
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="pswd" name="password" placeholder="password" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="ip" class="col-sm-2 control-label">Host</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="host" name="host" placeholder="host" value="">
        </div>
    </div>


    <div class="form-group">
        <label for="ip" class="col-sm-2 control-label">Select Database</label>
        <div class="col-sm-10">
             <select  name=databasetype>
                <option value="postgresql">Postgresql</option>
                <option value="mysql">Mysql</option>
                <option value="sqlite">Sqlite</option>
            </select> 
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


