<?php
require_once("include/DB.php");

if( isset($_POST["value"]) ){

    $value = $_POST["value"];
    $sql = "SELECT * FROM category WHERE name='$value' ORDER BY category ASC";
    $res = $Connection->query($sql);
    if ( $res) {
        while ($fila = $res->fetch_array()) {
                $category = $fila['category'];
                echo "<option value='$category'>$category</option>";
            }
        }

}
 ?>
