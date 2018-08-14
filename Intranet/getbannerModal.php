<?php
require_once("include/DB.php");

$id = $_POST['id'];

$body = "";



$sql = "SELECT * FROM banner WHERE id='$id'";


if($res = $Connection->query($sql)){


        $fila = $res->fetch_assoc();
        $img  = $fila['img'];
        $link = $fila['link'];

}

$body.=
"<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h2>Banner <small>$img</small></h2>
    </div>
    <div class='modal-body'>
        <div class='separatorBanner'>
            <figure>
                <img src='anuncios/$img'>
            </figure>
            <input type='hidden' value='$id' id='idBanner'>
            <label for=''>Link</label><input type='text' id='linkBanner' value='$link' placeholder='Escriba la url sin www.'>

        </div>
        <div id='resultadoBanner'></div>
    </div>

    <div class='modal-footer'>
      <button type='button' class='btn btn-primary' id='guardarBanner'>Guardar</button>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>

</div>";

echo $body;



 ?>
