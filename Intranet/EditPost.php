<?php
    require_once("include/DB.php");
    require_once("include/Sessions.php");
    require_once("include/Functions.php");
    Confirm_Login();


    if(isset($_POST["Submit"])){


        $id = mysqli_real_escape_string($Connection, $_POST["Edit"]);
        $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
        $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
        $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);
        $Section = mysqli_real_escape_string($Connection, $_POST["Sub"]);
        $Image = $_FILES["Image"]["name"];
        $no = mysqli_real_escape_string($Connection, $_POST["no"]);

        for($i=0;$i<$no;$i++){
            $img[$i]=mysqli_real_escape_string($Connection, $_POST["lstIMG$i"]);
        }










        if(empty($Image))
            $Image = mysqli_real_escape_string($Connection, $_POST["imgName"]);
        else{
            $Image = changeEspace4_(basename($_FILES["Image"]["name"]));
            $Target = "../Upload/".$Image;
            //$Target = "../Upload/".basename($_FILES["Image"]["name"]);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        }

        if(empty($Title))
        {
            $_SESSION["ErrorMessage"] = "Título no puede estar vacío";
            $_SESSION["Post"]= $Post;
            Redirect_to("EditPost.php","?Edit=$id");
        }elseif( strlen($Title) < 5 ){
            $_SESSION["ErrorMessage"] = "El titulo debe tener al menos 5 letras";
            $_SESSION["Post"]= $Post;
            Redirect_to("EditPost.php","?Edit=$id");
        }elseif(strlen($Post)>9999){
            $_SESSION["ErrorMessage"] = "El post no puede contener más de 10,000 letras";
            $_SESSION["Post"]= $Post;
            Redirect_to("EditPost.php","?Edit=$id");
        }else{
            $GetFromURL = $_GET['Edit'];
            $query = "UPDATE admin_panel SET  title='$Title', name='$Section', category='$Category', image='$Image', post='$Post' WHERE id = '$GetFromURL';";
            $result = $Connection->query($query);

            if($result){
                $_SESSION["SuccessMessage"] = "Post modificado exitosamente";
                Redirect_to("dashboard.php");
            }else{
                $_SESSION["ErrorMessage"] = "Algo salió mal";
                $_SESSION["Post"]= $Post;
                Redirect_to("dashboard.php");
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
        <link rel="stylesheet" href="css/editPOst.css">

    </head>
    <body id="body" >
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
                        <li  class="active">
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
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                        </li>
                    </ul>
              </div><!-- End side area-->


              <div class="col-sm-10">
                  <h1>Editar Post</h1>
                  <div>
                    <?php
                      $SearchQueryParameter=$_GET['Edit'];
                      $Connection;
                      $Query="SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
                      $res = $Connection ->query($Query);
                        while($DataRows=mysqli_fetch_array($res))
                              {
                                  $NTitle = $DataRows['title'];
                                  $Author = $DataRows['author'];
                                  $NSection = $DataRows['name'];
                                  $NCategory= $DataRows['category'];
                                  $NImage = $DataRows['image'];
                                  $NPost = $DataRows['post'];
                                  $Date = $DataRows['datetime'];
                              }
                      ?>
                  </div>
                  <div class=""> <?php echo Message();echo SuccessMessage();?> </div>
                  <div class="">
                      <h1 class="FieldInfo" >Autor: <?php echo $Author; ?></h1>
                      <form class="" action="EditPost.php?Edit=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="Edit" value="<?php echo $SearchQueryParameter; ?>">
                          <fieldset>
                              <div class="form-group">
                                  <label for="title"><span class="FieldInfo">Titulo:</span></label>
                                  <input value="<?php echo $NTitle; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Titulo" value="">
                              </div>
                              <div class="form-group">
                                  <span class="FieldInfo">Sección Actual:</span>
                                    <?php echo $NSection; ?>
                                  <br>
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
                              <span class="FieldInfo">Categoria Actual:</span>
                                <?php echo $NCategory; ?>
                              <br>
                                  <label for="categoryselect"><span class="FieldInfo">Categoría:</span></label>
                                  <select class="form-control" id="categoryselect" name="Category">
                                      <?php
                                      //$sql = "SELECT * FROM category ORDER BY datetime DESC";
                                      $sql = "SELECT * FROM category WHERE name='LIFESTYLE' ORDER BY category ASC";
                                      $res = $Connection->query($sql);
                                      if ($res) {
                                          while ($fila = $res->fetch_array()) {
                                                  $ID = $fila['id'];
                                                  $Section = $fila['category'];
                                        ?>
                                        <option value="<?php echo $Section;?>"><?php echo $Section; ?></option>
                                        <?php
                                          }

                                          /* liberar el conjunto de resultados */
                                          $res->free();
                                      }
                                       ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <span class="FieldInfo">Portada Actual: <br></span>
                                <img src="../Upload/<?php echo $NImage ?>" class="img-thumbnail" width="170px" height="70px">
                              <br>
                                  <label for="imageselect"><span class="FieldInfo">Seleccione una nueva portada:</span></label>
                                  <input type="hidden" name="imgName" value ="<?php echo $NImage; ?>" >
                                  <input type="file" class="form-control" name="Image" id="imageselect">

                              </div>
                              <div class="form-group">
                                  <label for="postarea"><span class="FieldInfo">Contenido del Post:</span></label>
                                  <div class="imagens_actuales">
                                      <h1 class="FieldInfo">Imágenes en el post</h1>
                                      <div class="row">

                                          <div class="imgs">
                                                <?php
                                                    $file = imgInPost($NPost);
                                                    echo "<input name='no' type='hidden' value='".count($file)."'>";

                                                    for($i=0;$i<count($file);$i++){
                                                        $img = $file[$i];
                                                        echo "<div class='col-xs-6 col-sm-2'>";
                                                            echo "<input class='lastIMG' name='lstIMG$i' type='hidden'value='$img'>";
                                                            echo "<div>";
                                                                echo "<img src='../Upload/$img' width='100%'>";
                                                            echo "</div>";
                                                            echo "<p class='des'>";
                                                            if(strlen($img)>15)
                                                                echo substr($img,0,15)."...";
                                                            else {
                                                                echo $img;
                                                            }
                                                            echo"</p>";
                                                        echo"</div>";
                                                        if( ($i+1)%2==0)
                                                        echo "<div class='clearfix hidden-sm hidden-md hidden-lg '></div>";
                                                    }
                                                 ?>
                                          </div>

                                      </div>
                                  </div>
                                   <br>
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

                                  </div>
                                    <br>










                                  <textarea name="Post" id="postarea" rows="8" class="form-control"><?php echo $NPost; ?></textarea>
                              </div>
                              <br>
                              <input class="btn btn-success btn-block" type="submit" name="Submit" value="Guardar Cambios">

                          </fieldset>
                          <br>
                      </form>

                  </div>




              </div> <!--Ending main Area-->
          </div><!--End Row-->
      </div><!--End container-fluid -->
      <footer id="footer">
          <hr><p>&copy; 2018 - <small><small>BE</small></small>LIVE.</p>
          <hr>
      </footer>
      <div style="height:10px; background-color:#27AAE1;">
      </div>

        <!-- script files-->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/actualizar.js"></script>
        <script type="text/javascript" src="js/textArea.js"></script>
    </body>
</html>
