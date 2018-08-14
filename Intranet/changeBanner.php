<?php

require_once("include/DB.php");
$id         = $_POST['id'];
$pestana    = $_POST['pestana'];
$set        = $_POST['set'];


if($set=="Set"){
    $sql = "UPDATE setbanner SET id_banner=$id WHERE pestana='$pestana'";
}else{
    $sql = "INSERT INTO setbanner (pestana,id_banner) VALUES ('".$pestana."','".$id."')";
}

if($Connection->query($sql)){
    $sql = "SELECT * FROM banner WHERE id=$id LIMIT 1";
    $fila = $Connection->query($sql)->fetch_assoc();
    $link = $fila['link'];
    $img  = $fila['img'];
echo "<figure>
        <a href='http://$link' targer='_blank'>
            <img src='anuncios/$img' alt='' />
        </a>
    </figure>";
}else{
    echo "Error";
}
 ?>
