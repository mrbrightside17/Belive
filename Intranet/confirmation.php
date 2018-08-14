<!-- 16:9 aspect ratio -->

<?php
    require_once("include/DB.php");
    require_once("include/Sessions.php");
    require_once("include/Functions.php");

    if( !isset($_GET['id']) ){
        if(empty($_GET['id'])){
            $_SESSION["ErrorMessage"] = "No posee una llave valida";
            Redirect_to('index.php')
        }else {
            $ID = mysqli_real_escape_string($Connection,$_GET["id"]);

            $sql = "SELECT * FROM registration WHERE validation='$ID'";
            $res = $Connection->query($sql);
        }
    }

    if(isset($_POST["Submit"])){
        $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
        $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
        $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);
        $Section = mysqli_real_escape_string($Connection, $_POST["Sub"]);
        $DateTime =  date("d-M -Y H:i:s ");
        $Admin = "Admin";
        $Image = $_FILES["Image"]["name"];

        $Target = "../Upload/".basename($_FILES["Image"]["name"]);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

        if(empty($Title))
        {
            $_SESSION["ErrorMessage"] = "Título no puede estar vacío";
            $_SESSION["Post"]= $Post;
            Redirect_to("newPost.php");
        }elseif( strlen($Title) < 5 ){
            $_SESSION["ErrorMessage"] = "El titulo debe tener al menos 5 letras";
            $_SESSION["Post"]= $Post;
            Redirect_to("newPost.php");
        }elseif(strlen($Post)>9999){
            $_SESSION["ErrorMessage"] = "El post no puede contener más de 10,000 letras";
            $_SESSION["Post"]= $Post;
            Redirect_to("newPost.php");
        }elseif(empty($Image)){
            $_SESSION["ErrorMessage"] = "El post no puede crearse sin una imagen de portada";
            $_SESSION["Post"]= $Post;
            Redirect_to("newPost.php");
        }else{
            $query = "INSERT INTO admin_panel(datetime, title,name, category, author, image, post) VALUES('$DateTime','$Title','$Section','$Category','$Admin','$Image','$Post')";
            $result = $Connection->query($query);

            if($result){
                $_SESSION["SuccessMessage"] = "Post añadido exitosamente";
                Redirect_to("newPost.php");
            }else{
                $_SESSION["ErrorMessage"] = "Algo salió mal";
                $_SESSION["Post"]= $Post;
                Redirect_to("newPost.php");
            }
        }
    }
 ?>

<!DOCTYPE html>
<html>


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
        <title>BE LIVE</title>
        <!-- Style files -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/newPost.css">

    </head>
    <body>
        <div style="height: 10px; background: #27aae1;"></div>
            <nav class="navbar navbar-inverse" role="navigation">
            	<div class="container">
            		<div class="navbar-header">
                    	<a class="navbar-brand" href="dashboard.php">
                    	   <img style="margin-top: -15px;" src="../img/logo1.png" width=200;height=30;>
                    	</a>
            		</div>
            	</div>
            </nav>
        <div class="Line" style="height: 10px; background: #27aae1;"></div>
        <div class="container-fluid">
            <div class="row">
              <div class="col-sm-2">
                  <br><br>
                    <ul id="side_menu" class="nav nav-pills nav-stacked">
                        <li>
                            <a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> Inicio</a>
                        </li>
                        <li>
                            <a href="newPost.php"><span class="glyphicon glyphicon-list-alt"></span> Añadir Nuevo Post</a>
                        </li>
                        <li>
                            <a href="categorias.php"><span class="glyphicon glyphicon-tags"></span> Categor&iacute;as</a>
                        </li>
                        <!--
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-user"></span> Manejar escritores</a>
                        </li>
                        -->
                        <li class="active">
                            <a href="videos.php"><span class="glyphicon glyphicon-film"></span> Videos</a>
                        </li>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                        </li>
                    </ul>
              </div><!-- End side area-->


              <div class="col-sm-10">
                  <!-- 16:9 aspect ratio -->
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=u9Dg-g7t2l4"></iframe>
                  </div>

                  <!-- 4:3 aspect ratio -->
                  <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=u9Dg-g7t2l4"></iframe>
                  </div>

              </div>
          </div><!--End Row-->
      </div><!--End container-fluid -->
      <footer id="footer">
          <hr><p>&copy; 2018 - BE LIVE.</p>
          <hr>
      </footer>
      <div style="height:10px; background-color:#27AAE1;">
      </div>

        <!-- script files-->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/actualizar.js"></script>
    </body>
</html>
