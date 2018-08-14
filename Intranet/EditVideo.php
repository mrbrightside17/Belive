<!-- 16:9 aspect ratio -->

<?php
    require_once("include/DB.php");
    require_once("include/Sessions.php");
    require_once("include/Functions.php");
    Confirm_Login();


    if(isset($_POST["Submit"])){
        $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
        $Post  = mysqli_real_escape_string($Connection,$_POST["Post"]);
        $Url   = mysqli_real_escape_string($Connection,$_POST["Enlace"]);
        $id    = mysqli_real_escape_string($Connection,$_POST["Edit"]);
        $DateTime =  date("d-M -Y H:i:s ");
        $Admin = "Admin";



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
        }else{
            $query = "UPDATE videos SET title='$Title', description='$Post', url='$Url', writer='$Admin' WHERE id=$id LIMIT 1 ";
            $result = $Connection->query($query);

            if($result){
                $_SESSION["SuccessMessage"] = "Cambios guardados con éxito";
                Redirect_to("videos.php");
            }else{
                $_SESSION["ErrorMessage"] = "Algo salió mal";
                $_SESSION["Post"]= $Post;
                Redirect_to("videos.php");
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


                  <h1>Editar video</h1>
                  <div>
                    <?php
                      $SearchQueryParameter=$_GET['Edit'];
                      $Connection;
                      $Query="SELECT * FROM videos WHERE id='$SearchQueryParameter'";
                      $res = $Connection ->query($Query);
                        while($DataRows=mysqli_fetch_array($res))
                              {
                                  $NTitle  = $DataRows['title'];
                                  $NEnlace = $DataRows['url'];
                                  $NPost   = $DataRows['description'];
                                  $Date    = $DataRows['datetime'];
                                  $ID      = $DataRows['id'];
                              }
                      ?>
                  </div>
                  <h3> Autor <?php
                        if($_SESSION["Username"]=="admin")
                            echo htmlentities("BELIVE");
                        else
                            echo htmlentities($_SESSION["Username"]);
                      ?>
                  </h3>
                  <div class=""> <?php echo Message(); echo SuccessMessage();?>
                  </div>
                  <div class="">
                    <form class="" action="EditVideo.php?Edit=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="Edit" value="<?php echo $SearchQueryParameter; ?>">
                      <fieldset>
                        <div class="form-group">
                          <label for="title"><span class="FieldInfo">Título:</span></label>
                            <input value="<?php echo $NTitle; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Titulo" value="">
                          </div>
                          <div class="form-group">
                          <label for="url"><span class="FieldInfo">Enlace del video:</span></label>
                            <input class="form-control" type="url" name="Enlace" id="url" placeholder="Enlace del video" value="<?php echo $NEnlace; ?> ">
                          </div>
                          <div class="form-group">
                          <label for="description"><span class="FieldInfo">Descripción:</span></label>
                              <textarea name="Post" id="postarea" rows="8" class="form-control"><?php echo $NPost; ?></textarea>
                          </div>
                          <input class="btn btn-success btn-block" type="submit" name="Submit" value="Guardar cambios">
                        </fieldset>
                      </form>
                      <br>
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
