<?php
    require_once("include/DB.php");
    require_once("include/Sessions.php");
    require_once("include/Functions.php");
    Confirm_Login();


    if(isset($_POST["Submit"])){
        $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
        $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
        $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);
        $Section = mysqli_real_escape_string($Connection, $_POST["Sub"]);
        $DateTime =  date("d-M -Y H:i:s ");
        $Admin = "Admin";
        $Image = $_FILES["Image"]["name"];

        $Image = changeEspace4_(basename($_FILES["Image"]["name"]));
        $Target = "../Upload/".$Image;
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
        }elseif(strlen($Post)>19999){
            $_SESSION["ErrorMessage"] = "El post no puede contener más de 20,000 letras";
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
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/newPost.css">

    </head>
    <body id="body">
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
                        <li class="active">
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
                        <li class="">
                            <a href="anuncios.php"><span class="glyphicon glyphicon-stats"></span> Banners</a>
                        </li>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                        </li>
                    </ul>
              </div><!-- End side area-->


              <div class="col-sm-10">
                  <h1>Escribir nuevo Post</h1>
                  <h3>Autor <?php
                              if($_SESSION["Username"]=="admin"){
                                  echo htmlentities("BELIVE");
                              }else
                               echo htmlentities($_SESSION["Username"]);
                            ?>
                  </h3>
                  <div class=""> <?php echo Message();echo SuccessMessage();?> </div>
                  <div class="">
                      <form class="" action="newPost.php" method="post" enctype="multipart/form-data">
                          <fieldset>
                              <div class="form-group">
                                  <label for="title"><span class="FieldInfo">Título:</span></label>
                                  <input class="form-control" type="text" name="Title" id="title" placeholder="Titulo" value="">
                              </div>
                              <div class="form-group">
                                  <label for ="categorySection"><span class = "FieldInfo">Sección:</span></label>
                                  <select class="form-control" id="categorySection" name="Sub">
                                      <option value="LIFESTYLE">LIFESTYLE</option>
                                      <option value="ENTRETENIMIENTO">ENTRETENIMIENTO</option>
                                      <option value="TENDENCIAS">TENDENCIAS</option>
                                      <option value="HOGAR">HOGAR</option>
                                      <option value="EDICION IMPRESA">EDICION IMPRESA</option>
                                  </select>
                              </div>



                              <div class="form-group">
                                  <label for="categoryselect"><span class="FieldInfo">Categoría:</span></label>
                                  <div id="resultado">
                                  </div>

                                  <select class="form-control" id="categoryselect" name="Category">
                                      <?php
                                      $sql = "SELECT * FROM category WHERE name='LIFESTYLE' ORDER BY category DESC";
                                      $res = $Connection->query($sql);
                                      if ($res) {
                                          while ($fila = $res->fetch_array()) {
                                                  $ID = $fila['id'];
                                                  $Name = $fila['name'];
                                                  $category = $fila['category'];
                                        ?>

                                        <?php
                                            if(!empty($category)){
                                                echo "<option value='$category'>$category</option>";
                                            }
                                         ?>

                                        <?php
                                          }

                                          /* liberar el conjunto de resultados */
                                          $res->free();
                                      }
                                       ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="imageselect"><span class="FieldInfo">Seleccione una imagen de portada</span></label>
                                  <input type="file" class="form-control" name="Image" id="imageselect" value="">
                              </div>
                              <div class="form-group">
                                  <label for="postarea"><span class="FieldInfo">Contenido del Post:</span></label>

                                  <div class="">
                                      <div class="controles ">
                                        <div class="dropdown" id="YOU">
                                          <button class="btn btn-default btn-lg dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                              <i class="fa fa-youtube" aria-hidden="true"></i>
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                              <p>URL</p>
                                              <input type="text" name="youtubeURL" id="youtubeURL" placeholder="http://"><br>
                                              <input type="button" name="btnYoutube" id="btnYoutube" value="Insertar">

                                          </div>
                                        </div>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">
                                          <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Colocar una imagen</h4>
                                              </div>
                                              <div class="modal-body">
                                                  <p>
                                                      <input type="file" id="file-input" name="file" value="">
                                                      <label class="btn btn-round btn-success" for="file-input">Seleccionar una imagen <i class="fa fa-plus" aria-hidden="true"></i></label>
                                                      <p id="message"> </p>
                                                  </p>
                                                  <p>
                                                      <progress value="0" id='upload-progress'></progress>
                                                  </p>
                                                 <p>
                                                    <label id="descripcion" for="Descripcion">Descripcion de la imagen</label>
                                                    <input id="information" class="form-control" type="text" name="info" placeholder=""="Descripcion">
                                                 </p>

                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <button id='enviar' type="button" class="btn btn-primary">Insertar Imagen</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>






                                    </div><!-- End controles -->
                                    <br>
                                      <textarea name="Post" id="postarea" rows="8" class="form-control"><?php echo PostMessage(); ?></textarea>
                                  </div>
                              </div>
                              <br>
                              <input class="btn btn-success btn-block" type="submit" name="Submit" value="Añadir nuevo Post">

                          </fieldset>
                          <br>
                      </form>

                  </div>




              </div> <!--Ending main Area-->
          </div><!--End Row-->
      </div><!--End container-fluid -->
      <footer id="footer">
          <hr>
          <p>&copy; 2018 - BE LIVE.</p>
          <hr>
      </footer>
      <div style="height:10px; background-color:#27AAE1;">
      </div>

        <!-- script files-->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/actualizar.js"></script>
        <script type="text/javascript" src="js/textArea.js"></script>
        <!--<script type="text/javascript" src="js/tmpIMG.js"></script>-->
    </body>
</html>
