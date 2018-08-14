<?php
require_once("include/DB.php");

$id = $_POST['id'];
$img  = "";
$link = "";
$latimg  = "";
$latlink = "";
$body = "";
$set  = "notSet";
$latset  = "notSet";


$sql = "SELECT * FROM setBanner WHERE pestana='$id' LIMIT 1";
$latSql = "SELECT * FROM setlateralBanner WHERE pestana='$id'  LIMIT 1";

echo $sql;
if($res = $Connection->query($sql)){

    $id_banner = $res->fetch_assoc()['id_banner'];


    $sql = "SELECT * FROM banner WHERE id=$id_banner";

    if($res = $Connection->query($sql)){
        $fila = $res->fetch_assoc();
        $img  = $fila['img'];
        $link = $fila['link'];
    }
}

if($res = $Connection->query($latSql)){

    $id_banner = $res->fetch_assoc()['id_banner'];

    $sql = "SELECT * FROM banner WHERE id=$id_banner";

    if($res = $Connection->query($sql)){
        $fila = $res->fetch_assoc();
        $latimg  = $fila['img'];
        $latlink = $fila['link'];
    }
}

$body.=
"<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h3 class='modal-title'>$id</h3>
    </div>
    <div class='modal-body'>
    <div class='separatorB'>
    <h4>Banner superior <small></small></h4>
        <div id='imgResult'>

          ";
        if(!empty($img)){
            $set = "Set";
            $body.="
            <figure>
                <a href='$link' targer='_blank'>
                    <img src='anuncios/$img' alt='' />
                </a>
            </figure>";
        }else{
            $body.="
            <p>No se ha seleccionado un banner para esta pestaña</p>
            ";
        }
    $body.="
        </div>
            <div id='bannerOpciones'>
                <input type='hidden' value='$set' id='set' />
                <input type='hidden' value='$id' id='setPestana' />
                <select id='selection'>
                <option value='-1'>Seleccione una opción</option>";

    $sql = "SELECT * FROM banner";
    if($res=$Connection->query($sql)){
        while($fila=$res->fetch_assoc()){
            $option = $fila['img'];
            $id_banner = $fila['id'];

            $body.="<option value='$id_banner'>$option</option>";

        }
    }



    $body.="</select>

            </div>
    </div>







<div class='separatorB'>
<h4>Banner lateral <small></small></h4>
        <div id='imglatResult'>

          ";
        if(!empty($latimg)){
            $latset = "Set";
            $body.="
            <figure>
                <a href='http://$latlink' targer='_blank'>
                    <img src='anuncios/$latimg' alt='' />
                </a>
            </figure>";
        }else{
            $body.="
            <p>No se ha seleccionado un banner lateral para esta pestaña</p>
            ";
        }
    $body.="
        </div>
            <div id='bannerOpciones'>
                <input type='hidden' value='$latset' id='latset' />
                <input type='hidden' value='$id' id='latsetPestana' />
                <select id='latselection'>
                <option value='-1'>Seleccione una opción</option>";

    $sql = "SELECT * FROM banner";
    if($res=$Connection->query($sql)){
        while($fila=$res->fetch_assoc()){
            $option = $fila['img'];
            $id_banner = $fila['id'];

            $body.="<option value='$id_banner'>$option</option>";

        }
    }



    $body.="</select>

            </div>
            </div>
    </div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>

</div>";

echo $body;



 ?>
