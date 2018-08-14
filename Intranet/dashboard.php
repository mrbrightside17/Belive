
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
                    <li class="active">
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
                    <li class="">
                        <a href="anuncios.php"><span class="glyphicon glyphicon-stats"></span> Banners</a>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Cerrar Sesión</a>
                    </li>
                </ul>
            </div><!-- end col-sm-2</!-->
            <div class="col-sm-10"> <!--Main Area-->
            	<h1>Tablero del administrador</h1>

            	<div><?php echo Message();
            	      echo SuccessMessage();
            	?></div>

            <div class="table-responsive">
            	<table class="table table-striped table-hover">
            		<tr>
            			<th>No</th>
            			<th>Título</th>
            			<th>Fecha y Hora</th>
            			<th>Fijar al inicio</th>
            			<th>Categoría</th>
            			<th>Imagen</th>
            			<th>Acción</th>
            			<th>Detalles</th>

            		</tr>
            <?php
            $PageIDFromURL =1;
            if(isset($_GET['pag'])&& !empty($_GET['pag']))
                $PageIDFromURL = $_GET['pag'];

            $it = 8*($PageIDFromURL-1);


            $sql  = "SELECT * FROM admin_panel ORDER BY id DESC LIMIT $it,12";//para mostrar el contenido actual
            $sqlc = "SELECT * FROM admin_panel ";//Para obtener el numero total de registros

            /*
            $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc;";
            $Execute=$Connection->query($ViewQuery);/**/

            $res = $Connection->query($sql);
            $resc = $Connection->query($sqlc);

            $count = $resc->num_rows;
            $iterator = ceil($count/8);

            $SrNo=0;
            while($DataRows=mysqli_fetch_array($res)){
            	$Id=$DataRows["id"];
            	$DateTime=$DataRows["datetime"];
            	$Title=$DataRows["title"];
            	$Category=$DataRows["category"];
            	$Admin=$DataRows["author"];
            	$Image=$DataRows["image"];
            	$Post=$DataRows["post"];
                $fijado = $DataRows['fijado'];
            	$SrNo++;
            	?>
            	<tr>

            	<td><?php echo $SrNo; ?></td>
            	<td style="color: #5e5eff;"><?php
            	if(strlen($Title)>19){$Title=substr($Title,0,19).'..';}
            	echo $Title;
            	?></td>
            	<td><?php
            	if(strlen($DateTime)>12){$DateTime=substr($DateTime,0,12);}
            	echo $DateTime;
            	?></td>
            	<td>
                     <?php
                        if($fijado!=0){
                            echo "<input checked type='checkbox' name='fixed' class='fix' id='check$Id' value='$Id'>";
                            echo "<div class='RES' id='res$Id'>";
                                   echo "Fijar";
                            echo "</div>";
                        }else{
                            echo "<input type='checkbox' name='fixed' class='fix' id='check$Id' value='$Id'>";
                            echo "<div class='RES' id='res$Id'>";
                                   echo "Fijar";
                            echo "</div>";
                        }


                      ?>
                    <?php
                    /*
                	if(strlen($Admin)>9){$Admin=substr($Admin,0,9);}
                	echo $Admin;
                    */
                    ?>
                </td>
            	<td><?php
            	if(strlen($Category)>10){$Category=substr($Category,0,10);}
            	echo $Category;
            	?></td>
            	<td><img src="../Upload/<?php echo $Image; ?>" width="120px"; height="80px"></td>

            	<td>
            	<a href="EditPost.php?Edit=<?php echo $Id; ?>">
            	<span class="btn btn-warning">Editar <span class="glyphicon glyphicon-pencil"></span> </span>
            	</a>
            	<a href="DeletePost.php?Delete=<?php echo $Id; ?>">
            	<span class="btn btn-danger">Elminar <span class="glyphicon glyphicon-remove"></span></span>
            	</a>
            	</td>
            	<td>
            	<a href="../FullPost.php?id=<?php echo $Id; ?>" target="_blank">
            	<span class="btn btn-primary"> Vista previa <span class="glyphicon glyphicon-eye-open"></span></span>
            	</a>
            	</td>
            	</tr>


            <?php } ?>






            	</table>
            </div>
            <div class="text-center">
    			<ul class="pagination pagination-lg">
      			<?php
                $url="";
                if(!empty($cat)){
                    $url.="s=$cat&";
                }
                    for($i=1;$i<=$iterator;$i++){
                        $url.="pag=$i";
    						if($i==$PageIDFromURL){
    							echo "<li class='active'><a href='dashboard.php?$url'>$i</a></li>";
                            }
    						 else{
    						 	echo "<li><a href='dashboard.php?$url'>".$i."</a></li>";}

                        $url="";
                        $url.="s=$cat&";
                    }
    				?>
    			</ul>
    	    </div>

                <br><br><br><br><br><br>

            	</div> <!-- Ending of Main Area-->

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
        <script type="text/javascript" src="js/ajax.js">


        </script>
    </body>
</html>
