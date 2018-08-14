<?php
require_once("include/DB.php");
require_once("include/Sessions.php");
require_once("include/Functions.php");
Confirm_Login();


if(isset($_POST["Submit"])){
        $SubCategory = mysqli_real_escape_string($Connection,$_POST["Category"]);
        var_dump($SubCategory);
        $DateTime =  date("d-M -Y H:i:s ");
        $Admin = "Admin";
        $Category = mysqli_real_escape_string($Connection,$_POST["Sub"]);

        if(empty($Category))
        {
            $_SESSION["ErrorMessage"] = "Todos los campos deben ser llenados";
            Redirect_to("categorias.php");
        }elseif( strlen($Category) > 99 ){
            $_SESSION["ErrorMessage"] = "Too long Name for category";
            Redirect_to("categorias.php");
        }else{
            $query = "INSERT INTO category(datetime, name, category, creatorname) VALUES('$DateTime','$Category','$SubCategory','$Admin')";
            $result = $Connection->query($query);

            if($result){
                $_SESSION["SuccessMessage"] = "Category added successfully";
                Redirect_to("categorias.php");
            }else{
                $_SESSION["ErrorMessage"] = "Something went wrong";
                Redirect_to("categorias.php");
            }
        }
    }





?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>BE LIVE</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboard.css">
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
                    <li class="active">
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
            </div><!-- end col-sm-2</!-->
            <div class="col-sm-10">
                <h1>Administrar Categorías</h1>
              <div class=""> <?php echo Message();echo SuccessMessage();?> </div>
              <div class="">
                  <form class="" action="categorias.php" method="post">
                      <fieldset>
                          <div class="form-group">
                              <div>
                                  <label for ="categoryselect"><span class = "FieldInfo">Sección:</span></label>
                                  <select class="form-control" id="categoryselect" name="Sub">
                                      <option value="LIFESTYLE">LIFESTYLE</option>
                                      <option value="ENTRETENIMIENTO">ENTRETENIMIENTO</option>
                                      <option value="TENDENCIAS">TENDENCIAS</option>
                                      <option value="HOGAR">HOGAR</option>
                                      <option value="EDICION IMPRESA">EDICION IMPRESA</option>
                                  </select>
                              </div>
                              <br>
                              <label for="categoryname"><span class="FieldInfo">Categor&iacute;a:</span></label>
                              <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Categoria/etiqueta" value="">

                          </div>
                          <br>
                          <input class="btn btn-success btn-block" type="submit" name="Submit" value="Añadir categoría">

                      </fieldset>
                      <br>
                  </form>
              </div>
                <div class="table-responsive">
                    <table class="table table-stripped table-hover">
                        <tr>
                            <th>Creador</th>
                            <th>Fecha y hora</th>
                            <th>Sección</th>
                            <th>Categoría</th>
                            <th>Acción</th>
                        </tr>
                            <?php
                            $sql = "SELECT * FROM category ORDER BY datetime DESC";
                            $res = $Connection->query($sql);
                            if ($res) {

                                while ($fila = $res->fetch_array()) {
                                        $ID = $fila['id'];
                                        $DateTime = $fila['datetime'];
                                        $Name = $fila['name'];
                                        $Sub = $fila['category'];
                                        $CreatorName = $fila['creatorname'];
                                ?>
                            <tr>
                                <td><?php echo $CreatorName; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $Name; ?></td>
                                <td><?php echo $Sub; ?></td>
                                <td>
                                	<a href="DeleteCategory.php?Delete=<?php echo $ID; ?>">
                                	<span class="btn btn-danger">Elminar <span class="glyphicon glyphicon-remove"></span></span>
                                	</a>
                            	</td>

                            </tr>
                                <?php
                                }

                                /* liberar el conjunto de resultados */
                                $res->free();
                            }
                             ?>
                    </table>
                </div>

          </div> <!--Ending main Area-->
        </div><!--End row-->
        </div>

        <footer id="footer">
            <hr><p>&copy; 2018 - BE LIVE.</p>
            <hr>
        </footer>
        <div style="height:10px; background-color:#27AAE1;">
        </div>

        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    </body>
</html>
