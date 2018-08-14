<?php
require_once("include/DB.php");
require_once("include/Sessions.php");
require_once("include/Functions.php");
Confirm_Login();


if(isset($_POST["Submit"])){
        $DateTime =  date("d-M -Y H:i:s ");
        $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
        $Password = "true";
        $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);

        $Admin = "<small><small>BE</small></small>LIVE";

        $validation =   MD5($DateTime);
        if(empty($Username) || empty($Email))
        {
            $_SESSION["ErrorMessage"] = "Todos los campos deben ser llenados";
            Redirect_to("Admins.php");

        }else{
            $query = "INSERT INTO registration(datetime, username, password, email, addedby,validation) VALUES('$DateTime','$Username','$Password','$Email','$Admin','$validation')";
            $result = $Connection->query($query);

            if($result){

                // se puede mandar a distintos correos, separandolos con una coma

                $to = "ciscogonzalezquintero@gmail.com";


                $subject = "Escritor en belive.com.mx";
                $txt = "Un administrador te ha concedido permisos para escribir entradas en la página<br>
                        para asignar su contraseña haga click en el siguiente enlace:<br>
                        <a href='www.belive.com.mx/Intranet/comfirmation?id=$validation'>Click Aquí</a>";

                $headers = "www.belive.com.mx" . "\r\n" ."CC: ".$Email;


                if(mail($to,$subject,$txt,$headers)){
                    $_SESSION["SuccessMessage"] = "Escritor agregado, se ha enviado un correo al email con los datos para acceder";
                    Redirect_to("Admins.php");
                }else{
                    $_SESSION["ErrorMessage"] = "Oops, no hemos podido enviar un correo de confirmacion";
                    Redirect_to("Admins.php");
                }


            }else{
                $_SESSION["ErrorMessage"] = "Oops, algo salió mal";
                Redirect_to("Admins.php");
            }
        }

    }

    if( isset($_GET['pas']) ){
        if(!empty($_GET['pas'])){
            $pass = $_GET['pas'];
            $sql = "SELECT * FROM  registration WHERE id='$pass'";
            $res = $Connection->query($sql);

            if($res){
                $fila = $res->fetch_array();

                $to = $fila['email'];
                $validation = $fila['validation'];


                $subject = "Escritor en belive.com.mx";
                $txt = "Un administrador te ha concedido permisos para escribir entradas en la página<br>
                        para asignar su contraseña haga click en el siguiente enlace:<br>
                        <a href='www.belive.com.mx/Intranet/comfirmation?id=$validation'>Click Aquí</a>";

                $headers = "www.belive.com.mx" . "\r\n" ."CC: ".$Email;

                if(mail($to,$subject,$txt,$headers)){
                    $_SESSION["SuccessMessage"] = "Se ha enviado un correo al email con los datos para acceder";
                    Redirect_to("Admins.php");
                }else{
                    $_SESSION["ErrorMessage"] = "Oops, no hemos podido enviar un correo de confirmacion";
                    Redirect_to("Admins.php");
                }

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
                    <li>
                        <a href="categorias.php"><span class="glyphicon glyphicon-tags"></span> Categor&iacute;as</a>
                    </li>
                    <li class="active">
                        <a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manejar escritores</a>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                    </li>
                </ul>
            </div><!-- end col-sm-2</!-->
            <div class="col-sm-10">
                <h1>Manejo de  Administradores</h1>
              <div class=""> <?php echo Message();echo SuccessMessage();?> </div>
              <div class="">
                  <form class="" action="Admins.php" method="post">
                      <fieldset>
                          <div class="form-group">
                              <div class="form-group">
                              <label for="Username"><span class="FieldInfo">Nombre de usuario:</span></label>
                              <input class="form-control" type="text" name="Username" id="Username" placeholder="Nombre de usuario">
                              </div>
                              <div class="form-group">
                              <label for="Email"><span class="FieldInfo">Email:</span></label>
                              <input class="form-control" type="email" name="Email" id="Email" placeholder="Email">
                              </div>
                          </div>
                          <br>
                          <input class="btn btn-success btn-block" type="submit" name="Submit" value="Añadir Usuario">

                      </fieldset>
                      <br>
                  </form>
              </div>
                <div class="table-responsive">
                    <table class="table table-stripped table-hover">
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Agregado por</th>
                            <th>Fecha de alta</th>
                            <th>Acción</th>
                        </tr>
                            <?php
                            $sql = "SELECT * FROM registration ORDER BY datetime DESC";
                            $res = $Connection->query($sql);
                            if ($res) {

                                while ($fila = $res->fetch_array()) {
                                        $ID = $fila['id'];
                                        $DateTime = $fila['datetime'];
                                        $Username = $fila['username'];
                                        $Email = $fila['email'];
                                        $Creator = $fila['addedby'];
                                ?>
                            <tr>
                                <td><?php echo $Username; ?></td>
                                <td><?php echo $Email; ?></td>
                                <td><?php echo $Creator; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td>
                                	<a href="DeleteAdmin.php?Delete=<?php echo $ID; ?>">
                                	<span class="btn btn-danger">Elminar <span class="glyphicon glyphicon-remove"></span></span>
                                	</a>
                                    <a href="Admins.php?pas=<?php echo $ID; ?>">
                                	<span class="btn btn-warning">Recuperar contraseña <span class="glyphicon glyphicon-cog"></span></span>
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
