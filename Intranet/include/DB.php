<?php
    $Connection = new mysqli("localhost:3306","belivec1","fK%_x7SC!n!","belive");
    //mysqli_connect_error();
    date_default_timezone_set("America/Mexico_City");

    // ¡Oh, no! Existe un error 'connect_errno', fallando así el intento de conexión
if ($Connection->connect_errno) {

    // Probemos esto:
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $Connection->connect_errno . "\n";
    echo "Error: " . $Connection->connect_error . "\n";

    exit;
}
 ?>
