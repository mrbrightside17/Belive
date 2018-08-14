<?php
require_once("include/DB.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "UPDATE admin_panel SET fijado=false";

    if($Connection->query($sql)){
        $sql = "UPDATE admin_panel SET fijado=true WHERE id=$id";
        if($Connection->query($sql))
            echo "Fijado";
        else {
            echo $Connection->error;
            }
    }else{
        echo $Connection->error;
    }


}else{
    echo "Error";
}


 ?>
