
<?php
require_once("include/DB.php");
require_once("include/Sessions.php");
require_once("include/Functions.php");
Confirm_Login();
$cat="";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>BE LIVE</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/anuncios.css">

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
                    <li class="">
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
                    <li>
                        <a href="videos.php"><span class="glyphicon glyphicon-film"></span> Videos</a>
                    </li>
                    <li class="active">
                        <a href="anuncios.php"><span class="glyphicon glyphicon-stats"></span> Banners</a>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                    </li>
                </ul>
            </div><!-- end col-sm-2</!-->

            <div class="col-sm-10"> <!--Main Area-->
                <h1>Banners</h1>

            	<div>
                    <?php echo Message();
            	      echo SuccessMessage();
            	    ?>
                </div>
                <div class="preImage">
                    <figure>
                        <img id="blah" src="#" alt="">
                    </figure>
                    <form class="" action="index.html" method="post" enctype="multipart/form-data">
                        <div class="upload-btn-wrapper">
                          <button class="btn btn2">
                              <i class="glyphicon glyphicon-folder-open"> </i><p> Seleccionar un banner</p>
                          </button>
                          <input type="file" name="myfile" id="myfile" accept="image/*"/>
                        </div>
                        <input   type="text" name="nombreBaner" placeholder="Nombre del banner" value="" id="nombre" >
                        <input  type="text" name="nombre" placeholder="Enlace al dar click" value="" id="enlace">
                        <progress value="0" id='upload-progress' ></progress>
                        <div id="resultado"></div>

                        <button type="button" class="btn btn-primary btn-lg" id="enviar" name="enviar">Enviar</button>
                    </form>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>Vista previa</th>
                                    <th>Enlace</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                  </tr>
                                </thead>
                                <tbody id="tablaBanners">




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
<br><br><br><br>
                <div class="row pestañas">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>Pestaña</th>
                                    <th>Subpestaña</th>
                                    <th>Acciones</th>
                                  </tr>
                                </thead>
                                <tbody id="tablaPestañas">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
          </div>


        </div>

        <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
</div>

<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
</div>

        <footer id="footer">
            <hr><p>&copy; 2018 - BE LIVE.</p>
            <hr>
        </footer>
        <div style="height:10px; background-color:#27AAE1;">
        </div>

        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/ajaxAnuncios.js">
        </script>
    </body>
</html>
