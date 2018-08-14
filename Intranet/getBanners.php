<?php

require_once('include/DB.php');


$sql = "SELECT * FROM banner";
$res = $Connection->query($sql);
$row="";

while($fila = $res->fetch_assoc()){
$enlace = $fila['link'];
$img    = $fila['img'];
$id     = $fila['id'];

$row.="<tr>
          <td>
              <figure class='vistaPre'>
                  <a href='$enlace' target='_blank'>
                      <img src='anuncios/$img' alt=''>
                  </a>
              </figure>
          </td>
          <td>
              $enlace
          </td>

          <td>
              <p>$img</p>
          </td>

          <td>
              <label id='$id' class='btn btn-warning' data-toggle='modal' data-target='#editModal' >
                  Editar <i class='glyphicon glyphicon-pencil'></i>
              </label>
              <label id='$id' class='btn btn-danger eliminar'>
                  Remover <i class='glyphicon glyphicon-remove'></i>
              </label>
          </td>
        </tr>";
}

echo $row;
 ?>
