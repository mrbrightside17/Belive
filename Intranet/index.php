<?php
require_once("include/DB.php");
require_once("include/Sessions.php");
require_once("include/Functions.php");





if(isset($_POST["Submit"])){
$Username=mysqli_real_escape_string($Connection,$_POST["Username"]);
$Password=mysqli_real_escape_string($Connection,$_POST["Password"]);

if(empty($Username)||empty($Password)){
	$_SESSION["ErrorMessage"]="Todos lo campos deben ser llenados";
	Redirect_to("index.php");

}
else{
	$Found_Account=Login_Attempt($Username,$Password,$Connection);

	$_SESSION["User_Id"]=$Found_Account["id"];
	$_SESSION["Username"]=$Found_Account["username"];
	if($Found_Account){
		$_SESSION["SuccessMessage"] = "Bienvenido  {$_SESSION["Username"]} ";
	Redirect_to("dashboard.php");

	}else{
		$_SESSION["ErrorMessage"]="Usuario/Password inválido";
	Redirect_to("index.php");
	}

}
}


?>

<!DOCTYPE>

<html>
	<head>
		<meta  charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title>Log-in</title>
		<link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
                <link rel="stylesheet" href="../css/bootstrap.min.css">
				
                <script src="../js/jquery-3.2.1.min.js"></script>
                <script src="../js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/dashboard.css">
<style>
	.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
body{
	background-color: #ffffff;
}

</style>

	</head>
	<body>
		<div style="height: 10px; background: #27aae1;"></div>
            <nav class="navbar navbar-inverse" role="navigation">
            	<div class="container">
            		<div class="navbar-header">
                    	<a class="navbar-brand" href="index.php">
                    	   <img style="margin-top: -15px;" src="../img/logo1.png" width=200;height=30;>
                    	</a>
            		</div>
            	</div>
            </nav>
        <div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">

	<div class="col-sm-offset-4 col-sm-4">
		<br><br><br><br>
		<?php echo Message();
	      echo SuccessMessage();
	?>
	<h2>¡BIENVENIDO!</h2>

<div>
<form action="index.php" method="post">
	<fieldset>
	<div class="form-group">
	<label for="Username"><span class="FieldInfo">Usuario:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-envelope text-primary"></span>
	</span>
	<input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
	</div>
	</div>

	<div class="form-group">
	<label for="Password"><span class="FieldInfo">Password:</span></label>
	<div class="input-group input-group-lg">
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-lock text-primary"></span>
	</span>
	<input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
	</div>
	</div>

	<br>
<input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
	</fieldset>
	<br>
</form>

	</div> <!-- Ending of Main Area-->

</div> <!-- Ending of Row-->

</div> <!-- Ending of Container-->


	</body>
</html>
