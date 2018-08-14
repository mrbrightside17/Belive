<?php
require_once("include/DB.php");

$id     = $_POST['id'];
$link   = $_POST['link'];

$sql ="UPDATE banner SET link='$link' WHERE id=$id LIMIT 1";

if($Connection->query($sql)){
    echo "<p class='text-success'>Se ha actualizado el link</p>";
}else{
    echo "<p class='text-danger'>Ha ocurrido un error</p>";
}

 ?>
