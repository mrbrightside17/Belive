<?php
    require_once("include/DB.php");
    require_once("include/Sessions.php");
    require_once("include/Functions.php");
    Confirm_Login();


    if(isset($_POST["Submit"])){

            $Connection;
            $DeleteFromURL = $_GET['Delete'];
            $query = "DELETE FROM admin_panel WHERE id = '$DeleteFromURL';";
            $result = $Connection->query($query);
            $img = mysqli_real_escape_string($Connection, $_POST["imgName"]);
            if($result){




                if(unlink('../Upload/'.$img)){
                $_SESSION["SuccessMessage"] = "Post Eliminado exitosamente";
                Redirect_to("dashboard.php");
                }else{
                    $_SESSION["ErrorMessage"] = "Algo salió mal";
                    $_SESSION["Post"]= $Post;
                    Redirect_to("dashboard.php");
                }
            }else{
                $_SESSION["ErrorMessage"] = "Algo salió mal";
                $_SESSION["Post"]= $Post;
                Redirect_to("dashboard.php");
            }

    }
 ?>

<!DOCTYPE html>
<html>


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>BE LIVE</title>
        <!-- Style files -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboard.css">

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
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                        </li>
                    </ul>
              </div><!-- End side area-->


              <div class="col-sm-10">
                  <h1>Eliminar Post</h1>
                  <div>
                    <?php
                      $SearchQueryParameter=$_GET['Delete'];
                      $Connection;
                      $Query="SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
                      $res = $Connection ->query($Query);
                        while($DataRows=mysqli_fetch_array($res))
                              {
                                  $NTitle = $DataRows['title'];
                                  $NSection = $DataRows['name'];
                                  $NCategory= $DataRows['category'];
                                  $NImage = $DataRows['image'];
                                  $NPost = $DataRows['post'];

                              }
                      ?>
                  </div>
                  <div class=""> <?php echo Message();echo SuccessMessage();?> </div>
                  <div class="">
                      <form class="" action="DeletePost.php?Delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                          <fieldset>
                              <div class="form-group">
                                  <label for="title"><span class="FieldInfo">Titulo:</span></label>
                                  <input disabled value="<?php echo $NTitle; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Titulo" value="">
                              </div>
                              <div class="form-group">
                              <span class="FieldInfo">Sección Actual:</span>
                                <?php echo $NSection; ?>
                              <br>
                                <label for="sectionselect"><span class="FieldInfo">Nueva Sección:</span></label>
                                  <select disabled class="form-control" id="sectionselect" name="Sub">
                                    <option value="LYFESTYLE">LYFESTYLE</option>
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
                                  <select disabled class="form-control" id="categoryselect" name="Category">
                                      <?php
                                      $sql = "SELECT * FROM category ORDER BY datetime DESC";
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
                                  <input type="text" name="imgName" value="<?php echo $NImage; ?>">

                              </div>
                              <div class="form-group">
                                  <label for="postarea"><span class="FieldInfo">Contenido del Post:</span></label>
                                  <textarea disabled name="Post" id="postarea" rows="8" class="form-control"><?php echo $NPost; ?></textarea>
                              </div>
                              <br>
                              <input class="btn btn-danger btn-block" type="submit" name="Submit" value="Eliminar Post">

                          </fieldset>
                          <br>
                      </form>

                  </div>




              </div> <!--Ending main Area-->
          </div><!--End Row-->
      </div><!--End container-fluid -->
      <footer id="footer">
          <hr><p>&copy; 2018 --- BE LIVE.</p>
          <hr>
      </footer>
      <div style="height:10px; background-color:#27AAE1;">
      </div>

        <!-- script files-->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    </body>
</html>
