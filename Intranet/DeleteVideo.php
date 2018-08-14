<?php

require_once "include/DB.php";
require_once "include/Functions.php";
require_once "include/Sessions.php";


    if( isset($_GET["Delete"])){
        $id = $_GET["Delete"];
        $sql = "DELETE FROM videos WHERE id = $id";

        if($Connection->query($sql))
            $_SESSION["SuccessMessage"] = "Video eliminado";
        else
            $_SESSION["ErrorMessage"] = "Ocurrió un error";
            
        Redirect_to("videos.php");
    }


 ?>
