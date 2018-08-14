<?php
require_once("include/DB.php");

$body="";


$pestañas = array('LIFESTYLE', 'ENTRETENIMIENTO', 'TENDENCIAS','HOGAR','VIDEOS');

foreach ($pestañas as $key => $value) {
$body.= "<tr style='background-color:#efefef;'>
          <td>
              $value
          </td>
          <td>

          </td>
          <td>
              <label id='$value'  data-toggle='modal' data-target='#myModal' class='btn btn-success'>
                  <i class='glyphicon glyphicon-pencil'></i> Editar Banner
              </label>
          </td>
        </tr>";

        $sql = "SELECT * FROM category WHERE name='$value'";
        $res = $Connection->query($sql);
        while($fila = $res->fetch_assoc()){

            $sub = $fila['category'];
            $body.="<tr>
                      <td>
                      </td>
                      <td>
                          $sub
                      </td>
                      <td>
                          <label id='$sub' class='btn btn-success' data-toggle='modal' data-target='#myModal'>
                              <i class='glyphicon glyphicon-pencil'></i> Editar Banner
                          </label>
                      </td>
                    </tr>";
        }

}

echo $body;


 ?>
