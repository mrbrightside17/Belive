<?php
require_once("include/DB.php");

$id = $_POST['id'];


$sql = "SELECT * FROM banner WHERE id=$id LIMIT 1";

$res = $Connection->query($sql);

$fila = $res->fetch_assoc();

$img = $fila['img'];

if(file_exists("anuncios/".$img)){
    if(unlink("anuncios/".$img)){
        $sql = "DELETE FROM banner WHERE id=$id LIMIT 1";
        if($Connection->query($sql)){
            $sql = "DELETE FROM setbanner WHERE id_banner=$id";
            $Connection->query($sql);

            $sql = "DELETE FROM setlateralbanner WHERE id_banner=$id";
            $Connection->query($sql);
                echo "ok";
            }
        else {
            echo "error";
        }
    }else{
        echo "No se pudo encontrar el archivo";
    }
}else{
    echo "No encontrado";
}


 ?>
