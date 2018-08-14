<?php

ini_set('post_max_size','100M');  // Tamaño máximo de datos enviados por método POST.

ini_set('upload_max_filesize','100M');   // Tamaño máximo para subir archivos al servidor.

ini_set('max_execution_time','1000');  // Tiempo máximo de ejecución de éste script en segundos.

ini_set('max_input_time','1000'); /*Tiempo máximo en segundos que el script puede usar
para analizar los datos input, sean post,get o archivos.*/



/*
$newName = substr($name, 0, -4);
$Extension = substr($name, -3, strlen($name));


$counter = 0;

$target_dir = "../Upload/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if (file_exists($target_file)) {
    $target_file = $target_dir . $newName.$counter.".".$Extension;
    while(file_exists($target_file)){
        $counter = $counter+1;
        $target_file = $target_dir . $newName. $counter.".".$Extension;
    }
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo sentimos, solo JPG, JPEG, PNG & GIF son permitidos.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Lo sentimos, tu archivo no pudo ser cargado.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        if($counter>0)
            echo "<input type='hidden' value='$newName$counter.$Extension' id='newName'>";
        else {
            echo "<input type='hidden' value='$newName.$Extension' id='newName'>";
        }
        echo "El archivo $newName$counter.$Extension ha sido cargado.";
    } else {
        echo "Oops, hubo un error en la carga, intentelo nuevamente";
    }
}

*/


require_once("include/DB.php");
$file_name =    $_FILES['file']['name'];
$ext = pathinfo($file_name, PATHINFO_EXTENSION);

$nombre =    $_POST['nombre'].".".$ext;
$enlace =    $_POST['enlace'];


$target_file="anuncios/".$nombre;



$sql = "SELECT * FROM banner WHERE img='$nombre'";
$res = $Connection->query($sql);
if($res->num_rows>0){
    echo "El nombre ya existe";
}else if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $sql ="INSERT INTO banner (img, link) VALUES ('".$nombre."','".$enlace."')";
    if($Connection->query($sql)){
        echo "Guardado";
    }else{
        echo "Error";
    }

}else{
    echo "Unknown";
}






 ?>
